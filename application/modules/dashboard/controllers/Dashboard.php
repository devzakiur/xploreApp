<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {
    public $data=array();
    
    public function __construct()
    {
        parent::__construct();
        $this->session->set_userdata('top_menu', 'dashboard');
        $this->session->set_userdata('sub_menu',"dashboard");
        $this->session->set_userdata('set_active',"dashboard");
        $this->session->set_userdata("menu_code","dashboard");
        $this->load->model('Dashboard_model',"dashboard",true);
    }
    
    public function index($id=null)
    {
        $this->layout->title("Dashboard");
        $this->layout->view('index',$this->data);
       
    }

}

/* End of file Dashboard.php */
