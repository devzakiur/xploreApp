<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 * @property Subject_Model $subject
 */
class Subject extends MY_Controller {
    public $data=array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Subject_Model','subject',true);
        $this->session->set_userdata('top_menu', 'general_setup');
        $this->session->set_userdata('sub_menu', 'subject');
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
		checkPermission("subject",VIEW);

        $this->layout->title("Manage Subject");
        $this->data['add']=true;
        $this->layout->view('index',$this->data);
    }
    public function add()
    {
		checkPermission("subject",ADD);

        if($_POST)
        {
           $this->_prepare_validation();
           if ($this->form_validation->run() ==TRUE) {
                $data=$this->_get_posted_data();
                $insert=$this->subject->insert('subject', $data);
                $send_data['msg']="success";
                $send_data['success']="Add Successfully";
                echo json_encode($send_data);
                exit;
            } else {
                $send_data['msg']=validation_errors();
                echo json_encode($send_data);
                exit;
            }
            redirect('subject');
        }
    }
    //subject ajax view
    public function view()
    {
        if($_GET)
        {
            $this->data['all_subject']=$this->subject->get_subject_list();
//            debug_r($this->data['all_subject']);
            $result=$this->load->view("subject-view",$this->data,true);
            echo json_encode($result);
            exit;
        }
    }
    public function edit($id=null)
    {
		checkPermission("subject",EDIT);

        $single=$this->subject->get_single("subject",array("id"=>$id));
        if($single){
        	if($_POST)
        	{
				$this->_prepare_validation();
				if ($this->form_validation->run() ==TRUE) {
						$data=$this->_get_posted_data();
						$this->subject->update('subject', $data,array("id"=>$id));
						setMessage("msg","success","Update Sucessfully.");
					} else {
						setMessage("msg","warning",validation_errors());
					}
					redirect('subject');
        	}

            $this->layout->title("Manage Category");
            $this->data['edit']=true;

        	$this->data['category']=$this->subject->get("category");

            $this->data['single']=$single;
            $this->layout->view('index',$this->data);

        }else{
            show_404();
        }

    }
    public function delete($id = null)
    {
    	checkPermission("subject",DELETE);
        $result = $this->subject->get_single("subject", array("id" => $id));
        $status = 0;
        if (isset($result)) {
            setMessage("msg", "success", " Deleted Successfuly");
            $this->subject->delete("subject",array("id" => $id));
        }
        redirect('subject');
    }
    public function control($id = null)
    {
    	checkPermission("subject",DELETE);
        $result = $this->subject->get_single("subject", array("id" => $id));
        $status = 0;
        if (isset($result)) {
        	setMessage("msg", "success", "Disable Successfuly");
        	if($result->status==0)
			{
				$status=1;
            	setMessage("msg", "success", "Enable Successfuly");
			}
            $this->subject->update("subject",array("status"=>$status),array("id" => $id));
        }
        redirect('subject');
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
            $name = $this->subject->duplicate_check("subject","name",$this->input->post('name'));
            if ($name) {
                $this->form_validation->set_message('name', "Subject Name Already Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $name = $this->subject->duplicate_check("subject","name",$this->input->post('name'), $this->input->post('id'));
            if ($name) {
                $this->form_validation->set_message('name', "Subject name Already Exits");
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
     * @description     : Process "batch" user input data validation
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
     * @description     : Prepare "batch" user input data to save into database
     *
     * @param           : null
     * @return          : $data array(); value
     * ********************************************************** */
    private function _get_posted_data()
    {
        $data=array();
        $data['name']=$this->input->post("name");
        $data['position']=$this->input->post("position");
        if($this->input->post("id"))
        {
        	$data['updateby']=logged_in_user_id();
        }
        return $data;
    }

	public function subject_assign()
	{
		checkPermission("subject_assign",VIEW);


        $this->session->set_userdata('sub_menu', 'subject-assign');
        $this->layout->title("Subject Assign");
        $this->data['add']=true;
        $this->data['subject']=$this->subject->get_list("subject",array("status"=>1),"","","","position","ASC");
        $this->data['category']=$this->subject->get_list("category",array("status"=>1),"","","","position","ASC");
        $this->layout->view('subject-assign',$this->data);

    }

	public function subject_assign_add()
	{
		checkPermission("subject_assign",ADD);
		if($_POST)
		{
			$_POST=$this->security->xss_clean($_POST);
			$subject_id= $this->input->post('subject_id');
			$this->subject->trans_start();
			@$this->subject->delete("subject_assign",array("subject_id"=>$subject_id));
			$category_id= $this->input->post('category_id');
			$data=array();
			foreach ($category_id as $key=>$value)
			{
				$data[$key]['subject_id']= $subject_id;
				$data[$key]['category_id']=$value;
			}
			$this->subject->insert_batch("subject_assign",$data);
			$this->subject->trans_complete();
			if($this->subject->trans_status())
			{
 				$send_data['msg']="success";
                $send_data['success']="Add Successfully";
                echo json_encode($send_data);
                exit;
			}
			else
			{
				$send_data['msg']="505 Internel Server Error";
                echo json_encode($send_data);
                exit;
			}

		}
    }

	public function checkAssignSubject()
	{
		if($_POST)
		{
			$subject_id=$this->input->post("subject_id");
			$data=$this->subject->get_list("subject_assign",array("subject_id"=>$subject_id),"category_id");
			$result=[];
			if($data){
				foreach ($data as $value)
				{
					$result[]=$value['category_id'];
				}
			}
			echo json_encode(implode(',',$result));
			exit;

		}
    }

	public function assignSubjectView()
	{
		if($_POST)
		{
			$subject_id= $this->input->post('subject_id');
			$result['assign_subject']= $this->subject->get_subject_assign($subject_id);
			$html=$this->load->view('subject-assign-view', $result, true);
			echo json_encode($html);
			exit;
		}
    }
   public function subject_assign_delete($id = null)
    {
    	checkPermission("subject_assign",DELETE);

        $result = $this->subject->get_single("subject_assign", array("subject_id" => $id));
        if (isset($result)) {
            setMessage("msg", "success", " Deleted Successfuly");
            $this->subject->delete("subject_assign",array("subject_id" => $id));
        }
        redirect('subject/subject_assign');
    }
}

/* End of file Users.php */
