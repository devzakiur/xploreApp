<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reports_Model extends MY_Model
{
	public function get_reports($per_page = '', $offset = '', $category_id = "", $from_date = "", $to_date = '', $count = false)
	{
		$this->db->select('MT.*,COUNT(GR.model_test_id) as total_participate');
		$this->db->from('model_test as MT');
		$this->db->join('game_result as GR', 'MT.id = GR.model_test_id');
		$this->db->group_by('GR.model_test_id');
		$this->db->order_by('MT.date', "desc");
		$this->db->where('MT.is_played', true);
		if ($category_id) {
			$this->db->where('MT.category_id', $category_id);
		}
		if ($from_date) {
			$this->db->where('DATE(MT.date)>=', $from_date);
		}
		if ($from_date) {
			$this->db->where('DATE(MT.date)<=', $to_date);
		}
		if ($count) {
			return $this->db->count_all_results();
		}
		$this->db->limit($per_page, $offset);
		return $this->db->get()->result_array();
	}
	public function get_leader_board($per_page = '', $offset = '', $model_test_id, $count = false)
	{
		$this->db->select('U.name,U.id as user_id,GR.*');
		$this->db->from('game_result as GR');
		$this->db->join('users as U', 'GR.user_id = U.id');
		$this->db->order_by('GR.get_point', 'desc');
		$this->db->order_by('GR.total_time', 'asc');
		$this->db->where('GR.slug', "model_test");
		$this->db->where('GR.model_test_id', $model_test_id);
		if ($count) {
			return $this->db->count_all_results();
		}
		$this->db->limit($per_page, $offset);
		return $this->db->get()->result_array();
	}
	public function get_challenge_leader_borad($per_page = '', $offset = '', $category_id = '', $from_date = '', $to_date = '', $challenge_type = '', $count = false)
	{
		$this->db->select('U.name,U.id as user_id,GR.*');
		$this->db->from('game_result as GR');
		$this->db->join('users as U', 'GR.user_id = U.id');
		$this->db->order_by('GR.get_point', 'desc');
		$this->db->order_by('GR.total_time', 'asc');
		if ($challenge_type) {
			$this->db->where('GR.challenge_id', $challenge_type);
		}
		if ($category_id) {
			$this->db->where('GR.category_id', $category_id);
		}
		if ($from_date) {
			$this->db->where('DATE(GR.created_at)>=', $from_date);
		}
		if ($from_date) {
			$this->db->where('DATE(GR.created_at)<=', $to_date);
		}
		if ($count) {
			return $this->db->count_all_results();
		}
		$this->db->limit($per_page, $offset);
		return $this->db->get()->result_array();
	}
}

/* End of file .php */
