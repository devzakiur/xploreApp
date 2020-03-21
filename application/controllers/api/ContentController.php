<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;

/**
 * Class AuthController
 * @property ContentModel $content;
 */
class ContentController extends MY_ApiController
{
	public $id;
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->model("ContentModel","content",true);
		$this->id=verify_request();
	}

	public function get_question_list_post()
	{
		$category_id=$this->input->post("category_id");
		$subject_id=$this->input->post("subject_id");
		$section_id=$this->input->post("section_id");
		$topic_id=$this->input->post("topic_id");
		$question_list= $this->content->get_all_question(QUESTION_PER_PAGE,$category_id,$subject_id,$section_id,$topic_id);
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
		$this->form_validation->set_rules('question_id', 'Question Id', 'trim|xss_clean|required');
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

	public function get_library_post()
	{
		$category_id=$this->input->post("category_id");
		$subject_id=$this->input->post("subject_id");
		$section_id=$this->input->post("section_id");
		$topic_id=$this->input->post("topic_id");
		$library_data= $this->content->get_all_library($category_id,$subject_id,$section_id,$topic_id);
		$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Library"],
				"data"=>$library_data
			], RestController::HTTP_OK );
	}


}
