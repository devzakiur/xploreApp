<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;

/**
 * Class AuthController
 * @property ContentModel $content;
 */
class ContentController extends MY_ApiController
{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->model("ContentModel","content",true);
	}

	public function get_question_list_post()
	{
		$category_id=$this->input->post("category_id");
		$subject_id=$this->input->post("subject_id");
		$section_id=$this->input->post("section_id");
		$topic_id=$this->input->post("topic_id");
		$question_list= $this->content->get_all_question(QUESTION_PER_PAGE,$category_id,$subject_id,$section_id,$topic_id,$this->id);
		$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Question List"],
				"data"=>$question_list
			], RestController::HTTP_OK );
	}

	public function get_section_by_subject_post()
    {
		$subject_id=$this->input->post("subject_id");
		$result=$this->content->get_section_by_subject($subject_id);
		$this->response( [
			'status' => true,
			'status_code' =>HTTP_OK,
			'message' => ["Section List"],
			"data"=>$result
		], RestController::HTTP_OK );
    }
    public function get_topic_by_section_post()
    {
            $section_id=$this->input->post("section_id");
            $result=$this->content->get_topic_by_section($section_id);
			   $this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Topic List"],
				"data"=>$result
			], RestController::HTTP_OK );
    }

	public function question_reports_post()
	{
		$this->form_validation->set_rules('question_id', 'Question Id', 'trim|xss_clean|required');
		$this->form_validation->set_rules('type', 'Type', 'trim|xss_clean|required');
		$this->form_validation->set_rules('details', 'Details', 'trim|xss_clean|required');
		if($this->form_validation->run() === TRUE) {
			$this->data['question_id']=$this->input->post("question_id");
			$this->data['type']=$this->input->post("type");
			$this->data['details']=$this->input->post("details");
			$this->data['user_id']=$this->id;
			$this->content->insert("question_reports",$this->data);
			$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Report Sent Successfully "]
			], RestController::HTTP_OK );

		}else{
			custom_validation_error();
		}
    }
	public function question_bookmark_post()
	{
		$this->form_validation->set_rules('question_id', 'Question Id', 'trim|xss_clean|required|callback_question_id');
		if($this->form_validation->run() === TRUE) {
			$this->data['question_id']=$this->input->post("question_id");
			$this->data['user_id']=$this->id;
			$check=$this->content->exits_check("question_bookmark",$this->data);
			if(!$check)
				$this->content->insert("question_bookmark",$this->data);
				$this->response( [
					'status' => true,
					'status_code' =>HTTP_OK,
					'message' => ["Bookmark Successfully "]
				], RestController::HTTP_OK );

		}else{
			custom_validation_error();
		}
    }
	public function question_id(){
		$email = $this->content->duplicate_check("question","id",$this->input->post('question_id'));
		if (!$email) {
			$this->form_validation->set_message('question_id', "Question Not Found");
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function get_library_post()
	{
		$category_id=$this->input->post("category_id");
		$subject_id=$this->input->post("subject_id");
		$section_id=$this->input->post("section_id");
		$topic_id=$this->input->post("topic_id");
		$library_data= $this->content->get_all_library($category_id,$subject_id,$section_id,$topic_id);
		if(!empty($library_data))
		{
			$condition=array(
				"user_id"=>$this->id,
				"category_id"=>$category_id,
				"subject_id"=>$subject_id,
				"section_id"=>$section_id,
				"topic_id"=>$topic_id,
			);
			$extra_data=array("created_at"=>date("Y-m-d H:i:s"),"views"=>1);
			$inserted_data=array_merge($condition,$extra_data);
			$check_pre_data=$this->content->get_single("recently_learn",$condition);
			if(!empty($check_pre_data))
			{
				$last_update=new DateTime($check_pre_data->created_at);
				$now_date_diff=$last_update->diff(new DateTime("now"));
				$minutes = $now_date_diff->days * 24 * 60;
				$minutes += $now_date_diff->h * 60;
				$minutes += $now_date_diff->i;
				$views=$check_pre_data->views+1;
				if($minutes>120)
				{
					$this->content->update("recently_learn",array("views"=>$views,"created_at"=>date("Y-m-d H:i:s")),$condition);
				}
			}else{
				$this->content->insert("recently_learn",$inserted_data);
			}
		}
		$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Library"],
				"data"=>$library_data
			], RestController::HTTP_OK );
	}

	public function get_recently_learn_get()
	{
		$result=$this->content->get_recently_learn($this->id);
		$this->response( [
			'status' => true,
			'status_code' =>HTTP_OK,
			'message' => ["Recently Learn "],
			"data"=>$result
		], RestController::HTTP_OK );
	}
	public function get_most_popular_get()
	{
		$category_id=$this->input->get("category_id");
		$result=$this->content->get_most_popular($category_id);
		$this->response( [
			'status' => true,
			'status_code' =>HTTP_OK,
			'message' => ["Most Popular"],
			"data"=>$result
		], RestController::HTTP_OK );
	}


}
