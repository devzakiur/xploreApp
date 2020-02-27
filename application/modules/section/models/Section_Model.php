<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Section_Model extends MY_Model
{
	public function get_section_list($category_id=null,$subject_id=null)
	{

		$this->db->select('AS.*,S.name as section_name,S.status');
		$this->db->from('section as S');
		$this->db->join('section_assign as AS',"AS.section_id=S.id","left");
		$this->db->join('subject_assign as SUBA',"AS.subject_id=SUBA.subject_id","left");
		$this->db->join('category as C',"SUBA.category_id=C.id","left");
		if($subject_id!=''){
			$this->db->where('SUBA.subject_id', $subject_id);
		}
		if($category_id!=''){
			$this->db->where('C.id', $category_id);
		}
		$this->db->group_by('AS.section_id');
		$result=  $this->db->get()->result_array();
		$data=array();
		if($result)
		{
			foreach ($result as $key=>$value) {
				$data[$key]['section_id']=$value['section_id'];
				$data[$key]['status']=$value['status'];
				$data[$key]['section_name']=$value['section_name'];
				$details=$this->subject_and_category_name($value['section_id']);
				$data[$key]['subject_name']=$details['subject_name'];
				$data[$key]['category_name']=$details['category_name'];
			}
		}
//		debug_r($data);
		return $data;
	}
	public function get_section_assign($section_id=null)
	{
		$this->db->select('AS.*,S.name as section_name');
		$this->db->from('section_assign as AS');
		$this->db->join('section as S',"AS.section_id=S.id","left");
		$this->db->group_by('AS.section_id');
		if($section_id!='')
		{
			$this->db->where('AS.section_id', $section_id);
		}
		$result=  $this->db->get()->result_array();
		$data=array();
		if($result)
		{
			foreach ($result as $key=>$value) {
				$data[$key]['section_id']=$value['section_id'];
				$data[$key]['section_name']=$value['section_name'];
				$details=$this->subject_and_category_name($value['section_id']);
				$data[$key]['subject_name']=$details['subject_name'];
				$data[$key]['category_name']=$details['category_name'];
			}
		}
		return $data;
	}
	function subject_and_category_name($section_id)
	{
		$this->db->distinct();
		$this->db->select('SB.name as subject_name,C.name as category_name');
		$this->db->from('section_assign as AS');
		$this->db->join('subject as SB',"AS.subject_id=SB.id","left");
		$this->db->join('subject_assign as SUBA',"AS.subject_id=SUBA.subject_id","left");
		$this->db->join('category as C',"SUBA.category_id=C.id","left");
		$this->db->where('AS.section_id', $section_id);
		$result=$this->db->get()->result_array();
		$subject_name=array();
		$category_name=array();
		if($result)
		{
			foreach ($result as $key=>$value)
			{
				$subject_name[]=$value['subject_name'];
				$category_name[]=$value['category_name'];
			}
		}
		$final_data['subject_name']=implode(', ',array_unique($subject_name));
		$final_data['category_name']=implode(', ',array_unique($category_name));
		return $final_data;
	}

	public function get_assign_subject_list()
	{
		$this->db->select('S.*');
		$this->db->from('subject_assign as SA');
		$this->db->join('subject as S', 'SA.subject_id = S.id', 'left');
		$this->db->group_by('SA.subject_id');
		$this->db->order_by('S.position','asc');
		return $this->db->get()->result_array();
	}

}

/* End of file .php */
