<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class TestController
 * @property TestModel $test
 */
class TestController extends CI_Controller {

    public function __construct()
    {
    	parent::__construct();
    	$this->load->model("TestModel","test",true);

    }
	public function index()
	{

	}

}

/* End of file TestController.php */
