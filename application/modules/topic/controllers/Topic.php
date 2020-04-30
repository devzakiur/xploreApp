<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 * @property Topic_Model $topic
 */
class Topic extends MY_Controller {
    public $data=array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Topic_Model','topic',true);
        $this->session->set_userdata('top_menu', 'general_setup');
        $this->session->set_userdata('sub_menu', 'topic');
    }

	public function index()
    {
        if(!hasPermission("topic",VIEW)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        $this->data['category_list']=$this->topic->get_list("category",array("status=>1"),'','','','position','asc');
        $this->layout->title("Manage Topic");
        $this->data['add']=true;
        $this->layout->view('index',$this->data);
    }

	public function add()
    {
        if(!hasPermission("topic",ADD)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        if($_POST)
        {
           $this->_prepare_validation();
           if ($this->form_validation->run() ==TRUE) {
                $data=$this->_get_posted_data();
                $insert=$this->topic->insert('topic', $data);
                $send_data['msg']="success";
                $send_data['success']="Add Successfully";
                echo json_encode($send_data);
                exit;
            } else {
                $send_data['msg']=validation_errors();
                echo json_encode($send_data);
                exit;
            }
            redirect('topic');
        }
    }
    //topic ajax view
    public function view()
    {
        if($_GET)
        {

        	$category_id=$this->input->get("category_id");
        	$subject_id=$this->input->get("subject_id");
        	$section_id=$this->input->get("section_id");
            $this->data['all_topic']=$this->topic->get_topic_list($category_id,$subject_id,$section_id);
            $result=$this->load->view("topic-view",$this->data,true);
            echo json_encode($result);
            exit;
        }
    }
    public function edit($id=null)
    {
        if(!hasPermission("topic",EDIT)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }

        $single=$this->topic->get_single('topic',array("id"=>$id));
        $this->data['category_list']=$this->topic->get_list("category",array("status=>1"),'','','','position','asc');
        if($single){
        	if($_POST)
        	{
				$this->_prepare_validation();
				if ($this->form_validation->run() ==TRUE) {
						$data=$this->_get_posted_data();
						$this->topic->update('topic', $data,array("id"=>$id));
						setMessage("msg","success","Update Sucessfully.");
					} else {
						setMessage("msg","warning",validation_errors());
					}
					redirect('topic');
        	}

            $this->layout->title("Manage Category");
            $this->data['edit']=true;


            $this->data['single']=$single;
            $this->layout->view('index',$this->data);

        }else{
            show_404();
        }

    }

	/**
	 * @param null $id
	 */
	public function delete($id = null)
    {
        $result = $this->topic->get_single("topic", array("id" => $id));
        if (isset($result)) {
        	if($this->topic->get_single("topic_", array("id" => $id)))
            setMessage("msg", "success", " Deleted Successfuly");
            $this->topic->delete("topic",array("id" => $id));
        }
        redirect('topic');
    }
    public function control($id = null)
    {
        $result = $this->topic->get_single("topic", array("id" => $id));
        $status = 0;
        if (isset($result)) {
        	setMessage("msg", "success", "Disable Successfuly");
        	if($result->status==0)
			{
				$status=1;
            	setMessage("msg", "success", "Enable Successfuly");
			}
            $this->topic->update("topic",array("status"=>$status),array("id" => $id));
        }
        redirect('topic');
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
            $name = $this->topic->duplicate_check("topic","name",$this->input->post('name'));
            if ($name) {
                $this->form_validation->set_message('name', "Topic Name Already Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $name = $this->topic->duplicate_check("topic","name",$this->input->post('name'), $this->input->post('id'));
            if ($name) {
                $this->form_validation->set_message('name', "Topic name Already Exits");
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


	public function topic_assign()
	{
		checkPermission("topic_assign",VIEW);


        $this->session->set_userdata('sub_menu', 'topic-assign');
        $this->layout->title("Topic Assign");
        $this->data['add']=true;
        $this->data['topic']=$this->topic->get_list("topic",array("status"=>1),"","","","name","ASC");
        $this->data['category_list']=$this->topic->get_list("category",array("status"=>1),'','','','id','desc');
        $this->data['section']=$this->topic->get_assign_section_list();
        $this->layout->view('topic-assign',$this->data);

    }

	public function topic_assign_add()
	{
		checkPermission("topic_assign",ADD);
		if($_POST)
		{
			$_POST=$this->security->xss_clean($_POST);
			$topic_id= $this->input->post('topic_id');
			$this->topic->trans_start();
			@$this->topic->delete("topic_assign",array("topic_id"=>$topic_id));
			$section_id= $this->input->post('section_id');
			$data=array();
			foreach ($section_id as $key=>$value)
			{
				$data[$key]['section_id']=$value;
				$data[$key]['topic_id']= $topic_id;
			}
			$this->topic->insert_batch("topic_assign",$data);
			$this->topic->trans_complete();
			if($this->topic->trans_status())
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

	public function checkAssignTopic()
	{
		if($_POST)
		{
			$topic_id=$this->input->post("topic_id");
			$data=$this->topic->get_list("topic_assign",array("topic_id"=>$topic_id),"section_id");
			$result=[];
			if($data){
				foreach ($data as $value)
				{
					$result[]=$value['section_id'];
				}
			}
			echo json_encode(implode(',',$result));
			exit;

		}
    }

	public function assignTopicView()
	{
		if($_POST)
		{
			$topic_id= $this->input->post('topic_id');
			$result['assign_topic']= $this->topic->get_topic_assign($topic_id);
			$html=$this->load->view('topic-assign-view', $result, true);
			echo json_encode($html);
			exit;
		}
    }
   public function topic_assign_delete($id = null)
    {
    	checkPermission("topic_assign",DELETE);

        $result = $this->topic->get_single("topic_assign", array("topic_id" => $id));
        if (isset($result)) {
            setMessage("msg", "success", " Deleted Successfuly");
            $this->topic->delete("topic_assign",array("topic_id" => $id));
        }
        redirect('topic/topic_assign');
    }
}

/* End of file Users.php */
