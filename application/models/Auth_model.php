<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends MY_Model
{

	public function login_check($email = '', $phone = '')
	{
		$this->db->select('');
		$this->db->from('users');
		if ($email != '')
			$this->db->where('email', $email);
		if ($phone != "")
			$this->db->where('phone', $phone);
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		return $this->db->get()->row();
	}
}

/* End of file Auth_model.php */
