<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Transfer_model extends MY_Model {

    public function student_duplicate_check($table_name, $index_array)
    {
        $this->db->where($index_array);
        return $this->db->get($table_name)->num_rows();
    }

}

/* End of file Transfer_model.php */
