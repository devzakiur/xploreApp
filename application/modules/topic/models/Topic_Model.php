<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Topic_Model extends MY_Model
{
	public function get_topic_list($category_id=null,$subject_id=null,$section_id=null)
	{
		$this->db->select('TA.*,T.name as topic_name,T.status');
		$this->db->from('topic as T');
		$this->db->join('topic_assign as TA',"TA.topic_id=T.id","left");
		$this->db->join('section_assign as AS',"TA.section_id=AS.section_id","left");
		$this->db->join('subject_assign as SUBA',"AS.subject_id=SUBA.subject_id","left");
		$this->db->join('category as C',"SUBA.category_id=C.id","left");

		if($section_id!=''){
			$this->db->where('AS.section_id', $section_id);
		}
		if($subject_id!=''){
			$this->db->where('SUBA.subject_id', $subject_id);
		}
		if($category_id!=''){
			$this->db->where('C.id', $category_id);
		}
		$this->db->group_by('TA.topic_id');
		$result=  $this->db->get()->result_array();
		$data=array();
		if($result)
		{
			foreach ($result as $key=>$value) {
				$data[$key]['topic_id']=$value['topic_id'];
				$data[$key]['status']=$value['status'];
				$data[$key]['topic_name']=$value['topic_name'];
				$details=$this->category_subject_section_name($value['topic_id']);
				$data[$key]['section_name']=$details['section_name'];
				$data[$key]['subject_name']=$details['subject_name'];
				$data[$key]['category_name']=$details['category_name'];
			}
		}
		return $data;
	}
	public function get_topic_assign($topic_id=null)
	{
		$this->db->select('TA.*,T.name as topic_name');
		$this->db->from('topic_assign as TA');
		$this->db->join('topic as T',"TA.topic_id=T.id","left");
		$this->db->group_by('TA.topic_id');
		if($topic_id!='')
		{
			$this->db->where('TA.topic_id', $topic_id);
		}
		$result=  $this->db->get()->result_array();
		$data=array();
		if($result)
		{
			foreach ($result as $key=>$value) {
				$data[$key]['topic_id']=$value['topic_id'];
				$data[$key]['topic_name']=$value['topic_name'];
				$details=$this->category_subject_section_name($value['topic_id']);
				$data[$key]['section_name']=$details['section_name'];
				$data[$key]['subject_name']=$details['subject_name'];
				$data[$key]['category_name']=$details['category_name'];
			}
		}
		return $data;
	}
	function category_subject_section_name($topic_id)
	{
		$this->db->distinct();
		$this->db->select('S.name as section_name,SB.name as subject_name,C.name as category_name');
		$this->db->from('topic_assign as TA');
		$this->db->join('section as S',"TA.section_id=S.id","left");
		$this->db->join('section_assign as SA',"S.id=SA.section_id","left");
		$this->db->join('subject as SB',"SA.subject_id=SB.id","left");
		$this->db->join('subject_assign as SBA',"SB.id=SBA.subject_id","left");
		$this->db->join('category as C',"SBA.category_id=C.id","left");
		$this->db->where('TA.topic_id', $topic_id);
		$result=$this->db->get()->result_array();
		$section_name=array();
		$subject_name=array();
		$category_name=array();
		if($result)
		{
			foreach ($result as $value)
			{
				$section_name[]=$value['section_name'];
				$subject_name[]=$value['subject_name'];
				$category_name[]=$value['category_name'];
			}
		}
		$final_data['section_name']=implode(', ',array_unique($section_name));
		$final_data['subject_name']=implode(', ',array_unique($subject_name));
		$final_data['category_name']=implode(', ',array_unique($category_name));
		return $final_data;
	}

	public function get_assign_section_list()
	{
		$this->db->select('S.*');
		$this->db->from('section_assign as SA');
		$this->db->join('section as S', 'SA.section_id = S.id', 'left');
		$this->db->group_by('SA.section_id');
		$this->db->order_by('S.position','asc');
		return $this->db->get()->result_array();
	}

}

/* End of file .php */
