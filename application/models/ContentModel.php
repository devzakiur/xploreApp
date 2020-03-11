<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ContentModel extends MY_Model
{
	public function get_all_question($per_page='',$category_id=null,$subject_id=null,$section_id=null,$topic_id=null,$count=false)
	{
		$this->db->select('Q.id,Q.title,Q.answer,Q.difficulty,Q.picture,Q.answer_explain,Q.option_1,Q.option_2,Q.option_3,Q.option_4');
		$this->db->distinct();
		$this->db->from('question as Q');
		if($category_id!='')
		{
			$this->db->join('topics_questions TQ', 'Q.id = TQ.question_id', 'left');
			if($topic_id!='')
			{
				$this->db->where_in('TQ.topic_id', explode(",",$topic_id));
			}
			else if($section_id!='')
			{
				$this->db->join('topic_assign as TA', 'TQ.topic_id = TA.topic_id', 'left');
				$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
				$this->db->where_in('SA.section_id', explode(",",$section_id));
			}
			else if($subject_id!='')
			{
				$this->db->join('topic_assign as TA', 'TQ.topic_id = TA.topic_id', 'left');
				$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
				$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id', 'left');
				$this->db->where_in('SUBA.subject_id', explode(",",$subject_id));
			}
			else
			{
				$this->db->where('TQ.category_id', $category_id);
			}
		}
		if($count)
		{
			return $this->db->count_all_results();
		}
		$this->db->order_by('Q.difficulty', 'RANDOM');
		$this->db->limit($per_page);
		$result=$this->db->get()->result_array();
		$data=array();
		if($result)
		{
			foreach($result as $key=>$value)
			{
				$data[$key]['id']=$value['id'];
				$data[$key]['title']=$value['title'];
				$data[$key]['option_1']=$value['option_1'];
				$data[$key]['option_2']=$value['option_2'];
				$data[$key]['option_3']=$value['option_3'];
				$data[$key]['option_4']=$value['option_4'];
				$data[$key]['answer_explain']=html_entity_decode($value['answer_explain']);
				$data[$key]['picture']=$value['picture'];
				$data[$key]['difficulty']=$value['difficulty'];
				$data[$key]['answer']=$this->get_answer($value['id'],$value['answer']);
			}
		}
		return $data;
	}
	public function get_answer($question_id,$answer)
	{
		$this->db->select("option_".$answer);
		$this->db->from('question');
		$this->db->where('id', $question_id);
		return $this->db->get()->row_array()["option_".$answer];
	}
	function get_section_by_subject($subject_id)
	{
		$this->db->select('S.id,S.name');
		$this->db->from('section_assign as SA');
		$this->db->join('section as S', 'SA.section_id = S.id', 'left');
		$this->db->where_in('SA.subject_id', explode(",",$subject_id));
		$this->db->order_by('S.position',"asc");
		return $this->db->get()->result_array();
	}
    function get_topic_by_section($section_id)
	{
		$this->db->select('T.id,T.name');
		$this->db->from('topic_assign as TA');
		$this->db->join('topic as T', 'TA.topic_id = T.id', 'left');
		$this->db->where_in('TA.section_id', explode(",",$section_id));
		$this->db->order_by('T.position',"asc");
		return $this->db->get()->result_array();
	}
}
