<?php
error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
class MY_ApiController extends RestController
{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
	}
}
