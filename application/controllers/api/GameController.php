<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;

/**
 * Class AuthController
 * @property GameModel $game;
 */
class GameController extends MY_ApiController
{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->model("GameModel","game",true);
	}

	public function get_game_question_post()
	{
		$this->form_validation->set_rules('category_id', 'Category Id', 'trim|required|xss_clean');
		$this->form_validation->set_rules('game_type_id', 'Game Type', 'trim|required|xss_clean|callback_game_type_id');
		if($this->form_validation->run() === TRUE) {
			$game_type_id=$this->input->post("game_type_id");
			$category_id=$this->input->post("category_id");
			$game_setting=$this->game->get_single("game_setting",array("game_type_id"=>$game_type_id));
			if($game_setting)
			{
				$result=$this->game->game_question($game_setting->question_number,$category_id);
				$this->response( [
					'status' => true,
					'status_code' =>HTTP_OK,
					'message' => ["Game Question List"],
					"data"=>[
						"question_number"=>$game_setting->question_number,
						"game_time"=>$game_setting->game_time,
						"question"=>$result
					]
				], RestController::HTTP_OK );
			}else
			{
				$this->response( [
					'status' => true,
					'status_code' =>HTTP_NOT_FOUND,
					'message' => ["No Setting Found"],
				], RestController::HTTP_OK );
			}
		}
		else{
			custom_validation_error();
		}

	}

	public function game_type_id()
	{
		$exit = $this->game->exits_check("game_type",array("id"=>$this->input->post("game_type_id"),"type"=>"challenge"));
		if ($exit) {
			return true;
		} else {
			$this->form_validation->set_message('game_type_id', "Game Challenge Not Found");
			return false;
		}
	}

	public function game_challenge_get()
	{
		$result=$this->game->get_list("game_type",array("type"=>"challenge"),"","","","position","asc");
		$this->response( [
			'status' => true,
			'status_code' =>HTTP_OK,
			'message' => ["Game Challenge"],
			"data"=>$result
		], RestController::HTTP_OK );
	}

}
