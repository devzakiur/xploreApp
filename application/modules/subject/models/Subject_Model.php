<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Subject_Model extends MY_Model
{
	public function get_subject_list()
	{
		$this->db->distinct();
		$this->db->select('S.name as subject_name,S.status,S.id as subject_id');
		$this->db->from('subject as S');
		$this->db->join('subject_assign as AS',"AS.subject_id=S.id","left");
		$this->db->group_by('S.id');
		$result=  $this->db->get()->result_array();

//		debug_r($result);
		$data=array();
		if($result)
		{
			foreach ($result as $key=>$value) {
				$data[$key]['subject_id']=$value['subject_id'];
				$data[$key]['status']=$value['status'];
				$data[$key]['subject_name']=$value['subject_name'];
				$data[$key]['category_name']=$this->category_name($value['subject_id']);
			}
		}
		return $data;
	}
	public function get_subject_assign($subject_id=null)
	{
		$this->db->select('AS.*,S.name as subject_name');
		$this->db->from('subject_assign as AS');
		$this->db->join('subject as S',"AS.subject_id=S.id","left");
		$this->db->group_by('AS.subject_id');
		if($subject_id!='')
		{
			$this->db->where('AS.subject_id', $subject_id);
		}
		$result=  $this->db->get()->result_array();
		$data=array();
		if($result)
		{
			foreach ($result as $key=>$value) {
				$data[$key]['subject_id']=$value['subject_id'];
				$data[$key]['subject_name']=$value['subject_name'];
				$data[$key]['category_name']=$this->category_name($value['subject_id']);
			}
		}
		return $data;
	}
	function category_name($subject_id)
	{
		$this->db->select('C.name as category_name');
		$this->db->from('subject_assign as AS');
		$this->db->join('category as C',"AS.category_id=C.id","left");
		$this->db->where('AS.subject_id', $subject_id);
		$result=$this->db->get()->result_array();
		$data=array();
		if($result)
		{
			foreach ($result as $value)
			{
				$data[]=$value['category_name'];
			}
		}
		return implode(', ',$data);
	}
}

/* End of file .php */
