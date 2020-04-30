<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;

/**
 * Class AuthController
 * @property ModelTestModel $modeltest;
 */
class ModelTestController extends MY_ApiController
{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->model("ModelTestModel","modeltest",true);
	}

	public function check_model_test_get()
	{
		$category_id=$this->input->get("category_id");
		$condition=array(
			"category_id"=>$category_id,
			"status"=>1,
			"date>="=>date("Y-m-d H:i").":00",
		);
		$model_test = $this->modeltest->get_single("model_test",$condition);
		if($model_test)
		{
			$model_test->syllabus=html_entity_decode($model_test->syllabus);
			$register=$this->modeltest->exits_check("model_test_register_users",array("model_test_id"=>$model_test->id,"user_id"=>$this->id));
			$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Model Test"],
				"data"=>[
					"model_test"=>$model_test,
					"register"=>$register
				]
			], RestController::HTTP_OK );
		}else{

			$this->response( [
				'status' => false,
				'status_code' =>404,
				'message' => ["Model Test Not Found"],
				"data"=>null
			], RestController::HTTP_OK );
		}
	}
	public function model_test_register_post()
	{
		$model_test_id=$this->input->post("model_test_id");
		$register=$this->modeltest->exits_check("model_test_register_users",array("model_test_id"=>$model_test_id,"user_id"=>$this->id));
		if(!$register)
		$this->modeltest->insert("model_test_register_users",array("model_test_id"=>$model_test_id,"user_id"=>$this->id));

		$model_test=$this->modeltest->get_single("model_test",array("id"=>$model_test_id));
		if($model_test)
		{
			$model_type_id=0;
			$model_type=$this->modeltest->get_single("game_type",array("type"=>"model_test"));
			if($model_type)
			{
				$model_type_id=$model_type->id;
			}
			$model_question=$this->modeltest->get_model_test_question($model_test->id,$model_test->total_question,$model_test->category_id);
			$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Model Test Question List"],
				"data"=>[
					"question_number"=>$model_test->total_question,
					"duration"=>$model_test->duration,
					"question"=>$model_question,
					"model_type_id"=>$model_type_id
				]
			], RestController::HTTP_OK );

		}else{
			$this->response( [
				'status' => false,
				'status_code' =>404,
				'message' => ["Model Test Not Found"],
				"data"=>null
			], RestController::HTTP_OK );
		}

	}


}
