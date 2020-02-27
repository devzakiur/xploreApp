<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Test extends CI_Controller {
    public $data=array();
    
    public function __construct()
    {
        parent::__construct();
    }
    
    public function index()
    {
        echo "Called";
       
    }

}

/* End of file Dashboard.php */
