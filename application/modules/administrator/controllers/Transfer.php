<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Transfer extends MY_Controller
{
    public $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Transfer_model', "transfer", true);
        $this->session->set_userdata('top_menu', 'administrator');
    }
    /** ***************Function index**********************************
     * @type            : Function
     * @function name   : index
     * @description     : Process "Role" view                 
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    public function index()
    {
        if (!hasPermission("transfer", VIEW)) {
            setMessage("msg", "warning", "Permission Denied!");
            redirect('dashboard');
        }
        $this->session->set_userdata('sub_menu', 'administrator/transfer');

        $this->layout->title("Transfer");
        $this->data['session']=$this->transfer->get("session","","name","asc");
        $this->layout->view('administrator/transfer', $this->data);
    }
    public function student()
    {
        if (!hasPermission("transfer", VIEW)) {
            setMessage("msg", "warning", "Permission Denied!");
            redirect('dashboard');
        }

        if($_POST)
        {
            $new_session=$this->input->post("new_session");
            $student_id=$this->input->post("student_id");
            $data = array();
            foreach ($student_id as $key => $value) {
                $result = $this->transfer->student_duplicate_check("student_enrollment", array("running_session" => $new_session, "student_id" => $value));
                if ($result <= 0) {
                    $data[$key]['running_session'] = $new_session;
                    $data[$key]['student_id'] = $value;
                }
            }
            if (!empty($data)) {
                $this->transfer->insert_batch("student_enrollment", $data);
            }
            setMessage("msg", "success", "Student Swaping Successfully.");
            redirect("administrator/transfer");
        }else{
            redirect("administrator/transfer");
        }
    }
    public function course()
    {
        if (!hasPermission("transfer", VIEW)) {
            setMessage("msg", "warning", "Permission Denied!");
            redirect('dashboard');
        }

        if($_POST)
        {
            $new_session=$this->input->post("new_session");
            $old_session=$this->input->post("old_session_for_course");
            $course_id=$this->input->post("course_id");
            $data = array();
            foreach ($course_id as $key => $value) {
                $result = $this->transfer->student_duplicate_check("course_details", array("running_session" => $new_session, "course_id" => $value));
                if ($result <= 0) {
                    $tem_course_data=$this->transfer->get_single("course_details",array("course_id"=>$value,"running_session"=>$old_session));
                    $data[$key]['running_session'] = $new_session;
                    $data[$key]['course_id'] = $value;
                    $data[$key]['course_fee'] = $tem_course_data->course_fee;
                    $data[$key]['course_duration'] = $tem_course_data->course_duration;
                    $data[$key]['total_class'] = $tem_course_data->total_class;
                    $data[$key]['description'] = $tem_course_data->description;
                }
            }
            if (!empty($data)) {
                $this->transfer->insert_batch("course_details", $data);
            }
            setMessage("msg", "success", "Course Swaping Successfully.");
            redirect("administrator/transfer");
        }else{
            redirect("administrator/transfer");
        }
    }
}

/* End of file Role.php */
