<?php
defined('BASEPATH') or exit('No direct script access allowed');

use chriskacerguis\RestServer\RestController;

/**
 * Class AuthController
 * @property-read ContentModel $content;
 */
class ContentController extends MY_ApiController
{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->model("ContentModel", "content", true);
	}

	public function get_question_list_post()
	{
		$category_id = $this->input->post("category_id");
		$subject_id = $this->input->post("subject_id");
		$section_id = $this->input->post("section_id");
		$topic_id = $this->input->post("topic_id");

		$batch_id = $this->input->post("batch_id");
		$difficulty = $this->input->post("difficulty");

		$question_list = $this->content->get_all_question(QUESTION_PER_PAGE, $category_id, $subject_id, $section_id, $topic_id, $batch_id, $difficulty, $this->id);
		$this->response([
			'status' => true,
			'status_code' => HTTP_OK,
			'message' => ["Question List"],
			"data" => $question_list
		], RestController::HTTP_OK);
	}

	public function get_section_by_subject_post()
	{
		$subject_id = $this->input->post("subject_id");
		$result = $this->content->get_section_by_subject($subject_id);
		$this->response([
			'status' => true,
			'status_code' => HTTP_OK,
			'message' => ["Section List"],
			"data" => $result
		], RestController::HTTP_OK);
	}
	public function get_topic_by_section_post()
	{
		$section_id = $this->input->post("section_id");
		$result = $this->content->get_topic_by_section($section_id);
		$this->response([
			'status' => true,
			'status_code' => HTTP_OK,
			'message' => ["Topic List"],
			"data" => $result
		], RestController::HTTP_OK);
	}

	public function question_reports_post()
	{
		$this->form_validation->set_rules('question_id', 'Question Id', 'trim|xss_clean|required');
		$this->form_validation->set_rules('type', 'Type', 'trim|xss_clean|required');
		$this->form_validation->set_rules('details', 'Details', 'trim|xss_clean|required');
		if ($this->form_validation->run() === TRUE) {
			$this->data['question_id'] = $this->input->post("question_id");
			$this->data['type'] = $this->input->post("type");
			$this->data['details'] = $this->input->post("details");
			$this->data['user_id'] = $this->id;
			$this->content->insert("question_reports", $this->data);
			$this->response([
				'status' => true,
				'status_code' => HTTP_OK,
				'message' => ["Report Sent Successfully "]
			], RestController::HTTP_OK);
		} else {
			custom_validation_error();
		}
	}
	public function question_bookmark_post()
	{
		$this->form_validation->set_rules('question_id', 'Question Id', 'trim|xss_clean|required|callback_question_id');
		$this->form_validation->set_rules('category_id', 'Category Id', 'trim|xss_clean|required');
		if ($this->form_validation->run() === TRUE) {
			$this->data['category_id'] = $this->input->post("category_id");
			$this->data['question_id'] = $this->input->post("question_id");
			$this->data['user_id'] = $this->id;
			$check = $this->content->exits_check("question_bookmark", $this->data);
			if (!$check)
				$this->content->insert("question_bookmark", $this->data);
			$this->response([
				'status' => true,
				'status_code' => HTTP_OK,
				'message' => ["Bookmark Successfully "]
			], RestController::HTTP_OK);
		} else {
			custom_validation_error();
		}
	}
	public function question_unbookmark_post()
	{
		$this->form_validation->set_rules('question_id', 'Bookmark Question', 'trim|xss_clean|required');
		$this->form_validation->set_rules('category_id', 'Category Id', 'trim|xss_clean|required');
		if ($this->form_validation->run() === TRUE) {
			$this->data['category_id'] = $this->input->post("category_id");
			$this->data['question_id'] = $this->input->post("question_id");
			$this->data['user_id'] = $this->id;
			$check = $this->content->exits_check("question_bookmark", $this->data);
			if ($check)
				$this->content->delete("question_bookmark", $this->data);
			$this->response([
				'status' => true,
				'status_code' => HTTP_OK,
				'message' => ["UnBookmark Successfully "]
			], RestController::HTTP_OK);
		} else {
			custom_validation_error();
		}
	}
	public function question_id()
	{
		$question = $this->content->duplicate_check("question", "id", $this->input->post('question_id'));
		if (!$question) {
			$this->form_validation->set_message('question_id', "Question Not Found");
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function get_library_post()
	{
		$category_id = $this->input->post("category_id");
		$subject_id = $this->input->post("subject_id");
		$section_id = $this->input->post("section_id");
		$topic_id = $this->input->post("topic_id");
		$library_data = $this->content->get_all_library($category_id, $subject_id, $section_id, $topic_id);
		if (!empty($library_data)) {
			$condition = array(
				"user_id" => $this->id,
				"category_id" => $category_id,
				"subject_id" => $subject_id,
				"section_id" => $section_id,
				"topic_id" => $topic_id,
			);
			$extra_data = array("created_at" => date("Y-m-d H:i:s"), "views" => 1);
			$inserted_data = array_merge($condition, $extra_data);
			if ($subject_id != '' && $section_id != '') {
				$check_pre_data = $this->content->get_single("recently_learn", $condition);
				if (!empty($check_pre_data)) {
					$last_update = new DateTime($check_pre_data->created_at);
					$now_date_diff = $last_update->diff(new DateTime("now"));
					$minutes = $now_date_diff->days * 24 * 60;
					$minutes += $now_date_diff->h * 60;
					$minutes += $now_date_diff->i;
					$views = $check_pre_data->views + 1;
					if ($minutes > 120) {
						$this->content->update("recently_learn", array("views" => $views, "created_at" => date("Y-m-d H:i:s")), $condition);
					}
				} else {
					$this->content->insert("recently_learn", $inserted_data);
				}
			}
		}
		$this->response([
			'status' => true,
			'status_code' => HTTP_OK,
			'message' => ["Library"],
			"data" => $library_data
		], RestController::HTTP_OK);
	}


	public function get_all_favourite_question_post()
	{
		$page = $this->input->post("page");
		$category_id = $this->input->post("category_id");
		$subject_id = $this->input->post("subject_id");
		$section_id = $this->input->post("section_id");
		$topic_id = $this->input->post("topic_id");
		$batch_id = $this->input->post("batch_id");
		$difficulty = $this->input->post("difficulty");
		$total_rows = $this->content->get_all_favourite_question("", "", $category_id, $this->id, $subject_id, $section_id, $topic_id, $batch_id, $difficulty, true);
		if ($total_rows > 0) {
			$per_page = 10;
			$total_page = ceil($total_rows / $per_page);
			if ($page >= $total_page) {
				$page = $total_page;
				$next_page = 0;
			} elseif ($page <= 0) {
				$page = 1;
				$next_page = 2;
			} else {
				$next_page = $page + 1;
			}
			$offset = ($page - 1) * $per_page;
			$result = $this->content->get_all_favourite_question($per_page, $offset, $category_id, $this->id, $subject_id, $section_id, $topic_id, $batch_id, $difficulty);
			$data['data'] = $result;

			$data['next_page'] = $next_page;
		} else {
			$data['data'] = null;
			$data['next_page'] = 0;
		}
		$this->response([
			'status' => true,
			'status_code' => HTTP_OK,
			'message' => ["Favourite Question"],
			"data" => $data
		], RestController::HTTP_OK);
	}

	public function get_recently_learn_get()
	{
		$category_id = $this->input->get("category_id");
		$result = $this->content->get_recently_learn($this->id, $category_id);
		$this->response([
			'status' => true,
			'status_code' => HTTP_OK,
			'message' => ["Recently Learn "],
			"data" => $result
		], RestController::HTTP_OK);
	}
	public function get_most_popular_get()
	{
		$category_id = $this->input->get("category_id");
		$result = $this->content->get_most_popular($category_id);
		$this->response([
			'status' => true,
			'status_code' => HTTP_OK,
			'message' => ["Most Popular"],
			"data" => $result
		], RestController::HTTP_OK);
	}


	public function user_question_add_post()
	{
		$this->_prepare_validation();
		if ($this->form_validation->run() == TRUE) {
			$data = $this->_get_posted_data();
			$this->content->trans_start();
			$question_insert_id = $this->content->insert('user_question', $data);
			$topic_data['question_id'] = $question_insert_id;
			$topic_data['category_id'] = $this->input->post("category_id");
			$topic_data['topic_id'] = $this->input->post("topic_id");
			$this->content->insert("user_topics_questions", $topic_data);
			$this->content->trans_complete();
			if ($this->content->trans_status()) {
				$this->response([
					'status' => true,
					'status_code' => HTTP_OK,
					'message' => ["Question submitted Successfully, we will review."],
				], RestController::HTTP_OK);
			} else {
				$this->response([
					'status' => true,
					'status_code' => HTTP_INTERNAL_ERROR,
					'message' => ["Internal Error"],
				], RestController::HTTP_OK);
			}
		} else {
			custom_validation_error();
		}
	}

	/** ***************Function name**********************************
	 * @type            : Function
	 * @function name   : name
	 * @description     : Unique check for module name" data/value
	 *
	 * @param           : null
	 * @return          : boolean true/false
	 * ********************************************************** */
	public function title()
	{
		$title = $this->content->duplicate_check("question", "title", $this->input->post('title'));
		if ($title) {
			$this->form_validation->set_message('title', "Question Title Already Exits");
			return FALSE;
		} else {
			$title2 = $this->content->duplicate_check("user_question", "title", $this->input->post('title'));
			if ($title2) {
				$this->form_validation->set_message('title', "Question Title Already Exits");
				return FALSE;
			}
		}
		return TRUE;
	}

	/** ***************Function _prepare_validation**********************************
	 * @type            : Function
	 * @function name   : _prepare_validation
	 * @description     : Process "batch" user input data validation
	 *
	 * @param           : null
	 * @return          : null
	 * ********************************************************** */
	private function _prepare_validation()
	{
		$this->form_validation->set_rules('title', 'Title Required', 'trim|required|callback_title');
		$this->form_validation->set_rules('category_id', 'Category Required', 'trim|required');
		$this->form_validation->set_rules('topic_id', 'Topic Required', 'trim|required');
		$this->form_validation->set_rules('option_a', 'Option A Required', 'trim|required');
		$this->form_validation->set_rules('option_b', 'Option B Required', 'trim|required');
		$this->form_validation->set_rules('option_c', 'Option C Required', 'trim|required');
		$this->form_validation->set_rules('option_d', 'Option D Required', 'trim|required');
		$this->form_validation->set_rules('answer_explain', 'Answer Explain Required', 'trim|required');
	}
	/** ***************Function _get_posted_data**********************************
	 * @type            : Function
	 * @function name   : _get_posted_data
	 * @description     : Prepare "batch" user input data to save into database
	 *
	 * @param           : null
	 * @return          : $data array(); value
	 * ********************************************************** */
	private function _get_posted_data()
	{
		$data = array();
		$data['title'] = $this->input->post("title");
		$data['option_1'] = $this->input->post("option_a");
		$data['option_2'] = $this->input->post("option_b");
		$data['option_3'] = $this->input->post("option_c");
		$data['option_4'] = $this->input->post("option_d");
		$data['answer'] = $this->input->post("answer");
		$data['difficulty'] = $this->input->post("difficulty");
		$data['created_by '] = $this->id;
		$data['answer_explain'] = htmlentities($this->input->post("answer_explain"));
		if (isset($_FILES['picture']['name'])) {
			if ($_FILES['picture']['name'] != '') {
				$image_name = $this->_upload_picture();
				$data['picture'] = "uploads/question/" . $image_name;
			}
		}
		return $data;
	}
	public function _upload_picture()
	{
		$name = $_FILES['picture']['name'];
		$arr = explode('.', $name);
		$ext = end($arr);
		$imageName = APP_NAME . '_' . time() . "Q.$ext";
		$config['upload_path']          = './uploads/question';
		$config['allowed_types']        = 'gif|jpg|jpeg|png';
		$config['file_name']            = $imageName;
		$config['max_size']             = 5120;
		$this->load->library('upload');
		$this->upload->initialize($config);
		if (!$this->upload->do_upload('picture')) {
			$this->response([
				'status' => false,
				'status_code' => 422,
				'message' => [strip_tags($this->upload->display_errors())]
			], RestController::HTTP_OK);
		} else {
			// $this->load->library('image_lib');
			// $config['image_library']  = 'gd2';
			// $config['source_image'] = './uploads/question/' . $imageName;
			// $config['create_thumb']   = FALSE;
			// $config['maintain_ratio'] = TRUE;
			// $config['width']          = 300;
			// $config['height']         = 300;
			// $config['new_image']      = './uploads/question/' . $imageName;
			// $this->image_lib->initialize($config);
			// if ($this->image_lib->resize()) {
			// 	$this->image_lib->clear();
			// }
			return $imageName;
		}
	}
}
