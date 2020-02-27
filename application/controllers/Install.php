<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends MY_Controller {

    public function index()
    {
        
    }
    public function truncate($table="all")
    {
//    	debug_r($table);
        if($table=="all")
        {
            $this->db->truncate("category");
            $this->db->truncate("batch");
            $this->db->truncate("subject");
            $this->db->truncate("subject_assign");
            $this->db->truncate("section");
            $this->db->truncate("section_assign");
            $this->db->truncate("topic");
            $this->db->truncate("topic_assign");
            $this->db->truncate("question");
            $this->db->truncate("topics_questions");
            $this->db->truncate("question_batch_year");
            $this->db->truncate("library");
            $this->db->truncate("library_image");
            $this->db->truncate("library_video");
            $this->db->truncate("topic_library");
            $this->db->truncate("ci_sessions");
        }else{
            if($this->db->table_exists($table))
            {
                $this->db->truncate($table);
            }
        }
    }

}

/* End of file Install.php */
