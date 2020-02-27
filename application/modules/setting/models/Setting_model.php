<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Setting_model extends MY_Model {

    public function get_single_setting()
    {
        $this->db->select('S.*');
        $this->db->from('setting as S');
        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        return $this->db->get()->row();
    }

}

/* End of file Setting_model.php */
