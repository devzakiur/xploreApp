<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_Model extends MY_Model
{
	public function get_all_users($per_page='',$offset='',$search_key=null,$filter_by=null,$count=false)
	{
		$this->db->select('*');
		$this->db->from('users');
		if($filter_by!='')
		{
			$this->db->where('status', $filter_by);
		}
		if($search_key)
		{
			$this->db->where("email LIKE '%$search_key%' ");
			$this->db->or_where("name LIKE '%$search_key%' ");
			$this->db->or_where("phone LIKE '%$search_key%' ");
		}
		if($count)
		{
			return $this->db->count_all_results();
		}
		$this->db->order_by('id', 'desc');
		$this->db->limit($per_page,$offset);
		return $this->db->get()->result_array();
	}
}

/* End of file .php */
