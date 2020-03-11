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

}
