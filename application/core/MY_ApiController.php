<?php
error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
class MY_ApiController extends RestController
{
	public $id="";
	public function __construct($config = 'rest')
	{
		date_default_timezone_set("Asia/Dhaka");
		parent::__construct($config);

		$this->id=verify_request();
	}
}
