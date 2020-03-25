<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class GameModel extends MY_Model {

	public function game_question($question_limit,$category_id)
	{
		$this->db->select('Q.id,Q.title,Q.answer,Q.difficulty,Q.picture,Q.answer_explain,Q.option_1,Q.option_2,Q.option_3,Q.option_4');
		$this->db->distinct();
		$this->db->from('question as Q');
		if($category_id!='')
		{
			$this->db->join('topics_questions TQ', 'Q.id = TQ.question_id', 'left');
			$this->db->where('TQ.category_id', $category_id);
		}
		$this->db->order_by('Q.difficulty', 'RANDOM');
		$this->db->limit($question_limit);
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

/* End of file Auth_model.php */
