<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;

/**
 * Class AuthController
 * @property Ajax_model $ajax;
 */
class AuthController extends MY_ApiController
{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->model("Ajax_model","ajax",true);
	}

	public function categry_list_get()
	{
		$category_list=$this->ajax->get_list("category",array("status"=>1));
			$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Category List"],
				"data"=>$category_list
			], RestController::HTTP_OK );
	}
	public function subject_by_category_get()
	{
		$category_id=$this->input->get("category_id");
		$check=$this->ajax->exits_check("category",array("id"=>$category_id,"subject_show"=>1));
		if(!$check)
		{
			$subject_list=[];
		}
		else{
			$subject_list=$this->ajax->get_subject_by_category($category_id);
		}
		$this->response( [
			'status' => true,
			'status_code' =>HTTP_OK,
			'message' => ["Subject List"],
			"data"=>$subject_list
		], RestController::HTTP_OK );
	}
}