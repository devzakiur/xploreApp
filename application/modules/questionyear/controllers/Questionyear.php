<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 * @property MY_Model $questionyear
 */
class Questionyear extends MY_Controller {
    public $data=array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MY_Model','questionyear',true);
        $this->session->set_userdata('top_menu', 'general_setup');
        $this->session->set_userdata('sub_menu', 'question-year');
    }
    /** ***************Function index**********************************
    * @type            : Function
    * @function name   : index
    * @description     : Process "Users" user view
    *
    * @param           : null
    * @return          : null
    * ********************************************************** */
    public function index()
    {
    	checkPermission("question_year",VIEW);
        $this->layout->title("Manage Question Year");
        $this->data['add']=true;
        $this->layout->view('index',$this->data);
    }
    public function add()
    {
       checkPermission("question_year",ADD);
        if($_POST)
        {
           $this->_prepare_validation();
           if ($this->form_validation->run() ==TRUE) {
                $data=$this->_get_posted_data();
                $insert=$this->questionyear->insert('question_year', $data);
                $send_data['msg']="success";
                $send_data['success']="Add Successfully";
                echo json_encode($send_data);
                exit;
            } else {
                $send_data['msg']=validation_errors();
                echo json_encode($send_data);
                exit;
            }
            redirect('questionyear');
        }
    }
    //category ajax view
    public function view()
    {
        if($_GET)
        {
            $this->data['questionyear']=$this->questionyear->get("question_year","","id","desc");
            $result=$this->load->view("question-year-view",$this->data,true);
            echo json_encode($result);
            exit;
        }
    }
    public function edit($id=null)
    {
        checkPermission("question_year",EDIT);

        $single=$this->questionyear->get_single("question_year",array("id"=>$id));
//        debug_r($single);
        if($single){
        	if($_POST)
        	{
				$this->_prepare_validation();
				if ($this->form_validation->run() ==TRUE) {
						$data=$this->_get_posted_data();
						$this->questionyear->update('question_year', $data,array("id"=>$id));
						setMessage("msg","success","Update Sucessfully.");
					} else {
						setMessage("msg","warning",validation_errors());
					}
					redirect('questionyear');
        	}

            $this->layout->title("Manage Question Year");
            $this->data['edit']=true;
            $this->data['single']=$single;
            $this->layout->view('index',$this->data);

        }else{
            show_404();
        }

    }
    public function delete($id = null)
    {
        $result = $this->questionyear->get_single("question_year", array("id" => $id));
        $status = 0;
        if (isset($result)) {
            setMessage("msg", "success", "Deleted Successfuly");
            $this->questionyear->delete("question_year",array("id" => $id));
        }
        redirect('questionyear');
    }
    public function control($id = null)
    {
        $result = $this->questionyear->get_single("question_year", array("id" => $id));
        $status = 0;
        if (isset($result)) {
        	setMessage("msg", "success", "Disable Successfuly");
        	if($result->status==0)
			{
				$status=1;
            	setMessage("msg", "success", "Enable Successfuly");
			}
            $this->questionyear->update("question_year",array("status"=>$status),array("id" => $id));
        }
        redirect('questionyear');
    }
     /** ***************Function name**********************************
    * @type            : Function
    * @function name   : name
    * @description     : Unique check for module name" data/value
    *
    * @param           : null
    * @return          : boolean true/false
    * ********************************************************** */
    public function name() {
        if ($this->input->post('id') == '') {
            $name = $this->questionyear->duplicate_check("question_year","name",$this->input->post('name'));
            if ($name) {
                $this->form_validation->set_message('name', "Question Year Already Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $name = $this->questionyear->duplicate_check("question_year","name",$this->input->post('name'), $this->input->post('id'));
            if ($name) {
                $this->form_validation->set_message('name', "Question Year Already Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }

    /** ***************Function _prepare_validation**********************************
     * @type            : Function
     * @function name   : _prepare_validation
     * @description     : Process "questionyear" user input data validation
     *
     * @param           : null
     * @return          : null
     * ********************************************************** */
    private function _prepare_validation()
    {
        $this->form_validation->set_rules('name', 'Name Required', 'trim|required|callback_name');
    }
    /** ***************Function _get_posted_data**********************************
     * @type            : Function
     * @function name   : _get_posted_data
     * @description     : Prepare "questionyear" user input data to save into database
     *
     * @param           : null
     * @return          : $data array(); value
     * ********************************************************** */
    private function _get_posted_data()
    {
        $data=array();
        $data['name']=$this->input->post("name");
        if($this->input->post("id"))
        {
        	$data['updateby']=logged_in_user_id();
        }
        return $data;
    }

}

/* End of file Users.php */
