<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Install extends MY_Controller {

    function __construct()
    {
        parent::__construct();

        /*
        |=============
        |   set header Cache control
        |=============
        */
        $this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0');
        $this->output->set_header('Pragma: no-cache');
    }
    public function index()
    {
        redirect('dashboard','refresh');
        
    }

    public function truncate() {
            $this->db->truncate("batch");
          	$this->db->truncate("category");
            $this->db->truncate("ci_sessions");
            $this->db->truncate("content");
            $this->db->truncate("device_info");
            $this->db->truncate("edit_history");
            $this->db->truncate("game_result");
            $this->db->truncate("game_result_question");
            $this->db->truncate("game_setting");
            $this->db->truncate("library");
            $this->db->truncate("library_image");
            $this->db->truncate("library_video");
            $this->db->truncate("question");
            $this->db->truncate("question_batch_year");
            $this->db->truncate("question_bookmark");
            $this->db->truncate("question_reports");
            $this->db->truncate("question_year");
            $this->db->truncate("recently_learn");
//            $this->db->truncate("roles_permissions");
            $this->db->truncate("section");
            $this->db->truncate("section_assign");
            $this->db->truncate("subject");
            $this->db->truncate("subject_assign");
            $this->db->truncate("topic");
            $this->db->truncate("topic_assign");
            $this->db->truncate("topics_questions");
            $this->db->truncate("topic_library");
            $this->db->truncate("users");
            $this->db->truncate("user_balance");
            $this->db->truncate("user_question");
            $this->db->truncate("user_question_count");
            $this->db->truncate("user_topics_questions");
    }
    /*
    |===============
    |   backup create
    |===============
    */
    public function create_backup() {
        $this->load->dbutil();

        $prefs = array(     
            'format'      => 'zip',             
            'filename'    => 'system_backup.sql'
            );


        $backup =$this->dbutil->backup($prefs); 

        $db_name = 'system_backup'. date("Y-m-d-H-i-s") .'.zip';
        $save = 'uploads/backup/'.$db_name;

        $this->load->helper('file');
        write_file($save, $backup); 


        $this->load->helper('download');
        force_download($db_name, $backup);
        
    }
     /*
    |===============
    |   backup restore
    |===============
    */
    public function restore_backup($file_name) {
        $filePath = './uploads/backup/'.$file_name.'.sql';
        if(file_exists($filePath))
        {
            if($this->restoreDatabaseTables($filePath))
            {
                return true;
            }
        }
        else 
        {
                
            redirect('errors/not-found','refresh');
        }
    }

    public function restoreDatabaseTables($filePath){
        // Temporary variable, used to store current query
        $templine = '';
        
        // Read in entire file
        $lines = file($filePath);
        
        $error = '';
        
        // Loop through each line
        foreach ($lines as $line){
            // Skip it if it's a comment
            if(substr($line, 0, 2) == '--' || $line == ''){
                continue;
            }
            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';'){
                // Perform the query
                if(!$this->db->query($templine)){
                    $error .= 'Error performing query "<b>' . $templine . '</b>": ' . $error . '<br /><br />';
                }
                // Reset temp variable to empty
                $templine = '';
            }
        }
        return !empty($error)?$error:true;
    }

}

/* Location: ./application/modules/install/controllers/Install.php */
