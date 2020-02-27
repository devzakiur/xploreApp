<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends MY_Controller {

    public $data=array();
    public function __construct()
    {
        parent::__construct();
        $this->session->set_userdata('set_active', "setting");
    }
    
    public function index()
    {
        $this->layout->view('setting/welcome',$this->data);
    }

}

/* End of file Setting.php */
