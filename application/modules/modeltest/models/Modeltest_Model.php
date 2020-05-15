<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Modeltest_Model extends MY_Model
{
	public function get_question($category_id, $subject_ids, $total_question, $model_test_id)
	{
		$data = array();
		$j = 0;
		$total_subject = count($subject_ids);
		$per_limit = floor($total_question / $total_subject);
		$first_time_limit = $per_limit + ($total_question - ($per_limit * $total_subject));
		for ($i = 0; $i < count($subject_ids); $i++) {
			$this->db->select('Q.id,Q.title,SA.subject_id,SA.section_id,TQ.topic_id,TQ.category_id');
			$this->db->from('question as Q');
			$this->db->join('topics_questions as TQ', 'Q.id = TQ.question_id');
			$this->db->join('topic_assign as TA', 'TQ.topic_id = TA.topic_id');
			$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id');
			$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id');
			$this->db->group_by("Q.title");
			$this->db->where('TQ.category_id', $category_id);
			$this->db->where('SUBA.subject_id', $subject_ids[$i]);
			$this->db->order_by('Q.id', 'RANDOM');
			$this->db->where('Q.status', 1);
			if ($i == 0) {
				$this->db->limit($first_time_limit);
			} else {
				$this->db->limit($per_limit);
			}
			$result = $this->db->get()->result_array();
			if ($result) {
				foreach ($result as $key => $value) {
					$data[$j]['model_test_id '] = $model_test_id;
					$data[$j]['question_id'] = $value['id'];
					$data[$j]['subject_id'] = $value['subject_id'];
					$data[$j]['section_id'] = $value['section_id'];
					$data[$j]['topic_id'] = $value['topic_id'];
					$j++;
				}
			}
		}
		return array_map("unserialize", array_unique(array_map("serialize", $data)));
	}

	public function get_all_model_test()
	{
		$this->db->select('M.*,C.name as category_name');
		$this->db->from('model_test as M');
		$this->db->join('category as C', 'M.category_id = C.id', 'left');
		$this->db->order_by('M.date', 'desc');
		return $this->db->get()->result_array();
	}

	public function get_subject_list($id)
	{
		$this->db->select("S.*");
		$this->db->from('model_test_question as MQ');
		$this->db->join('subject as S', 'MQ.subject_id = S.id', 'left');
		$this->db->group_by('MQ.subject_id');
		$this->db->where('MQ.model_test_id', $id);
		return $this->db->get()->result_array();
	}

	public function get_all_question($per_page = '', $offset = '', $question_ids, $category_id = null, $subject_id = null, $section_id = null, $topic_id = null, $count = false)
	{
		$this->db->select('Q.id,Q.title,TQ.topic_id,SA.section_id,SUBA.subject_id');
		$this->db->from('question as Q');
		$this->db->join('topics_questions TQ', 'Q.id = TQ.question_id');
		$this->db->join('topic_assign as TA', 'TQ.topic_id = TA.topic_id');
		$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id');
		$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id');
		$this->db->group_by("Q.id");
		if ($topic_id != '') {
			$this->db->where('TQ.category_id', $category_id);
			$this->db->where('SUBA.subject_id', $subject_id);
			$this->db->where('SA.section_id', $section_id);
			$this->db->where('TQ.topic_id', $topic_id);
		} else if ($section_id != '') {
			$this->db->where('TQ.category_id', $category_id);
			$this->db->where('SUBA.subject_id', $subject_id);
			$this->db->where('SA.section_id', $section_id);
		} else {
			$this->db->where('SUBA.subject_id', $subject_id);
			$this->db->where('TQ.category_id', $category_id);
		}
		if (!empty($question_ids))
			$this->db->where_not_in('Q.id', $question_ids);
		if ($count) {
			return $this->db->count_all_results();
		}
		$this->db->order_by('Q.id', 'desc');
		$this->db->limit($per_page, $offset);
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function get_model_question($per_page = '', $offset = '', $category_id, $model_test_id = null, $subject_id = null, $section_id = null, $topic_id = null, $count = false)
	{
		$this->db->select('MQ.id as model_question_id,Q.id as question_id,Q.title');
		$this->db->distinct();
		$this->db->from('model_test_question as MQ');
		$this->db->join('question as Q', 'MQ.question_id = Q.id');
		$this->db->join('topics_questions as TQ', 'MQ.question_id = TQ.question_id');
		$this->db->join('subject as SUB', 'MQ.subject_id = SUB.id');
		$this->db->join('section as S', 'MQ.section_id = S.id');
		$this->db->join('topic as T', 'MQ.topic_id = T.id');
		$this->db->where('TQ.category_id', $category_id);
		$this->db->where('MQ.model_test_id', $model_test_id);
		if ($subject_id != '')
			$this->db->where('MQ.subject_id', $subject_id);
		if ($section_id != '')
			$this->db->where('MQ.section_id', $section_id);
		if ($topic_id != '')
			$this->db->where('MQ.topic_id', $topic_id);
		if ($count)
			return $this->db->count_all_results();

		$this->db->order_by('MQ.id', 'desc');
		$this->db->limit($per_page, $offset);
		$result = $this->db->get()->result_array();
		return $result;
	}
}

/* End of file .php */
