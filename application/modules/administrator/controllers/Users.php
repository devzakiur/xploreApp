<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 * @property Users_model $users
 */
class Users extends MY_Controller {
    public $data=array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model','users',true);
        $this->session->set_userdata('top_menu', 'administrator');
    }
    /** ***************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Process "Users" user view                 
    *                       
    * @param           : null
    * @return          : null 
    * ********************************************************** */
    public function index()
    {
        if(!hasPermission("manage_user",VIEW)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        $this->session->set_userdata('sub_menu', 'manage-user');
        $this->layout->title("Manage User");
        $this->data['add']=true;
        // debug_r($this->data['all_company']);
        $this->data['roles']=$this->users->get_list("roles",array("name!="=>"Super Admin"),"id,name","","","name","ASC");
        $this->layout->view('administrator/users',$this->data);
    }
    public function add()
    {
        if(!hasPermission("manage_user",ADD)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        if($_POST)
        {
           $this->_prepare_validation();
           if ($this->form_validation->run() ==TRUE) {
                $data=$this->_get_posted_data();
                $insert=$this->users->insert('admin', $data);
                $send_data['msg']="success";
                $send_data['success']="User Add Successfully";
                echo json_encode($send_data);
                exit;
            } else {
                $send_data['msg']=validation_errors();
                echo json_encode($send_data);
                exit;
            }
            redirect('administrator/users');
        }
    }
    //users ajax view
    public function view()
    {
        if($_GET)
        {
            $this->data['all_user']=$this->users->get_user();
            $result=$this->load->view("user-view",$this->data,true);
            echo json_encode($result);
            exit;
        }
    }
    public function edit($id=null)
    {
        if(!hasPermission("manage_user",EDIT)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        $single=$this->users->get_single("admin",array("id"=>$id));
        if(is_super_admin() ||is_admin()){
                
            if(isset($_POST['edit_user']))
            {
            $this->_prepare_validation();
            if ($this->form_validation->run() ==TRUE) {
                    $data=$this->_get_posted_data();
                    $this->users->update('admin', $data,array("id"=>$id));
                    setMessage("msg","success","User Update Sucessfully.");
                } else {
                    setMessage("msg","warning",validation_errors());
                }
                redirect('administrator/users');
            }
            $this->session->set_userdata('sub_menu', 'manage-user');

            $this->layout->title("Manage User");
            $this->data['edit']=true;
            

            $this->data['single']=$single;
            $this->data['roles']=$this->users->get_list("roles",array("name!="=>"Super Admin"),"id,name","","","name","ASC");
            $this->layout->view('administrator/users',$this->data);
        }else{
            show_404();
        }

    }
    public function delete($id = null)
    {
        $result = $this->users->get_single("admin", array("id" => $id));
        $status = 0;
        if (isset($result)) {
            setMessage("msg", "success", "Users Deleted Successfuly");
            $this->users->delete("admin",array("id" => $id));
        }
        redirect('administrator/users');
    }
    public function control($id = null)
    {
        $result = $this->users->get_single("admin", array("id" => $id));
        $status = 0;
        if (isset($result)) {
        	setMessage("msg", "success", "Users Disable Successfuly");
        	if($result->status==0)
			{
				$status=1;
            	setMessage("msg", "success", "Users Enable Successfuly");
			}
            $this->users->update("admin",array("status"=>$status),array("id" => $id));
        }
        redirect('administrator/users');
    }
     /** ***************Function name**********************************
    * @type            : Function
    * @function name   : name
    * @description     : Unique check for module name" data/value                  
    *                       
    * @param           : null
    * @return          : boolean true/false 
    * ********************************************************** */ 
    public function username() {
        if ($this->input->post('id') == '') {
            $username = $this->users->duplicate_check("admin","username",$this->input->post('username'));
            if ($username) {
                $this->form_validation->set_message('username', "User Name Aready Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $username = $this->users->duplicate_check("admin","username",$this->input->post('username'), $this->input->post('id'));
            if ($username) {
                $this->form_validation->set_message('username', "User name Already Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
    
    /** ***************Function _prepare_validation**********************************
     * @type            : Function
     * @function name   : _prepare_validation
     * @description     : Process "batch" user input data validation                 
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    private function _prepare_validation()
    {
        $this->form_validation->set_rules('name', 'Name Required', 'trim|required');
        $this->form_validation->set_rules('phone', 'Phone Required', 'trim|required');
        $this->form_validation->set_rules('role_id', 'Role Required', 'trim|required');
        $this->form_validation->set_rules('username', 'User Name Required', 'trim|required|callback_username');
        if(!$this->input->post("id"))
        {
            $this->form_validation->set_rules('password', 'Password  Required', 'trim|required');
        }
    }
    /** ***************Function _get_posted_data**********************************
     * @type            : Function
     * @function name   : _get_posted_data
     * @description     : Prepare "batch" user input data to save into database                  
     *                       
     * @param           : null
     * @return          : $data array(); value 
     * ********************************************************** */
    private function _get_posted_data()
    {
        $this->load->library('Enc_lib');    
        $data=array();
        $data['name']=$this->input->post("name");
        $data['phone']=$this->input->post("phone");
        $data['role_id']    = $this->input->post('role_id');
        if($this->input->post("id"))
        {
            if($this->input->post("password"))
            {
                $data['password'] = $this->enc_lib->passHashEnc($this->input->post('password'));
            }
        }else{
            $data['password'] = $this->enc_lib->passHashEnc($this->input->post('password'));
        }
        $data['username']      = $this->input->post('username');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['status']     = 1; // by default would not be able to login
        return $data;
    }

}

/* End of file Users.php */
