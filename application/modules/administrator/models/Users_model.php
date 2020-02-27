<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends MY_Model {

    public function get_user()
    {
        $this->db->select('A.*,A.id as admin_id,R.name as role_name');
        $this->db->from('admin as A');
        $this->db->join('roles as R', 'A.role_id = R.id');
        $this->db->order_by('A.id', 'desc');
        $this->db->where('R.name!=',"Super Admin");
        return $this->db->get()->result_array();
    }

}

/* End of file Users_model.php */
