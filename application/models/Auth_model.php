<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Auth_model extends MY_Model
{

	public function login_check($email = '', $phone = '')
	{
		// return false;
		$this->db->select('');
		$this->db->from('users');
		if ($email != '' && $phone != '') {
			$this->db->where('email', $email);
			$this->db->where('phone', $phone);
		} else if ($email != '') {
			$this->db->where("email", $email);
		} else if ($phone != '') {
			$this->db->where("phone", $phone);
		} else {
			$this->db->where("phone", "-1");
		}
		$this->db->order_by('id', 'desc');
		$this->db->limit(1);
		return $this->db->get()->row();
	}
}

/* End of file Auth_model.php */
