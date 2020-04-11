<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ContentModel extends MY_Model
{
	private $options=[];
	public function get_all_question($per_page='',$category_id=null,$subject_id=null,$section_id=null,$topic_id=null,$user_id)
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
				$data[$key]['options']=[
					"0"=>$value['option_1'],
					"1"=>$value['option_2'],
					"2"=>$value['option_3'],
					"3"=>$value['option_4'],
				];
				$data[$key]['answer_explain']=html_entity_decode($value['answer_explain']);
				$data[$key]['picture']=$value['picture'];
				$data[$key]['difficulty']=$value['difficulty'];
				$data[$key]['is_bookmarked']=$this->exits_check("question_bookmark",array("user_id"=>$user_id,"question_id"=>$value['id']));
				$data[$key]['answer']=$value['answer']-1;
			}
		}
		return $data;
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

	public function get_all_library($category_id=null,$subject_id=null,$section_id=null,$topic_id=null,$count=false)
	{
		$this->db->distinct();
		$this->db->select('L.*,TL.topic_id');
		$this->db->from('library as L');
		$this->db->join('topic_library as TL', 'L.id = TL.library_id', 'left');
		$this->db->join('category as C', 'TL.category_id = C.id', 'left');
		$this->db->join('topic as T', 'TL.topic_id = T.id', 'left');
		$this->db->order_by('L.id', 'desc');
		if($category_id!='')
		{
			if($topic_id!='')
			{
				$this->db->where('TL.topic_id', $topic_id);
			}
			else if($section_id!='')
			{
				$this->db->join('topic_assign as TA', 'TL.topic_id = TA.topic_id', 'left');
				$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
				$this->db->where('SA.section_id', $section_id);
			}
			else if($subject_id!='')
			{
				$this->db->join('topic_assign as TA', 'TL.topic_id = TA.topic_id', 'left');
				$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
				$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id', 'left');
				$this->db->where('SUBA.subject_id', $subject_id);
			}
			else
			{
				$this->db->where('TL.category_id', $category_id);
			}
		}
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		$result=$this->db->get()->row_array();
		if($result)
		{
			$result['details']=html_entity_decode($result['details']);
			$result['gist']=html_entity_decode($result['gist']);
			$result['videos']=$this->get_list("library_video",array("library_id"=>$result['id']));
			$result['images']=$this->get_list("library_image",array("library_id"=>$result['id']));
			$result['recommended']=$this->get_single("library",array("position"=>$result['position']+1),"id,title");
		}
		return $result;
	}

	public function get_recently_learn($user_id)
	{
		$this->db->distinct();
		$this->db->select('T.id as topic_id,C.name as category_name,S.name as subject_name,SEC.name as section_name,T.name as topic_name');
		$this->db->from('recently_learn as RL');
		$this->db->join('category as C', 'RL.category_id = C.id', 'left');
		$this->db->join('subject as S', 'RL.subject_id = S.id', 'left');
		$this->db->join('section as SEC', 'RL.section_id = SEC.id', 'left');
		$this->db->join('topic as T', 'RL.topic_id = T.id', 'left');
		$this->db->order_by('RL.id', 'desc');
		$this->db->where('RL.user_id', $user_id);
		$this->db->limit(5);
		return $this->db->get()->result_array();
	}

	public function get_most_popular($category_id)
	{
		$this->db->select('T.id as topic_id,C.name as category_name,S.name as subject_name,SEC.name as section_name,T.name as topic_name,SUM(RL.views) as total_views');
		$this->db->from('recently_learn as RL');
		$this->db->join('category as C', 'RL.category_id = C.id', 'left');
		$this->db->join('subject as S', 'RL.subject_id = S.id', 'left');
		$this->db->join('section as SEC', 'RL.section_id = SEC.id', 'left');
		$this->db->join('topic as T', 'RL.topic_id = T.id', 'left');
		$this->db->group_by('RL.topic_id');
		$this->db->order_by('total_views',"desc");
		$this->db->where('RL.category_id', $category_id);
		$this->db->limit(5);
		return $this->db->get()->result_array();
	}
	public function get_all_favourite_question($per_page='',$offset='',$user_id,$subject_id='',$section_id='',$topic_id='',$count=false)
	{
		$this->db->select('Q.id,Q.title,Q.answer,Q.difficulty,Q.picture,Q.answer_explain,Q.option_1,Q.option_2,Q.option_3,Q.option_4');
		$this->db->from('question_bookmark as QB');
		$this->db->join('question as Q', 'QB.question_id = Q.id');

		if($subject_id!='')
		$this->db->where('QB.subject_id', $subject_id);

		if($section_id!='')
		$this->db->where('QB.section_id', $section_id);

		if($topic_id!='')
		$this->db->where('QB.topic_id', $topic_id);

		$this->db->where('QB.user_id', $user_id);
		if($count)
		{
			return $this->db->count_all_results();
		}
		$this->db->order_by('Q.id', 'desc');
		$this->db->limit($per_page,$offset);
		$result=$this->db->get()->result_array();
		$data=array();
		if($result)
		{
			foreach($result as $key=>$value)
			{
				$data[$key]['id']=$value['id'];
				$data[$key]['title']=$value['title'];
				$data[$key]['options']=[
					"0"=>$value['option_1'],
					"1"=>$value['option_2'],
					"2"=>$value['option_3'],
					"3"=>$value['option_4'],
				];
				$data[$key]['answer_explain']=html_entity_decode($value['answer_explain']);
				$data[$key]['picture']=$value['picture'];
				$data[$key]['difficulty']=$value['difficulty'];
				$data[$key]['answer']=$value['answer']-1;
			}
		}
		return $data;
	}
}
