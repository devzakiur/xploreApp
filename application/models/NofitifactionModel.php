<?php
defined('BASEPATH') or exit('No direct script access allowed');

class NofitifactionModel extends MY_Model
{


	public function get_notification_list($per_page='', $offset='', $category_id='',$count=false)
	{
		$this->db->select("N.*,C.name as category_name");
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
		$result=$this->db->get()->result_array();
		$data=array();
		if($result)
		{
			foreach ($result as $key=>$value)
			{
				$data[$key]['id']=$value['id'];
				$data[$key]['category_name']=$value['category_name'];
				$data[$key]['title']=$value['title'];
				$data[$key]['details']=html_entity_decode($value['details']);
				$data[$key]['picture']=$value['picture'];
				$data[$key]['action']=$value['action'];
				$data[$key]['created_at']=$value['created_at'];
			}
		}
		return $data;
	}
}

/* End of file .php */
