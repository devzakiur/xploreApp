<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Batch_Model extends MY_Model
{
	public function get_all_batch()
	{
		$this->db->select('B.*,C.name as category_name');
		$this->db->from('batch as B');
		$this->db->join('category as C', 'B.category_id = C.id', 'left');
		return $this->db->get()->result_array();
	}

}

/* End of file .php */
