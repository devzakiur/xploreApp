<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notification_Model extends MY_Model
{


	public function get_user_ids($category_id)
	{
		$this->db->select('DI.fcm_token');
		$this->db->from('users as U');
		$this->db->join('device_info as DI', 'U.id = DI.user_id');
		$this->db->where('U.category_id', $category_id);
		$result=$this->db->get()->result_array();
		$ids=array();
		if($result)
		{
			foreach ($result as $value)
			{
				$ids[]=$value['fcm_token'];
			}
		}
		return $ids;
	}

	public function get_all_notification($per_page='', $offset='',$category_id='',$count=false)
	{
		$this->db->select('N.*,C.name as category_name');
		$this->db->from('notification as N');
		$this->db->join('category as C', 'N.category_id = C.id', 'left');
		if($category_id!='')
		{
			$this->db->where('N.category_id', $category_id);
		}
		if($count)
		{
			return $this->db->count_all_results();
		}
		$this->db->order_by('N.id', 'desc');
		$this->db->limit($per_page,$offset);
		return $this->db->get()->result_array();
	}
	public function get_single_notification($id)
	{
		$this->db->select('N.*,C.name as category_name');
		$this->db->from('notification as N');
		$this->db->join('category as C', 'N.category_id = C.id', 'left');
		$this->db->where("N.id",$id);
		$this->db->limit(1);
		return $this->db->get()->row_array();
	}
}

/* End of file .php */
