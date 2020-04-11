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
		$slug=$this->input->get("slug");
		if($slug=="game"){
			$result=$this->game->get_list("game_type",array("type"=>"challenge"),"","","","position","asc");
		}elseif ($slug=="profile"){
			$result=$this->game->get("game_type","","position","asc");
		}else{
			$result=$this->game->get_list("game_type",array("type"=>"challenge"),"","","","position","asc");
		}
		$this->response( [
			'status' => true,
			'status_code' =>HTTP_OK,
			'message' => ["Game Challenge"],
			"data"=>$result
		], RestController::HTTP_OK );
	}

	public function game_finish_post()
	{
		$_POST = json_decode(file_get_contents("php://input"), true);

		$questions=$this->input->post("questions");
		$correct_answer=0;
		$wrong_answer=0;
		$un_answer=0;
		$game_question_data=array();
		$get_challenge_data=$this->game->get_single("game_setting",array("game_type_id"=>$this->input->post("type")));
		$game_table_data['user_id']=$this->id;
		$game_table_data['challenge_id']=$this->input->post("type");
		$game_table_data['total_question']=$get_challenge_data->question_number;
		$game_table_data['total_time']=($this->input->post("time"));
		$game_table_data['total_point']=$get_challenge_data->total_point;
		$game_date=date("Y-m-d H:i:s");
		$game_table_data['created_at']=$game_date;

		$this->game->trans_start();
		$game_table_id=$this->game->insert("game_result",$game_table_data);
		foreach ($questions as $key=>$value)
		{
			if($value['status']===1){
				$correct_answer++;
			}elseif($value['status']===0){
				$wrong_answer++;
			}else{
				$un_answer++;
			}
			$game_question_data[$key]['game_table_id ']=$game_table_id;
			$game_question_data[$key]['question_id']=$value['id'];
			$game_question_data[$key]['subject_id']=$value['subject_id'];
			$game_question_data[$key]['section_id']=$value['section_id'];
			$game_question_data[$key]['topic_id']=$value['topic_id'];
			$game_question_data[$key]['game_time']=($value['time']);
			$game_question_data[$key]['answer']=$value['answer'];
			$game_question_data[$key]['answer_type']=$value['status']===1?"correct":($value['status']===0?"wrong":"noanswer");
		}
		$game_table_data=array();
		$game_table_data['correct_question']=$correct_answer;
		$game_table_data['wrong_question']=$wrong_answer;
		$game_table_data['unanswer_question']=$un_answer;
		$game_table_data['performance']=$this->game->get_percent($get_challenge_data->question_number,$correct_answer);
		$game_table_data['get_point']=$get_challenge_data->correct*$correct_answer-$get_challenge_data->wrong*$wrong_answer;
		$this->game->update("game_result",$game_table_data,array("id"=>$game_table_id));
		$this->game->insert_batch("game_result_question",$game_question_data);
		$this->game->trans_complete();
		if($this->game->trans_status())
		{
			$subject_based=$this->game->get_individual_subject_based_performance($game_table_id);
			$section_based=$this->game->get_individual_section_performance($game_table_id);
			$topic_based=$this->game->get_individual_topic_performance($game_table_id);

			$data['game_id']=$game_table_id;
			$data['correct_answer']=$correct_answer;
			$data['wrong_answer']=$wrong_answer;
			$data['un_answer']=$un_answer;
			$data['total_point']=$get_challenge_data->total_point;
			$data['total_time']=$this->input->post("time");
			$data['total_question']=$get_challenge_data->question_number;
			$data['get_point']=$game_table_data['get_point'];
			$data['game_date']=$game_date;
			$data['subject_based_performance']=$subject_based;
			$data['section_based_performance']=$section_based;
			$data['topic_based_performance']=$topic_based;

			$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Game Finished Data"],
				"data"=>$data
			], RestController::HTTP_OK );
		}else{
			$this->response( [
				'status' => true,
				'status_code' =>HTTP_INTERNAL_ERROR,
				'message' => ["Internal Error"],
			], RestController::HTTP_OK );
		}
	}

	public function game_result_summary_get()
	{
		$game_id=$this->input->get("game_id");

		$game_result=$this->game->get_single("game_result",array("id"=>$game_id,"user_id"=>$this->id));
		if(!empty($game_result))
		{
			$subject_based=$this->game->get_individual_subject_based_performance($game_id);
			$section_based=$this->game->get_individual_section_performance($game_id);
			$topic_based=$this->game->get_individual_topic_performance($game_id);
			$data['game_id']=$game_result->id;
			$data['correct_answer']=$game_result->correct_question;
			$data['wrong_answer']=$game_result->wrong_question;
			$data['un_answer']=$game_result->unanswer_question;
			$data['total_point']=$game_result->total_point;
			$data['total_time']=$game_result->total_time;
			$data['total_question']=$game_result->total_question;
			$data['get_point']=$game_result->get_point;
			$data['game_date']=$game_result->created_at;
			$data['subject_based_performance']=$subject_based;
			$data['section_based_performance']=$section_based;
			$data['topic_based_performance']=$topic_based;

				$this->response( [
					'status' => true,
					'status_code' =>HTTP_OK,
					'message' => ["Game Finished Data"],
					"data"=>$data
				], RestController::HTTP_OK );
		}else{
			$this->response( [
					'status' => true,
					'status_code' =>HTTP_OK,
					'message' => ["Game Finished Data"],
					"data"=>[]
				], RestController::HTTP_OK );
		}
	}

	public function get_subject_performance_get()
	{
		$game_id=$this->input->get("game_id");
		$result=$this->game->get_subject_based_performance($game_id);
		$this->response( [
			'status' => true,
			'status_code' =>HTTP_OK,
			'message' => ["Subject Based Performance"],
			"data"=>$result
		], RestController::HTTP_OK );
	}

	public function performance_summary_get()
	{
		$game_result=$this->game->performance_summary($this->id);
		$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Performance Summary"],
				"data"=>$game_result
			], RestController::HTTP_OK );
	}

	public function performance_history_get()
	{
		$limit=$this->input->get("limit");
		$result= $this->game->performance_history($this->id,$limit);
		$this->response( [
			'status' => true,
			'status_code' =>HTTP_OK,
			'message' => ["Performance History"],
			"data"=>$result
		], RestController::HTTP_OK );
	}

	public function get_game_solution_post()
	{
		$slug=$this->input->post("slug");
		$page=$this->input->post("page");
		$game_id=$this->input->post("game_id");
		$type=$this->input->post("type");
		$subject_id=$this->input->post("subject_id");
		$section_id=$this->input->post("section_id");
		$topic_id=$this->input->post("topic_id");
		$difficulty=$this->input->post("difficulty");
		$total_rows=$this->game->get_game_solution("","",$this->id,$game_id,$type,$subject_id,$section_id,$topic_id,$difficulty,$slug,true);
		if($total_rows>0)
		{
			$per_page=10;
			$total_page=ceil($total_rows/$per_page);
			if ($page>=$total_page)
			{
				$page=$total_page;
				$next_page=0;
			}elseif($page<=0)
			{
				$page=1;
				$next_page=2;
			}
			else{
				$next_page=$page+1;
			}
			$offset=($page-1)*$per_page;
			$result=$this->game->get_game_solution($per_page,$offset,$this->id,$game_id,$type,$subject_id,$section_id,$topic_id,$difficulty,$slug);
			$data['data']=$result;

			$data['next_page']=$next_page;
		}
		else{
			$data['data']=null;
			$data['next_page']=0;
		}
			$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Game Solution"],
				"data"=>$data
			], RestController::HTTP_OK );
	}

}
