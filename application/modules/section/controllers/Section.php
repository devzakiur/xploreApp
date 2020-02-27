<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 * @property Section_Model $section
 */
class Section extends MY_Controller {
    public $data=array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Section_Model','section',true);
        $this->session->set_userdata('top_menu', 'general_setup');
        $this->session->set_userdata('sub_menu', 'section');
    }

	public function index()
    {
        if(!hasPermission("section",VIEW)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        $this->data['category_list']=$this->section->get_list("category",array("status=>1"),'','','','position','asc');
        $this->layout->title("Manage Section");
        $this->data['add']=true;
        $this->layout->view('index',$this->data);
    }

	public function add()
    {
        if(!hasPermission("section",ADD)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        if($_POST)
        {
           $this->_prepare_validation();
           if ($this->form_validation->run() ==TRUE) {
                $data=$this->_get_posted_data();
                $insert=$this->section->insert('section', $data);
                $send_data['msg']="success";
                $send_data['success']="Add Successfully";
                echo json_encode($send_data);
                exit;
            } else {
                $send_data['msg']=validation_errors();
                echo json_encode($send_data);
                exit;
            }
            redirect('section');
        }
    }
    //section ajax view
    public function view()
    {
        if($_GET)
        {
        	$category_id=$this->input->get("category_id");
        	$subject_id=$this->input->get("subject_id");
            $this->data['all_section']=$this->section->get_section_list($category_id,$subject_id);
            $result=$this->load->view("section-view",$this->data,true);
            echo json_encode($result);
            exit;
        }
    }
    public function edit($id=null)
    {
        if(!hasPermission("section",EDIT)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }

        $single=$this->section->get_single('section',array("id"=>$id));
        $this->data['category_list']=$this->section->get_list("category",array("status=>1"),'','','','position','asc');
        if($single){
        	if($_POST)
        	{
				$this->_prepare_validation();
				if ($this->form_validation->run() ==TRUE) {
						$data=$this->_get_posted_data();
						$this->section->update('section', $data,array("id"=>$id));
						setMessage("msg","success","Update Sucessfully.");
					} else {
						setMessage("msg","warning",validation_errors());
					}
					redirect('section');
        	}

            $this->layout->title("Manage Category");
            $this->data['edit']=true;

            $this->data['single']=$single;
            $this->layout->view('index',$this->data);

        }else{
            show_404();
        }

    }
    public function delete($id = null)
    {
        $result = $this->section->get_single("section", array("id" => $id));
        $status = 0;
        if (isset($result)) {
            setMessage("msg", "success", " Deleted Successfuly");
            $this->section->delete("section",array("id" => $id));
        }
        redirect('section');
    }
    public function control($id = null)
    {
        $result = $this->section->get_single("section", array("id" => $id));
        $status = 0;
        if (isset($result)) {
        	setMessage("msg", "success", "Disable Successfuly");
        	if($result->status==0)
			{
				$status=1;
            	setMessage("msg", "success", "Enable Successfuly");
			}
            $this->section->update("section",array("status"=>$status),array("id" => $id));
        }
        redirect('section');
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
            $name = $this->section->duplicate_check("section","name",$this->input->post('name'));
            if ($name) {
                $this->form_validation->set_message('name', "Section Name Already Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $name = $this->section->duplicate_check("section","name",$this->input->post('name'), $this->input->post('id'));
            if ($name) {
                $this->form_validation->set_message('name', "Section name Already Exits");
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


	public function section_assign()
	{
		checkPermission("section_assign",VIEW);


        $this->session->set_userdata('sub_menu', 'section-assign');
        $this->layout->title("Section Assign");
        $this->data['add']=true;
        $this->data['section']=$this->section->get_list("section",array("status"=>1),"","","","position","ASC");
        $this->data['subject']=$this->section->get_assign_subject_list();
        $this->data['category_list']=$this->section->get_list("category",array("status"=>1),'','','','id','desc');
        $this->layout->view('section-assign',$this->data);

    }

	public function section_assign_add()
	{
		checkPermission("section_assign",ADD);
		if($_POST)
		{
			$_POST=$this->security->xss_clean($_POST);
			$section_id= $this->input->post('section_id');
			$this->section->trans_start();
			@$this->section->delete("section_assign",array("section_id"=>$section_id));
			$subject_id= $this->input->post('subject_id');
			$data=array();
			foreach ($subject_id as $key=>$value)
			{
				$data[$key]['subject_id']=$value;
				$data[$key]['section_id']= $section_id;
			}
			$this->section->insert_batch("section_assign",$data);
			$this->section->trans_complete();
			if($this->section->trans_status())
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

	public function checkAssignSection()
	{
		if($_POST)
		{
			$section_id=$this->input->post("section_id");
			$data=$this->section->get_list("section_assign",array("section_id"=>$section_id),"subject_id");
			$result=[];
			if($data){
				foreach ($data as $value)
				{
					$result[]=$value['subject_id'];
				}
			}
			echo json_encode(implode(',',$result));
			exit;

		}
    }

	public function assignSectionView()
	{
		if($_POST)
		{
			$section_id= $this->input->post('section_id');
			$result['assign_section']= $this->section->get_section_assign($section_id);
			$html=$this->load->view('section-assign-view', $result, true);
			echo json_encode($html);
			exit;
		}
    }
   public function section_assign_delete($id = null)
    {
    	checkPermission("section_assign",DELETE);

        $result = $this->section->get_single("section_assign", array("section_id" => $id));
        if (isset($result)) {
            setMessage("msg", "success", " Deleted Successfuly");
            $this->section->delete("section_assign",array("section_id" => $id));
        }
        redirect('section/section_assign');
    }
}

/* End of file Users.php */
