<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Administrator extends MY_Controller {

    public $data=array();
    public function __construct()
    {
        parent::__construct();
        $this->session->set_userdata('set_active', "administrator");
        $this->session->set_userdata('top_menu', 'administrator');
        $this->session->set_userdata('sub_menu', 'administrator');
    }
    
    public function index($id=null)
    {
        if(!hasPermission("administrator",VIEW)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        $this->data['msg']="Welcome To Administrator";
        $this->layout->title("Administrator");
        // debug_r($result);
        $this->layout->view('administrator/welcome',$this->data);
    }

}

/* End of file Administrator.php */
