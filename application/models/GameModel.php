<?php

defined('BASEPATH') or exit('No direct script access allowed');

class GameModel extends MY_Model
{

	public function game_question($question_limit, $category_id)
	{
		$this->db->select('Q.id,Q.title,Q.answer,Q.difficulty,Q.picture,Q.answer_explain,Q.option_1,Q.option_2,Q.option_3,Q.option_4,
		TQ.topic_id,SA.section_id,SA.subject_id,Q.is_math');
		$this->db->distinct();
		$this->db->from('question as Q');
		if ($category_id != '') {
			$this->db->join('topics_questions TQ', 'Q.id = TQ.question_id', 'left');
			$this->db->join('topic_assign TA', 'TQ.topic_id = TA.topic_id', 'left');
			$this->db->join('section_assign SA', 'TA.section_id = SA.section_id', 'left');
			$this->db->where('TQ.category_id', $category_id);
		}
		$this->db->group_by('Q.id');
		$this->db->order_by('Q.difficulty', 'RANDOM');
		$this->db->limit($question_limit);
		$this->db->where('Q.status', 1);
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['title'] = $value['title'];
				$data[$key]['options'] = [
					"0" => $value['option_1'],
					"1" => $value['option_2'],
					"2" => $value['option_3'],
					"3" => $value['option_4'],
				];
				$data[$key]['answer_explain'] = html_entity_decode($value['answer_explain']);
				$data[$key]['picture'] = $value['picture'];
				$data[$key]['difficulty'] = $value['difficulty'];
				$data[$key]['answer'] = $value['answer'] - 1;
				$data[$key]['topic_id'] = $value['topic_id'];
				$data[$key]['section_id'] = $value['section_id'];
				$data[$key]['subject_id'] = $value['subject_id'];
				$data[$key]['is_math'] = $value['is_math'];
			}
		}
		return $data;
	}

	public function get_subject_based_performance($game_id, $limit = '')
	{
		$this->db->select("GRQ.subject_id,S.name as subject_name,count(GRQ.subject_id) as question_per_subject,COUNT(IF(GRQ.answer_type = 'correct', 1, NULL)) 'correct_ans_by_subject',SUM(GRQ.game_time) as subject_game_time");
		$this->db->from('game_result_question as GRQ');
		$this->db->join('subject as S', 'GRQ.subject_id = S.id', 'left');
		$this->db->group_by('GRQ.subject_id');
		$this->db->where('GRQ.game_table_id', $game_id);
		if ($limit != '') {
			$this->db->limit($limit);
		}
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['subject_id'] = $value['subject_id'];
				$data[$key]['subject_name'] = $value['subject_name'];
				$data[$key]['question_per_subject'] = $value['question_per_subject'];
				$data[$key]['correct_ans_by_subject'] = $value['correct_ans_by_subject'];
				$data[$key]['subject_game_time'] = $value['subject_game_time'];
				$data[$key]['subject_percent'] = $this->get_percent($data[$key]['question_per_subject'], $data[$key]['correct_ans_by_subject']);
				$data[$key]['subject_answer'] = "(" . $data[$key]['correct_ans_by_subject'] . "/" . $data[$key]['question_per_subject'] . ")";
				$data[$key]['section_performance'] = $this->get_section_performance($game_id, $value['subject_id']);
			}
		}
		return $data;
	}

	public function get_section_performance($game_id, $subject_id)
	{
		$this->db->select("GRQ.section_id,S.name as section_name,count(GRQ.section_id) as question_per_section,COUNT(IF(GRQ.answer_type = 'correct', 1, NULL)) 'correct_ans_by_section',SUM(GRQ.game_time) as section_game_time");
		$this->db->from('game_result_question as GRQ');
		$this->db->join('section as S', 'GRQ.section_id = S.id', 'left');
		$this->db->group_by('GRQ.section_id');
		$this->db->where('GRQ.game_table_id', $game_id);
		$this->db->where('GRQ.subject_id', $subject_id);
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['section_id'] = $value['section_id'];
				$data[$key]['section_name'] = $value['section_name'];
				$data[$key]['question_per_section'] = $value['question_per_section'];
				$data[$key]['correct_ans_by_section'] = $value['correct_ans_by_section'];
				$data[$key]['section_game_time'] = $value['section_game_time'];
				$data[$key]['section_percent'] = $this->get_percent($data[$key]['question_per_section'], $data[$key]['correct_ans_by_section']);
				$data[$key]['section_answer'] = "(" . $data[$key]['correct_ans_by_section'] . "/" . $data[$key]['question_per_section'] . ")";
				$data[$key]['topic_performance'] = $this->get_topic_performance($game_id, $subject_id, $value['section_id']);
			}
		}
		return $data;
	}

	public function get_topic_performance($game_id, $subject_id, $section_id)
	{
		$this->db->select("GRQ.topic_id,T.name as topic_name,COUNT(GRQ.topic_id) as question_per_topic,COUNT(IF(GRQ.answer_type = 'correct', 1, NULL)) 'correct_ans_by_topic',SUM(GRQ.game_time) as topic_game_time");
		$this->db->from('game_result_question as GRQ');
		$this->db->join('topic as T', 'GRQ.topic_id = T.id', 'left');
		$this->db->group_by('GRQ.topic_id');
		$this->db->where('GRQ.game_table_id', $game_id);
		$this->db->where('GRQ.subject_id', $subject_id);
		$this->db->where('GRQ.section_id', $section_id);
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['topic_id'] = $value['topic_id'];
				$data[$key]['topic_name'] = $value['topic_name'];
				$data[$key]['question_per_topic'] = $value['question_per_topic'];
				$data[$key]['correct_ans_by_topic'] = $value['correct_ans_by_topic'];
				$data[$key]['topic_game_time'] = $value['topic_game_time'];
				$data[$key]['topic_percent'] = $this->get_percent($data[$key]['question_per_topic'], $data[$key]['correct_ans_by_topic']);
				$data[$key]['topic_answer'] = "(" . $data[$key]['correct_ans_by_topic'] . "/" . $data[$key]['question_per_topic'] . ")";
			}
		}
		return $data;
	}


	public function get_individual_subject_based_performance($game_id, $limit = '')
	{
		$this->db->select("GRQ.subject_id,S.name as subject_name,count(GRQ.subject_id) as question_per_subject,COUNT(IF(GRQ.answer_type = 'correct', 1, NULL)) 'correct_ans_by_subject',SUM(GRQ.game_time) as subject_game_time");
		$this->db->from('game_result_question as GRQ');
		$this->db->join('subject as S', 'GRQ.subject_id = S.id', 'left');
		$this->db->group_by('GRQ.subject_id');
		$this->db->where('GRQ.game_table_id', $game_id);
		if ($limit != '') {
			$this->db->limit($limit);
		}
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['subject_id'] = $value['subject_id'];
				$data[$key]['subject_name'] = $value['subject_name'];
				$data[$key]['question_per_subject'] = $value['question_per_subject'];
				$data[$key]['correct_ans_by_subject'] = $value['correct_ans_by_subject'];
				$data[$key]['subject_game_time'] = $value['subject_game_time'];
				$data[$key]['subject_percent'] = $this->get_percent($data[$key]['question_per_subject'], $data[$key]['correct_ans_by_subject']);
				$data[$key]['subject_answer'] = "(" . $data[$key]['correct_ans_by_subject'] . "/" . $data[$key]['question_per_subject'] . ")";
			}
		}
		return $data;
	}

	public function get_individual_section_performance($game_id, $limit = '')
	{
		$this->db->select("GRQ.section_id,S.name as section_name,count(GRQ.section_id) as question_per_section,COUNT(IF(GRQ.answer_type = 'correct', 1, NULL)) 'correct_ans_by_section',SUM(GRQ.game_time) as section_game_time");
		$this->db->from('game_result_question as GRQ');
		$this->db->join('section as S', 'GRQ.section_id = S.id', 'left');
		$this->db->group_by('GRQ.section_id');
		$this->db->where('GRQ.game_table_id', $game_id);
		if ($limit != '') {
			$this->db->limit($limit);
		}
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['section_id'] = $value['section_id'];
				$data[$key]['section_name'] = $value['section_name'];
				$data[$key]['question_per_section'] = $value['question_per_section'];
				$data[$key]['correct_ans_by_section'] = $value['correct_ans_by_section'];
				$data[$key]['section_game_time'] = $value['section_game_time'];
				$data[$key]['section_percent'] = $this->get_percent($data[$key]['question_per_section'], $data[$key]['correct_ans_by_section']);
				$data[$key]['section_answer'] = "(" . $data[$key]['correct_ans_by_section'] . "/" . $data[$key]['question_per_section'] . ")";
			}
		}
		return $data;
	}

	public function get_individual_topic_performance($game_id, $limit = '')
	{
		$this->db->select("GRQ.subject_id,GRQ.section_id,GRQ.topic_id,T.name as topic_name,COUNT(GRQ.topic_id) as question_per_topic,COUNT(IF(GRQ.answer_type = 'correct', 1, NULL)) 'correct_ans_by_topic',SUM(GRQ.game_time) as topic_game_time");
		$this->db->from('game_result_question as GRQ');
		$this->db->join('topic as T', 'GRQ.topic_id = T.id', 'left');
		$this->db->group_by('GRQ.topic_id');
		$this->db->where('GRQ.game_table_id', $game_id);
		if ($limit != '') {
			$this->db->limit($limit);
		}
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['subject_id'] = $value['subject_id'];
				$data[$key]['section_id'] = $value['section_id'];
				$data[$key]['topic_id'] = $value['topic_id'];
				$data[$key]['topic_name'] = $value['topic_name'];
				$data[$key]['question_per_topic'] = $value['question_per_topic'];
				$data[$key]['correct_ans_by_topic'] = $value['correct_ans_by_topic'];
				$data[$key]['topic_game_time'] = $value['topic_game_time'];
				$data[$key]['topic_percent'] = $this->get_percent($data[$key]['question_per_topic'], $data[$key]['correct_ans_by_topic']);
				$data[$key]['topic_answer'] = "(" . $data[$key]['correct_ans_by_topic'] . "/" . $data[$key]['question_per_topic'] . ")";
			}
		}
		return $data;
	}

	public function get_percent($total_question, $correct_answer)
	{
		$percent = round($correct_answer * 100 / $total_question, 2, PHP_ROUND_HALF_UP);
		return $percent;
	}

	public function performance_summary($user_id)
	{
		$this->db->select('SUM(GR.total_question) as total_total_question,
		SUM(GR.correct_question) as total_correct_question,
		SUM(GR.wrong_question) as total_wrong_question,
		SUM(GR.unanswer_question) as total_unanswer_question,SUM(GR.get_point) as total_get_point,COUNT(GR.user_id) as total_game_played');
		$this->db->from('game_result as GR');
		$this->db->join('game_type as GT', 'GR.challenge_id = GT.id', 'left');
		$this->db->where('GR.user_id', $user_id);
		$performance = $this->db->get()->row_array();

		$this->db->select("GR.id as game_id,GT.name as challenge_name,GR.performance,GR.created_at");
		$this->db->from('game_result as GR');
		$this->db->join('game_type as GT', 'GR.challenge_id = GT.id', 'left');
		$this->db->order_by('GR.performance', 'desc');
		$this->db->where('GR.user_id', $user_id);
		$this->db->limit(1);
		$performance['best_performance'] = $this->db->get()->row_array();

		$this->db->select("GR.id as game_id,GT.name as challenge_name,GR.performance,GR.created_at");
		$this->db->from('game_result as GR');
		$this->db->join('game_type as GT', 'GR.challenge_id = GT.id', 'left');
		$this->db->order_by('GR.performance', 'asc');
		$this->db->where('GR.user_id', $user_id);
		$this->db->limit(1);
		$performance['worst_performance'] = $this->db->get()->row_array();

		$this->db->select("id");
		$this->db->from('game_result');
		$this->db->order_by('id', 'desc');
		$this->db->where('user_id', $user_id);
		$this->db->limit(1);
		$result = $this->db->get()->row_array();
		if ($result) {
			$performance['recent_game_id'] = $result['id'];
		} else {
			$performance['recent_game_id'] = 0;
		}
		return $performance;
	}

	public function performance_history($user_id, $limit = '')
	{
		$this->db->select("*");
		$this->db->from('game_result');
		$this->db->order_by('id', 'desc');
		$this->db->where('user_id', $user_id);
		if ($limit != '') {
			$this->db->limit($limit);
		}
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['game_id'] = $value['id'];
				$data[$key]['challenge_id'] = $value['challenge_id'];
				$data[$key]['title'] = get_performance_title($value['performance']);
				$data[$key]['total_question'] = $value['total_question'];
				$data[$key]['correct_question'] = $value['correct_question'];
				$data[$key]['performance'] = $value['performance'];
				$data[$key]['wrong_question'] = $value['wrong_question'];
				$data[$key]['answred_question'] = $value['correct_question'] + $value['wrong_question'];
				$data[$key]['game_date'] = $value['created_at'];
			}
		}
		return $data;
	}

	public function get_game_solution($per_page = '', $offset = '', $user_id, $game_id = '', $type = '', $subject_id = '', $section_id = '', $topic_id = '', $batch_id = '', $difficulty = '', $slug = '', $count = false)
	{
		$game_ids = array();
		if ($slug == "profile") {
			$game_result = $this->get_list("game_result", array("user_id", $user_id), "id");
			if (!empty($game_result)) {
				foreach ($game_result as $value) {
					$game_ids[] = $value['id'];
				}
			}
		}
		$this->db->select('Q.id,Q.title,Q.answer,Q.difficulty,Q.picture,Q.answer_explain,Q.option_1,Q.option_2,Q.option_3,Q.option_4,GRQ.answer_type');
		$this->db->from('game_result_question as GRQ');
		$this->db->join('game_result as GR', 'GRQ.game_table_id = GR.id');
		$this->db->join('subject as S', 'GRQ.subject_id = S.id');
		$this->db->join('section as SEC', 'GRQ.section_id = SEC.id');
		$this->db->join('topic as T', 'GRQ.topic_id = T.id');
		$this->db->join('question as Q', 'GRQ.question_id = Q.id');
		if ($batch_id != '') {
			$this->db->join('question_batch_year as QBY', 'QBY.question_id = Q.id');
			$this->db->where('QBY.batch_id', $batch_id);
		}
		if (!empty($game_ids)) {
			$this->db->where_id('GRQ.game_table_id', $game_ids);
		} else {
			$this->db->where('GR.user_id', $user_id);
			if ($game_id != '')
				$this->db->where('GRQ.game_table_id', $game_id);
		}

		if ($type != '')
			$this->db->where('GRQ.answer_type', $type);

		if ($subject_id != '')
			$this->db->where('GRQ.subject_id', $subject_id);

		if ($section_id != '')
			$this->db->where('GRQ.section_id', $section_id);

		if ($topic_id != '')
			$this->db->where('GRQ.topic_id', $topic_id);

		if ($difficulty != '')
			$this->db->where('Q.difficulty', $difficulty);

		if ($count) {
			return $this->db->count_all_results();
		}
		$this->db->order_by('Q.id', 'desc');
		$this->db->limit($per_page, $offset);
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['title'] = $value['title'];
				$data[$key]['options'] = [
					"0" => $value['option_1'],
					"1" => $value['option_2'],
					"2" => $value['option_3'],
					"3" => $value['option_4'],
				];
				$data[$key]['answer_explain'] = html_entity_decode($value['answer_explain']);
				$data[$key]['picture'] = $value['picture'];
				$data[$key]['difficulty'] = $value['difficulty'];
				$data[$key]['is_bookmarked'] = $this->exits_check("question_bookmark", array("user_id" => $user_id, "question_id" => $value['id']));
				$data[$key]['answer'] = $value['answer'] - 1;
				$data[$key]['answer_type'] = $value['answer_type'];
			}
		}
		return $data;
	}
}

/* End of file Auth_model.php */
