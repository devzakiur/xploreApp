<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Role extends MY_Controller {
    public $data=array();
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Role_model',"role",true);
        $this->session->set_userdata('top_menu', 'administrator');
        $this->session->set_userdata('sub_menu', 'role-permission');
    }
    /** ***************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Process "Role" view                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index()
    {
        if(!hasPermission("role_permission",VIEW)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }

        $this->layout->title("Add Role");
        $this->data['add']=true;
        $this->data['role']=$this->role->get("roles");
        $this->layout->view('administrator/role',$this->data);
    }
    public function add()
    {
        if(!hasPermission("role_permission",ADD)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        if($_POST)
        {
            $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
            $this->form_validation->set_rules('name',"Name", 'trim|required|callback_name');
            
            if ($this->form_validation->run() ==TRUE) {
                $data['name']=$this->input->post("name");
                $data['type']="custom";
                $insert=$this->role->insert("roles",$data);
                if($insert)
                {
                    setMessage("msg","success","Role Add Sucessfully.");
                }
            } else {
                setMessage("msg","warning",validation_errors());
            }
        }
        redirect("administrator/role");
    }
    /** ***************Function edit**********************************
    * @type            : Function
    * @function name   : edit
    * @description     : Process "Role" edit                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */

    public function edit($id)
    {
        if(!hasPermission("role_permission",EDIT)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        $this->data['single_role']=$this->role->get_single("roles",array('id'=>$id));
        if(isset($this->data['single_role'])>0)
        {
            if($_POST)
            {
                $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
                $this->form_validation->set_rules('name',"Name", 'trim|required|callback_name');
                
                if ($this->form_validation->run() ==TRUE) {
                    $data['name']=$this->input->post("name");
                    $this->role->update("roles",$data,array("id"=>$id));
                    setMessage("msg","success","Role Updated Sucessfully.");
                    redirect("administrator/role");
                } else {
                    setMessage("msg","warning",validation_errors());
                }
            }
            $this->session->set_userdata('sub_menu', 'role-permission');

            $this->layout->title("Edit Role");
            $this->data['edit']=true;
            $this->data['role']=$this->role->get("roles");
            $this->layout->view('administrator/role',$this->data);
        }
        else
        {
            setMessage("msg","danger","No Role Found");
            redirect("administrator/role");
        }
    }
    /** ***************Function delete**********************************
    * @type            : Function
    * @function name   : delete
    * @description     : Process "Role" delete                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function delete($id=null)
    {
        if(!hasPermission("role_permission",DELETE)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        $this->data['single_role']=$this->role->get_single("roles",array('id'=>$id));
        if(isset($this->data['single_role'])>0)
        {
           @$this->role->delete("roles",array("id"=>$id));
           @$this->role->delete("roles_permissions",array("role_id"=>$id));
           setMessage("msg","success","Role Deleted Successfully.");
        }
        else
        {
            setMessage("msg","danger","No Role Found.");
        }
        redirect("administrator/role");
    }
    public function permission($id)
    {
        if(!hasPermission("assign_permission",VIEW)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        $this->layout->title('Assign Permission');
        $this->session->set_userdata('sub_menu', 'role-permission');
        $this->data['role_name']=$this->role->get_single("roles",array("id"=>$id))->name;
        if(($this->data['role_name']!="Super Admin" && $this->data['role_name']!="Admin" && $this->data['role_name']!=logged_in_role_name())||is_super_admin())
        {
            $role_id=$id;
            $permssion=array(
                "can_view"=>"can_view",
                "can_add"=>"can_add",
                "can_edit"=>"can_edit",
                "can_delete"=>"can_delete",
            );
            $to_be_insert = array();
            $to_be_update = array();
            $to_be_delete = array();
            if($_POST)
            {
             $per_cat_post = $this->input->post('per_cat');
                $role_id = $id;
                $to_be_insert = array();
                $to_be_update = array();
                $to_be_delete = array();
                foreach ($per_cat_post as $per_cat_post_key => $per_cat_post_value) {
                    $insert_data = array();
                    $ar = array();
                    foreach ($permssion as $per_key => $per_value) {
                        $chk_val = $this->input->post($per_value . "-perm_" . $per_cat_post_value);
    
                        if (isset($chk_val)) {
                            $insert_data[$per_value] = 1;
                        } else {
                            $ar[$per_value] = 0;
                        }
                    }
    
                    $prev_id = $this->input->post('roles_permissions_id_' . $per_cat_post_value);
                    if ($prev_id != 0) {
    
                        if (!empty($insert_data)) {
                            $insert_data['id'] = $prev_id;
                            $to_be_update[] = array_merge($ar, $insert_data);
                        } else {
                            $to_be_delete[] = $prev_id;
                        }
                    } elseif (!empty($insert_data)) {
                        $insert_data['role_id'] = $id;
                        $insert_data['perm_cat_id'] = $per_cat_post_value;
                        $to_be_insert[] = array_merge($ar, $insert_data);
                    }
                }
                $this->role->getInsertBatch($role_id, $to_be_insert, $to_be_update, $to_be_delete);
                setMessage("msg","success","Permission Updated Successfully");
             redirect("administrator/role");
            }
            $this->data['single_role']=$this->role->get_single("roles",array('id'=>$id));
            if(isset($this->data['single_role'])>0)
            {
            $this->data['title']="Permission";
            $this->data['role_id']=$id;
            $this->data['permission_list']=$this->role->get_permission_list($id);
            $this->layout->view('administrator/permission',$this->data);
            }
            else
            {
                setMessage("msg","danger","No Role Found.");
                redirect("administrator/role");
            }

        }else{
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
    }
    /** ***************Function name**********************************
    * @type            : Function
    * @function name   : name
    * @description     : Unique check for role role" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function name() {
        if ($this->input->post('id') == '') {
            $name = $this->role->duplicate_check("roles","name",$this->input->post('name'));
            if ($name) {
                $this->form_validation->set_message('name', "Role Name Aready Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $name = $this->role->duplicate_check("roles","name",$this->input->post('name'), $this->input->post('id'));
            if ($name) {
                $this->form_validation->set_message('name', "Role Name Aready Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }

}

/* End of file Role.php */
