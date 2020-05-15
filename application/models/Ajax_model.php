<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Ajax_model extends MY_Model
{
	function get_subject_by_category($category_id)
	{
		$this->db->select('S.id,S.name');
		$this->db->from('subject_assign as SA');
		$this->db->join('subject as S', 'SA.subject_id = S.id', 'left');
		$this->db->where('SA.category_id', $category_id);
		$this->db->order_by('S.position', "asc");
		$this->db->where('S.status', 1);
		return $this->db->get()->result_array();
	}
	function get_section_by_subject($subject_id)
	{
		$this->db->select('S.id,S.name');
		$this->db->from('section_assign as SA');
		$this->db->join('section as S', 'SA.section_id = S.id', 'left');
		$this->db->where('SA.subject_id', $subject_id);
		$this->db->order_by('S.position', "asc");
		$this->db->where('S.status', 1);
		return $this->db->get()->result_array();
	}
	function get_section_by_subject_category($category_id, $subject_id)
	{
		$this->db->select('S.id,S.name');
		$this->db->from('section_assign as SA');
		$this->db->join('section as S', 'SA.section_id = S.id', 'left');
		$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id', 'left');
		$this->db->where('SUBA.category_id', $category_id);
		$this->db->where('SA.subject_id', $subject_id);
		$this->db->order_by('S.position', "asc");
		$this->db->where('S.status', 1);
		return $this->db->get()->result_array();
	}
	function get_topic_by_section($section_id)
	{
		$this->db->select('T.id,T.name');
		$this->db->from('topic_assign as TA');
		$this->db->join('topic as T', 'TA.topic_id = T.id', 'left');
		$this->db->where('TA.section_id', $section_id);
		$this->db->order_by('T.position', "asc");
		$this->db->where('T.status', 1);
		return $this->db->get()->result_array();
	}

	public function game_subject_section_topic($game_id, $user_id)
	{
		$this->db->select('S.id as subject_id,S.name as subject_name');
		$this->db->from('game_result_question as GRQ');
		$this->db->join('game_result as GR', 'GRQ.game_table_id = GR.id');
		$this->db->join('subject as S', 'GRQ.subject_id = S.id');
		$this->db->group_by('GRQ.subject_id');
		if ($game_id != '')
			$this->db->where('GRQ.game_table_id', $game_id);
		$this->db->where('GR.user_id', $user_id);
		$result = $this->db->get()->result_array();
		$data = array();
		$subject_id = array();
		$final = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['subject_name'] = $value['subject_name'];
				$data[$key]['subject_id'] = $value['subject_id'];
				$subject_id[] = $value['subject_id'];
			}
			$game_section = $this->game_section($game_id, $subject_id);
			$game_topic = $this->game_topic($game_id, $game_section['section_id']);
			$final['subject_list'] = $data;
			$final['section_list'] = $game_section['section_list'];
			$final['topic_list'] = $game_topic;
		}
		if (empty($final)) {
			return null;
		}
		return $final;
	}
	public function game_section($game_id, array $subject_id)
	{
		$this->db->select('GRQ.subject_id,SEC.id as section_id,SEC.name as section_name');
		$this->db->from('game_result_question as GRQ');
		$this->db->join('section as SEC', 'GRQ.section_id = SEC.id');
		$this->db->group_by('GRQ.section_id');
		if ($game_id != '')
			$this->db->where('GRQ.game_table_id', $game_id);
		$this->db->where_in('GRQ.subject_id', $subject_id);
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['subject_id'] = $value['subject_id'];
				$data[$key]['section_name'] = $value['section_name'];
				$data[$key]['section_id'] = $value['section_id'];
				$section_id[] = $value['section_id'];
			}
		}
		$final['section_list'] = $data;
		$final['section_id'] = $section_id;
		return $final;
	}
	public function game_topic($game_id, array $section_id)
	{
		$this->db->select('GRQ.section_id,T.id as topic_id,T.name as topic_name');
		$this->db->from('game_result_question as GRQ');
		$this->db->join('topic as T', 'GRQ.topic_id = T.id');
		$this->db->group_by('GRQ.topic_id');
		if ($game_id != '')
			$this->db->where('GRQ.game_table_id', $game_id);
		$this->db->where_in('GRQ.section_id', $section_id);
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['section_id'] = $value['section_id'];
				$data[$key]['topic_name'] = $value['topic_name'];
				$data[$key]['topic_id'] = $value['topic_id'];
			}
		}
		return $data;
	}
}

/* End of file Ajax.php */
