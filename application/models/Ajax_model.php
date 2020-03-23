<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Ajax_model extends MY_Model {
    function get_subject_by_category($category_id)
	{
		$this->db->select('S.id,S.name');
		$this->db->from('subject_assign as SA');
		$this->db->join('subject as S', 'SA.subject_id = S.id', 'left');
		$this->db->where('SA.category_id', $category_id);
		$this->db->order_by('S.position',"asc");
		return $this->db->get()->result_array();
	}
    function get_section_by_subject($subject_id)
	{
		$this->db->select('S.id,S.name');
		$this->db->from('section_assign as SA');
		$this->db->join('section as S', 'SA.section_id = S.id', 'left');
		$this->db->where('SA.subject_id', $subject_id);
		$this->db->order_by('S.position',"asc");
		return $this->db->get()->result_array();
	}
    function get_section_by_subject_category($category_id,$subject_id)
	{
		$this->db->select('S.id,S.name');
		$this->db->from('section_assign as SA');
		$this->db->join('section as S', 'SA.section_id = S.id', 'left');
		$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id', 'left');
		$this->db->where('SUBA.category_id', $category_id);
		$this->db->where('SA.subject_id', $subject_id);
		$this->db->order_by('S.position',"asc");
		return $this->db->get()->result_array();
	}
    function get_topic_by_section($section_id)
	{
		$this->db->select('T.id,T.name');
		$this->db->from('topic_assign as TA');
		$this->db->join('topic as T', 'TA.topic_id = T.id', 'left');
		$this->db->where('TA.section_id', $section_id);
		$this->db->order_by('T.position',"asc");
		return $this->db->get()->result_array();
	}
}

/* End of file Ajax.php */
