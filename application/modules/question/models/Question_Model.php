<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Question_Model extends MY_Model
{
	public function get_assign_topic_list()
	{
		$this->db->select('T.*');
		$this->db->from('topic_assign as TA');
		$this->db->join('topic as T', 'TA.topic_id = T.id', 'left');
		$this->db->group_by('TA.topic_id');
		return $this->db->get()->result_array();
	}

	public function get_assign_subject_list()
	{
		$this->db->select('S.*');
		$this->db->from('subject_assign as SA');
		$this->db->join('subject as S', 'SA.subject_id = S.id', 'left');
		$this->db->group_by('SA.subject_id');
		return $this->db->get()->result_array();
	}
	public function get_topic_relation($topic_id)
	{
		$this->db->select('S.name as section_name,SB.name as subject_name,C.name as category_name,C.id as category_id');
		$this->db->from('topic_assign as TA');
		$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
		$this->db->join('section as S', 'SA.section_id = S.id', 'left');
		$this->db->join('subject_assign as SBA', 'SA.subject_id = SBA.subject_id', 'left');
		$this->db->join('subject as SB', 'SBA.subject_id = SB.id', 'left');
		$this->db->join('category as C', 'SBA.category_id = C.id', 'left');
		$this->db->where('TA.topic_id', $topic_id);
		return $this->db->get()->result_array();
	}

	public function get_all_question($per_page = '', $offset = '', $search_key = null, $created_by = null, $filter_by = null, $category_id = null, $subject_id = null, $section_id = null, $topic_id = null, $batch_id = null, $year = null, $sorting = 0, $count = false)
	{
		$this->db->select('Q.id,Q.status,Q.title,Q.answer');
		$this->db->distinct();
		$this->db->from('question as Q');
		if ($category_id != '') {
			$this->db->join('topics_questions TQ', 'Q.id = TQ.question_id', 'left');

			$this->db->where('TQ.category_id', $category_id);
			if ($topic_id != '') {
				$this->db->join('topic_assign as TA', 'TQ.topic_id = TA.topic_id', 'left');
				$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
				$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id', 'left');
				$this->db->where('SUBA.subject_id', $subject_id);
				$this->db->where('SA.section_id', $section_id);
				$this->db->where('TQ.topic_id', $topic_id);
			} else if ($section_id != '') {
				$this->db->join('topic_assign as TA', 'TQ.topic_id = TA.topic_id', 'left');
				$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
				$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id', 'left');
				$this->db->where('SUBA.subject_id', $subject_id);
				$this->db->where('SA.section_id', $section_id);
			} else if ($subject_id != '') {
				$this->db->join('topic_assign as TA', 'TQ.topic_id = TA.topic_id', 'left');
				$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
				$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id', 'left');
				$this->db->where('SUBA.subject_id', $subject_id);
			}
		}
		if ($batch_id != '' && $year != '') {
			$this->db->join('question_batch_year as QBA', 'Q.id = QBA.question_id', 'left');
			$this->db->where('QBA.batch_id', $batch_id);
			$this->db->where('QBA.question_year', $year);
		} else if ($batch_id != '') {
			$this->db->join('question_batch_year as QBA', 'Q.id = QBA.question_id', 'left');
			$this->db->where('QBA.batch_id', $batch_id);
		} else if ($year != '') {
			$this->db->join('question_batch_year as QBA', 'Q.id = QBA.question_id', 'left');
			$this->db->where('QBA.question_year', $year);
		}
		if ($filter_by != '') {
			$this->db->where('Q.status', $filter_by);
		}
		if ($created_by != '') {
			$this->db->where('Q.created_by_admin', $created_by);
		}
		if ($search_key) {
			// $this->db->where("Q.title LIKE %" . $search_key . "% ");
			$this->db->like('Q.title', $search_key, "both");
		}
		if (!is_admin() && !is_super_admin() && !is_app_manager()) {
			$this->db->where("Q.created_by_admin", logged_in_user_id());
		}
		if ($count) {
			return $this->db->count_all_results();
		}
		if ($sorting == 1) {
			$this->db->order_by('Q.position', 'asc');
		} else {
			$this->db->order_by('Q.id', 'desc');
		}

		$this->db->limit($per_page, $offset);
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['status'] = $value['status'];
				$data[$key]['title'] = $value['title'];
				if ($value['answer'] == 9) {
					$data[$key]['answer'] = "All Correct";
				} else {

					$data[$key]['answer'] = $this->get_answer("question", $value['id'], $value['answer']);
				}
			}
		}
		return $data;
	}

	public function get_answer($table_name, $question_id, $answer)
	{
		$this->db->select("option_" . $answer);
		$this->db->from($table_name);
		$this->db->where('id', $question_id);
		return $this->db->get()->row_array()["option_" . $answer];
	}

	public function get_question_details($question_id)
	{
		$this->db->select('');
		$this->db->from('question as Q');
		$this->db->where('Q.id', $question_id);
		$result = $this->db->get()->row_array();
		$data = array();
		$result['answer'] = $this->get_answer("question", $result['id'], $result['answer']);

		$all_relation = $this->get_all_relation($result['id']);

		$result['topic'] = $all_relation['topic_name'];
		$result['section'] = $all_relation['section_name'];
		$result['subject'] = $all_relation['subject_name'];
		$result['category'] = $all_relation['category_name'];
		$result['difficulty'] = $this->get_question_level($result['difficulty']);
		$question_batch_year = $this->get_question_batch($result['id']);
		$result['batch_name'] = $question_batch_year['batch_name'];
		$result['question_year'] = $question_batch_year['question_year'];

		return $result;
	}
	function get_question_history_details($question_id)
	{
		$this->db->select('EH.*,A.name as user_name');
		$this->db->from('edit_history as EH');
		$this->db->join('admin as A', 'EH.update_by = A.id', 'left');
		$this->db->where('EH.slug', "question");
		$this->db->where('EH.edit_id', $question_id);
		$this->db->order_by('EH.id', 'desc');
		return $this->db->get()->result_array();
	}
	function get_all_relation($question_id, $slug = "admin")
	{
		$this->db->select('T.name as topic_name,S.name as section_name,SB.name as subject_name,C.name as category_name');
		if ($slug == "user") {
			$this->db->from('user_topics_questions as TQ');
		} else {
			$this->db->from('topics_questions as TQ');
		}
		$this->db->join('topic as T', 'TQ.topic_id = T.id', 'left');

		$this->db->join('topic_assign as TA', 'TQ.topic_id = TA.topic_id', 'left');
		$this->db->join('section as S', 'TA.section_id = S.id', 'left');

		$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
		$this->db->join('subject as SB', 'SA.subject_id = SB.id', 'left');

		$this->db->join('category as C', 'TQ.category_id = C.id', 'left');

		$this->db->where('TQ.question_id', $question_id);

		$result = $this->db->get()->result_array();
		$topic_name = [];
		$section_name = [];
		$subject_name = [];
		$category_name = [];
		if ($result) {
			foreach ($result as $value) {
				$topic_name[] = $value['topic_name'];
				$section_name[] = $value['section_name'];
				$subject_name[] = $value['subject_name'];
				$category_name[] = $value['category_name'];
			}
		}
		$data['topic_name'] = implode("/", array_unique($topic_name));
		$data['section_name'] = implode("/", array_unique($section_name));
		$data['subject_name'] = implode("/", array_unique($subject_name));
		$data['category_name'] = implode("/", array_unique($category_name));
		return $data;
	}

	function get_topic_id($question_id)
	{
		$this->db->select('TQ.topic_id');
		$this->db->distinct();
		$this->db->from('topics_questions as TQ');
		$this->db->where('TQ.question_id', $question_id);
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['category'] = $this->get_topic_relation($value['topic_id']);
				$data[$key]['topic_id'] = $this->get_topic_category($value['topic_id'], $question_id);
			}
		}
		return $data;
	}
	function  get_topic_category($topic_id, $question_id)
	{
		return $this->get_list("topics_questions", array("topic_id" => $topic_id, "question_id" => $question_id), 'category_id,topic_id');
	}

	function get_question_level($level)
	{
		switch ($level) {
			case 1:
				return "Basic";
				break;
			case 2:
				return "Intermediate";
				break;
			case 3:
				return "Advanced";
				break;
		}
	}
	function get_question_batch($question_id)
	{
		$this->db->select('B.name as batch_name,QBY.*');
		$this->db->from('question_batch_year as QBY');
		$this->db->join('batch as B', 'QBY.batch_id = B.id', 'left');
		$this->db->where('QBY.question_id', $question_id);
		$result = $this->db->get()->result_array();
		$batch_name = [];
		$question_year = [];
		if ($result) {
			foreach ($result as $key => $value) {
				$batch_name[$key] = $value["batch_name"];
				$question_year[$key] = $value["question_year"];
			}
		}
		$data['batch_name'] = implode("/", array_unique($batch_name));
		$data['question_year'] = implode("/", array_unique($question_year));
		return $data;
	}

	public function get_user()
	{
		$this->db->select('A.*,A.id as admin_id,R.name as role_name');
		$this->db->from('admin as A');
		$this->db->join('roles as R', 'A.role_id = R.id');
		$this->db->order_by('A.id', 'desc');
		$this->db->where('R.name!=', "Super Admin");
		return $this->db->get()->result_array();
	}

	public function get_user_question($per_page = '', $offset = '', $search_key = null, $category_id = null, $subject_id = null, $section_id = null, $topic_id = null, $date = null, $count = false)
	{
		$this->db->select('Q.id,Q.title,Q.answer,Q.created_at,U.id as user_id,U.name as user_name');
		$this->db->distinct();
		$this->db->from('user_question as Q');
		$this->db->join('users as U', 'Q.created_by = U.id', 'left');
		if ($category_id != '') {
			$this->db->join('topics_questions TQ', 'Q.id = TQ.question_id', 'left');

			$this->db->where('TQ.category_id', $category_id);
			if ($topic_id != '') {
				$this->db->join('topic_assign as TA', 'TQ.topic_id = TA.topic_id', 'left');
				$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
				$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id', 'left');
				$this->db->where('SUBA.subject_id', $subject_id);
				$this->db->where('SA.section_id', $section_id);
				$this->db->where('TQ.topic_id', $topic_id);
			} else if ($section_id != '') {
				$this->db->join('topic_assign as TA', 'TQ.topic_id = TA.topic_id', 'left');
				$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
				$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id', 'left');
				$this->db->where('SUBA.subject_id', $subject_id);
				$this->db->where('SA.section_id', $section_id);
			} else if ($subject_id != '') {
				$this->db->join('topic_assign as TA', 'TQ.topic_id = TA.topic_id', 'left');
				$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
				$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id', 'left');
				$this->db->where('SUBA.subject_id', $subject_id);
			}
		}
		if ($search_key) {
			$this->db->like('Q.title', $search_key, "both");
			$this->db->or_like('U.name', $search_key, "both");
			// $this->db->where("Q.title LIKE '%$search_key%' ");
			// $this->db->or_where("U.name LIKE '%$search_key%' ");
		}
		if ($date) {
			$this->db->where("DATE(Q.created_at)", date("Y-m-d", strtotime($date)));
		}
		if ($count) {
			return $this->db->count_all_results();
		}
		$this->db->order_by('Q.id', 'desc');
		$this->db->limit($per_page, $offset);
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['title'] = $value['title'];
				$data[$key]['user_name'] = $value['user_name'];
				$data[$key]['user_id'] = $value['user_id'];
				$data[$key]['created_at'] = $value['created_at'];
				$data[$key]['answer'] = $this->get_answer("user_question", $value['id'], $value['answer']);
			}
		}
		return $data;
	}

	public function get_user_question_details($question_id)
	{
		$this->db->select('Q.*');
		$this->db->from('user_question as Q');
		$this->db->where('Q.id', $question_id);
		$result = $this->db->get()->row_array();
		$data = array();
		$result['answer'] = $this->get_answer("user_question", $result['id'], $result['answer']);

		$all_relation = $this->get_all_relation($result['id'], "user");

		$result['topic'] = $all_relation['topic_name'];
		$result['section'] = $all_relation['section_name'];
		$result['subject'] = $all_relation['subject_name'];
		$result['category'] = $all_relation['category_name'];
		$result['difficulty'] = $this->get_question_level($result['difficulty']);

		return $result;
	}

	public function get_user_question_report($per_page = '', $offset = '', $category_id = null, $subject_id = null, $section_id = null, $topic_id = null, $search_key = null, $filter_by = null, $sorting = 1, $date = null, $count = false)
	{
		$this->db->select('QR.*,Q.title,U.name as user_name');
		$this->db->distinct();
		$this->db->from('question_reports as QR');
		$this->db->join('users as U', 'QR.user_id = U.id', 'left');
		$this->db->join('question as Q', 'QR.question_id = Q.id', 'left');
		if ($category_id != '') {
			$this->db->join('topics_questions TQ', 'Q.id = TQ.question_id', 'left');

			$this->db->where('TQ.category_id', $category_id);
			if ($topic_id != '') {
				$this->db->join('topic_assign as TA', 'TQ.topic_id = TA.topic_id', 'left');
				$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
				$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id', 'left');
				$this->db->where('SUBA.subject_id', $subject_id);
				$this->db->where('SA.section_id', $section_id);
				$this->db->where('TQ.topic_id', $topic_id);
			} else if ($section_id != '') {
				$this->db->join('topic_assign as TA', 'TQ.topic_id = TA.topic_id', 'left');
				$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
				$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id', 'left');
				$this->db->where('SUBA.subject_id', $subject_id);
				$this->db->where('SA.section_id', $section_id);
			} else if ($subject_id != '') {
				$this->db->join('topic_assign as TA', 'TQ.topic_id = TA.topic_id', 'left');
				$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
				$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id', 'left');
				$this->db->where('SUBA.subject_id', $subject_id);
			}
		}
		if ($filter_by != '') {
			$this->db->where("QR.status", $filter_by);
		}
		if ($search_key) {
			$this->db->like('Q.title', $search_key, "both");
			$this->db->or_like('U.name', $search_key, "both");
		}
		if ($date) {
			$this->db->where("DATE(QR.created_at)", date("Y-m-d", strtotime($date)));
		}
		if ($count) {
			return $this->db->count_all_results();
		}
		if ($sorting == 1) {
			$this->db->order_by('Q.position', 'asc');
		} else {
			$this->db->order_by('Q.id', 'desc');
		}
		$this->db->limit($per_page, $offset);
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['created_at'] = date("Y-m-d", strtotime($value['created_at']));
				$data[$key]['user_name'] = $value['user_name'];
				$data[$key]['user_id'] = $value['user_id'];
				$data[$key]['title'] = $value['title'];
				$data[$key]['type'] = $this->get_error_type_details($value['type']);
				$data[$key]['details'] = $value['details'];
				$data[$key]['status'] = $value['status'];
			}
		}
		return $data;
	}

	public function get_error_type_details($type)
	{
		switch ($type) {
			case 1:
				return "Question has an error";
			case 2:
				return "Answer choices has an error";
			default:
				return "Others";
		}
	}
}

/* End of file .php */
