<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Module extends MY_Controller {

    public $data=array();
    public function __construct()
    {
        parent::__construct();
        $this->session->set_userdata('top_menu', 'administrator');
        $this->load->model('Module_model',"module",true);
        if(!is_super_admin())
        {
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
    }
    
    public function index()
    {
        if(!hasPermission("module",VIEW)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        $this->session->set_userdata('sub_menu', 'module');
        $this->layout->title("Module");
        $this->data['add']=true;
        $this->data['all_module']=$this->module->get_all_module();
        // debug_r($this->data['all_module']);
        $this->data['parent_modules']=$this->module->get("permission_group","id,name","name","ASC");
        $this->layout->view("module",$this->data);
    }
     /** ***************Function add**********************************
    * @type            : Function
    * @function name   : add
    * @description     : Process "Module category" add                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */

    public function add()
    {
        if($_POST)
        {
            $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
            $this->form_validation->set_rules('name',"Name", 'trim|required|callback_name');
            $this->form_validation->set_rules('parent',"Parent Name", 'trim|required');
            $this->form_validation->set_rules('position',"Position", 'trim|required');
            $this->form_validation->set_rules('icon',"Icon", 'trim');
            $this->form_validation->set_rules('subparent',"Sub Parent Name", 'trim');
            
            if ($this->form_validation->run() ==TRUE) {
                if(strtolower($this->input->post("name"))!="module")
                {
                    $data['name']=$this->input->post("name");
                    $data['link']=strtolower(str_replace(" ","-",$data['name']));
                    $data['submenu']=$this->input->post("submenu");
                    $data['icon']=$this->input->post("icon");
                    $data['position']=$this->input->post("position");
                    if($this->input->post("subparent"))
                    $data['subparent']=$this->input->post("subparent");
                    $data['short_code']=trim(str_replace(" ","_",strtolower($data['name'])));
                    $data['perm_group_id']=$this->input->post("parent");
                    $insert=$this->module->insert("permission_category",$data);
                    if($insert)
                    {
                        setMessage("msg","success","Module Category Add Sucessfully.");
                    }
                }else{
                    setMessage("msg","danger","This Already Exits");
                }
            } else {
                setMessage("msg","warning",validation_errors());
            }
        }
        redirect("administrator/module");
    }

    public function moduleUpdate()
    {
        if(!hasPermission("module",EDIT)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        $category=array(
            "enable_view"=>"enable_view",
            "enable_add"=>"enable_add",
            "enable_edit"=>"enable_edit",
            "enable_delete"=>"enable_delete",
        );
        $to_be_update = array();
        if($_POST)
        {
             $cat_id=$this->input->post('cat_id');
             foreach ($cat_id as $per_cat_post_key => $module_cat_post_value) {
                $insert_data = array();
                $ar = array();
                foreach ($category as $cat_key => $cat_value) {
                    $chk_val = $this->input->post($cat_value . "-cat_" . $module_cat_post_value);

                    if (isset($chk_val)) {
                        $insert_data[$cat_value] = 1;
                    } else {
                        $ar[$cat_value] = 0;
                    }
                }
                
                    $insert_data['id'] = $module_cat_post_value;
                    $to_be_update[] = array_merge($ar, $insert_data);
                
            }
             $this->module->getInsertBatch($to_be_update);
            setMessage("msg","success","Module Updated Successfully");
            redirect("administrator/module");
        }
    }
    public function edit($id=null,$cat_id=null,$msg=null)
    {
        if($msg=="parent")
        {
            $this->session->set_userdata('sub_menu', 'module');
            $this->layout->title("Module");
            if($_POST)
            {
                $data['name']=$this->input->post("name");
                $data['short_code']=trim(str_replace(" ","_",strtolower($data['name'])));
                $data['link']=strtolower(str_replace(" ","-",$data['name']));
                $data['position']=$this->input->post("position");
                $chek_exit=$this->module->exits_check("permission_group",array("short_code"=>$data['short_code']),$id);
                if(!$chek_exit)
                {
                    $this->module->update("permission_group",$data,array("id"=>$id));
                    $this->module->update("permission_category",$data,array("id"=>$cat_id));
                    setMessage("msg","success","Updated Successfully");
                    redirect("administrator/module");
                }else{
                    setMessage("msg","danger","This Name Already Exits!");
                    redirect("administrator/module/edit/$id/$cat_id/parent");
                }

            }
            $this->data['single']=$this->module->get_single("permission_group",array("id"=>$id));
            $this->data['edit_parent']=true;
            $this->data['cat_id']=$cat_id;
            $this->layout->view("module",$this->data);
        }else{
            if($_POST)
            {
                if(strtolower($this->input->post("name"))!="module")
                {
                    $data['name']=$this->input->post("name");
                    $data['link']=strtolower(str_replace(" ","-",$data['name']));
                    $data['submenu']=$this->input->post("submenu");
                    $data['icon']=$this->input->post("icon");
                    $data['position']=$this->input->post("position");
                    if($this->input->post("subparent"))
                    $data['subparent']=$this->input->post("subparent");
                    $data['short_code']=trim(str_replace(" ","_",strtolower($data['name'])));
                    $data['perm_group_id']=$this->input->post("parent");
                    $chek_exit=$this->module->exits_check("permission_category",array("short_code"=>$data['short_code']),$id);
                    if(!$chek_exit)
                    {
                        $this->module->update("permission_category",$data,array("id"=>$id));
                        setMessage("msg","success","Updated Sucessfully.");
                        redirect("administrator/module");
                    }else{
                        setMessage("msg","danger","This Already Exits");
                        redirect("administrator/module/edit/$id");
                    }
                }else{
                    setMessage("msg","danger","This Already Exits");
                    redirect("administrator/module/edit/$id");
                }
            }
            $this->data['single']=$this->module->get_single("permission_category",array("id"=>$id));
            $this->data['parent_modules']=$this->module->get("permission_group","id,name","name","ASC");
            $this->data['subparent']=$this->module->get_list("permission_category",array("id"=>$this->data['single']->subparent),"","","","","");
            $this->data['edit_submenu']=true;
            $this->layout->view("module",$this->data);
        }
    }
    public function delete($id=null,$cat_id=null,$msg=null)
    {
        if($msg=='parent')
        {
            @$this->module->delete("roles_permissions",array("perm_cat_id"=>$cat_id));
            @$this->module->delete("permission_category",array("perm_group_id"=>$id));
            @$this->module->delete("permission_group",array("id"=>$id));
        }else{
            @$this->module->delete("roles_permissions",array("perm_cat_id"=>$id));
            @$this->module->delete("permission_category",array("subparent"=>$id));
            @$this->module->delete("permission_category",array("id"=>$id));
        }
        setMessage("msg","success","Module Deleted Successfully");
        redirect("administrator/module");
    }
    /** ***************Function name**********************************
    * @type            : Function
    * @function name   : name
    * @description     : Unique check for module name" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function name() {
        if ($this->input->post('id') == '') {
            $name = $this->module->duplicate_check("permission_category","name",$this->input->post('name'));
            if ($name) {
                $this->form_validation->set_message('name', "Module Category Name Aready Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $name = $this->module->duplicate_check("permission_category","name",$this->input->post('name'), $this->input->post('id'));
            if ($name) {
                $this->form_validation->set_message('name', "Module Category Name Aready Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }

    public function control()
    {
        $module_id=$this->input->post("module_id");
        $value=$this->input->post("value");
        $this->module->update("permission_group",array("is_active"=>$value),array("id"=>$module_id));
        echo json_encode($value);
    }
    public function mlist()
    {

        $this->session->set_userdata('sub_menu', 'mlist');
        if ($_POST){
            $short_code_hidden=$this->input->post("short_code_hidden");
            $to_be_update=array();
            foreach ($short_code_hidden as $key => $value) {
                $short_code=$this->input->post("short_code_".$value);
                if($short_code!='')
                {
                    $status=1;
                }else{
                    $status=0;
                }
                $this->module->update("permission_category",array("status"=>$status),array("short_code"=>$value));

            }
            setMessage("msg","success","Module List Updated Successfully");
            redirect("module/mlist");
        }
        $this->layout->title("Module List");
        $this->data['submenu'] = submenu();
        $this->layout->view("module-list",$this->data);
    }
    public function icon()
    {
        $this->session->set_userdata('sub_menu', 'mlist');
        $this->layout->title("Icon");
        $this->layout->view("icon-list");
    }


}

/* End of file Module.php */
