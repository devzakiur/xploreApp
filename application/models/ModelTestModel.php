<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class ModelTestModel extends MY_Model {

	public function get_model_test_question($model_test_id,$total_question,$category_id)
	{
		$this->db->select('MQ.subject_id,MQ.section_id,MQ.topic_id,Q.id as question_id,Q.title,Q.is_math,Q.option_1,Q.option_2,Q.option_3,Q.option_4,Q.picture,Q.answer');
		$this->db->distinct();
		$this->db->from('model_test_question as MQ');
		$this->db->join('question as Q', 'MQ.question_id = Q.id');
		$this->db->join('topics_questions as TQ', 'MQ.question_id = TQ.question_id');
		$this->db->join('subject as SUB', 'MQ.subject_id = SUB.id');
		$this->db->join('section as S', 'MQ.section_id = S.id');
		$this->db->join('topic as T', 'MQ.topic_id = T.id');
		$this->db->where('TQ.category_id', $category_id);
		$this->db->where('MQ.model_test_id', $model_test_id);

		$this->db->order_by('MQ.id', 'desc');
		$this->db->limit($total_question);
		$result=$this->db->get()->result_array();
		$data=array();
		if($result)
		{
			foreach($result as $key=>$value)
			{
				$data[$key]['title']=$value['title'];
				$data[$key]['options']=[
					"0"=>$value['option_1'],
					"1"=>$value['option_2'],
					"2"=>$value['option_3'],
					"3"=>$value['option_4'],
				];
				$data[$key]['picture']=$value['picture'];
				$data[$key]['answer']=$value['answer']-1;
				$data[$key]['topic_id']=$value['topic_id'];
				$data[$key]['section_id']=$value['section_id'];
				$data[$key]['subject_id']=$value['subject_id'];
				$data[$key]['question_id']=$value['question_id'];
				$data[$key]['is_math']=$value['is_math'];
			}
		}
		return $data;
	}

	public function get_leader_board($per_page='',$offset='',$model_test_id,$count=false)
	{
		$this->db->select('U.name,GR.total_point,GR.get_point,GR.total_time');
		$this->db->from('game_result as GR');
		$this->db->join('users as U', 'GR.user_id = U.id');
		$this->db->order_by('GR.get_point', 'desc');
		$this->db->order_by('GR.total_time', 'asc');
		$this->db->where('GR.slug', "model_test");
		$this->db->where('GR.model_test_id', $model_test_id);
		if($count)
		{
			return $this->db->count_all_results();
		}
		$this->db->limit($per_page,$offset);
		return $this->db->get()->result_array();
	}

	public function get_my_position($model_test_id,$id)
	{
		$this->db->select('GR.user_id,U.name,GR.total_point,GR.get_point,GR.total_time');
		$this->db->from('game_result as GR');
		$this->db->join('users as U', 'GR.user_id = U.id');
		$this->db->order_by('GR.get_point', 'desc');
		$this->db->order_by('GR.total_time', 'asc');
		$this->db->where('GR.slug', "model_test");
		$this->db->where('GR.model_test_id', $model_test_id);
		$result=$this->db->get()->result_array();
		$position=0;
		$data=array();
		if($result)
		{
			foreach ($result as $key=>$value)
			{
				if($value['user_id']==$id)
				{
					$data['name']=$value['name'];
					$data['total_point']=$value['total_point'];
					$data['get_point']=$value['get_point'];
					$data['total_time']=$value['total_time'];
					$data['position']=$key+1;
					break;
				}
			}
		}
		if(empty($data))
		{
			return null;
		}
		return $data;
	}

	public function get_model_test($category_id)
	{
		$this->db->select('');
		$this->db->from('model_test');
		$this->db->where('category_id', $category_id);
		$this->db->where('is_played', true);
		$this->db->order_by("id","desc");
		$result=$this->db->get()->result_array();
		$data=array();
		if($result)
		{
			foreach ($result as $key=>$value)
			{
				$data[$key]['id']=$value['id'];
				$data[$key]['title']=$value['title'];
				$data[$key]['total_participate']=$this->count_all("model_test_register_users",array("model_test_id"=>$value['id']));
			}
		}
		return $data;
	}

}

/* End of file Auth_model.php */
