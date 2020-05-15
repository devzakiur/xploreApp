<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 * @property Modeltest_Model $modeltest
 */
class Modeltest extends MY_Controller {
    public $data=array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Modeltest_Model','modeltest',true);
        $this->session->set_userdata('top_menu', 'model_test');
        $this->session->set_userdata('sub_menu', 'model_test');
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
		checkPermission("model_test",VIEW);

        $this->layout->title("Manage Model Test");
        $this->data['add']=true;
        $this->data['category']=$this->modeltest->get_list("category",array("status"=>1));
        $this->layout->view('index',$this->data);
    }
    public function add()
    {
		checkPermission("model_test",ADD);

        if($_POST)
        {
           $this->_prepare_validation();
           if ($this->form_validation->run() ==TRUE) {
                $data=$this->_get_posted_data();
                $this->modeltest->trans_start();
                $insert_id=$this->modeltest->insert('model_test', $data);
				$subject_ids=$this->input->post("subject_id");
                $get_question_data=$this->modeltest->get_question($data['category_id'],$subject_ids,$data['total_question'],$insert_id);
                $this->modeltest->insert_batch("model_test_question",$get_question_data);
                $this->modeltest->trans_complete();
                if($this->modeltest->trans_status()){
					$send_data['msg']="success";
					$send_data['id']=$insert_id;
					$send_data['success']="Add Successfully";
				}
                else{
					$send_data['msg']="error";
					$send_data['success']="Somthing Wrong";
				}
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
            $this->data['all_modeltest']=$this->modeltest->get_all_model_test();
//            debug_r($this->data['all_subject']);
            $result=$this->load->view("model-test-view",$this->data,true);
            echo json_encode($result);
            exit;
        }
    }
    public function edit($id=null)
    {
		checkPermission("model_test",EDIT);

        $single=$this->modeltest->get_single("model_test",array("id"=>$id));
        if($single){
			if($single->status!=0)
			{
				show_404();
			}
        	if($_POST)
        	{
				$this->_prepare_validation();
				if ($this->form_validation->run() ==TRUE) {
						$data=$this->_get_posted_data();
						$this->modeltest->update('model_test', $data,array("id"=>$id));
						setMessage("msg","success","Update Sucessfully.");
					} else {
						setMessage("msg","warning",validation_errors());
					}
					redirect('modeltest');
        	}

            $this->layout->title("Manage Model Test");
            $this->data['edit']=true;

            $this->data['single']=$single;
            $this->layout->view('index',$this->data);

        }else{
            show_404();
        }

    }

    public function delete($id = null)
    {
    	checkPermission("model_test",DELETE);
		$result = $this->modeltest->get_single("model_test", array("id" => $id));
		if($result->status!=0)
		{
			show_404();
		}
        $status = 0;
        if (isset($result)) {
            setMessage("msg", "success", " Deleted Successfuly");
            $this->modeltest->delete("model_test",array("id" => $id));
            $this->modeltest->delete("model_test_question",array("model_test_id" => $id));
        }
        redirect('modeltest');
    }
    public function control($id = null)
    {
    	checkPermission("model_test",DELETE);
        $result = $this->modeltest->get_single("model_test", array("id" => $id));
        $status = 0;
        if (isset($result)) {
        	if($result->status==0)
			{
				$model_question=$this->modeltest->count_all("model_test_question",array("model_test_id"=>$id));
				if($model_question!=$result->total_question)
				{
					setMessage("msg", "warning", "You need add $result->total_question questions ");
        			redirect('modeltest');
        			exit();
				}
				$status=1;
            	setMessage("msg", "success", "Published Successfuly");
            	$this->modeltest->update("model_test",array("status"=>$status,"published_by"=>logged_in_user_id()),array("id" => $id));
			}else{
        		setMessage("msg", "warning", "Already Published");
			}
        }
        redirect('modeltest');
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
    	if($this->input->post("id")=='')
		{
        	$this->form_validation->set_rules('category_id', 'Category', 'trim|required');
        	$this->form_validation->set_rules('total_question', 'Total Question', 'trim|required');
		}
        $this->form_validation->set_rules('title', 'Title', 'trim|required');
        $this->form_validation->set_rules('date', 'Date', 'trim|required');
        $this->form_validation->set_rules('time', 'Time', 'trim|required');
        $this->form_validation->set_rules('duration', 'Duration', 'trim|required');
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
        if($this->input->post("id")==''){
        	$data['category_id']=$this->input->post("category_id");
        	$data['total_question']=$this->input->post("total_question");
        	$data['created_by ']=logged_in_user_id();
		}
        $data['title']=$this->input->post("title");
        $data['date']=$this->input->post("date")." ".$this->input->post("time");
        $data['duration']=$this->input->post("duration");
        $data['syllabus']=htmlentities($this->input->post("syllabus"));
        if($this->input->post("id"))
        {
        	$data['update_by']=logged_in_user_id();
        }
        return $data;
    }

	public function addquestion($id=null)
	{
		checkPermission("model_test",VIEW);
		$result = $this->modeltest->get_single("model_test", array("id" => $id));
		if($result->status!=0)
		{
			show_404();
		}
        if($result)
		{
        	$this->layout->title("Manage Model Test");
        	$this->data['category_id']=$result->category_id;
        	$this->data['model_test_id']=$result->id;
			$this->data['subject_list']=$this->modeltest->get_subject_list($id);
			$this->data['all_question']=$this->modeltest->get_list("model_test_question",array("model_test_id"=>$id));
			$this->layout->view('all-model-question',$this->data);
		}else{
        	show_404();
		}
    }

    public function all_question_view()
    {
        if($_POST)
        {
        	$category_id=trim($this->input->post("category_id"));
        	$subject_id=trim($this->input->post("subject_id"));
        	$section_id=trim($this->input->post("section_id"));
        	$topic_id=trim($this->input->post("topic_id"));
        	$model_test_id=trim($this->input->post("model_test_id"));
        	$derimine=trim($this->input->post("derimine"));
        	$question_ids=array();
        	$question_list=$this->modeltest->get_list("model_test_question",array("model_test_id"=>$model_test_id),"question_id");
        	if($question_list){
        		foreach ($question_list as $value)
				{
					$question_ids[]=$value['question_id'];
				}
			}
        	$offset=($this->uri->segment(3))? $this->uri->segment(3):0;
        	if($derimine=="all"){
        		$data['all_question']=$this->all_question($model_test_id,$question_ids,$offset,$category_id,$subject_id,$section_id,$topic_id);
			}
        	elseif($derimine=="model"){
        		$data['model_all_question']=$this->model_question($offset,$category_id,$model_test_id,$subject_id,$section_id,$topic_id);
			}else{
        		$data['all_question']=$this->all_question($model_test_id,$question_ids,$offset,$category_id,$subject_id,$section_id,$topic_id);
        		$data['model_all_question']=$this->model_question($offset,$category_id,$model_test_id,$subject_id,$section_id,$topic_id);

			}

			echo json_encode($data);
			exit;
        }
        else
		{
			show_404();
		}
    }

	private function all_question($model_test_id,$question_ids,$offset,$category_id,$subject_id,$section_id,$topic_id)
	{
			$this->load->library('pagination');
			$config['base_url']    = base_url('modeltest/all_question_view');
			$config['total_rows']  = $this->modeltest->get_all_question("","",$question_ids,$category_id,$subject_id,$section_id,$topic_id,true);
			$config['per_page']    = QUESTION_PER_PAGE;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0)">';
			$config['cur_tag_close'] = '</a></li>';
			$config['next_tag_open'] = '<li class="page-item">';
			$config['next_tagl_close'] = '</a></li>';
			$config['prev_tag_open'] = '<li class="page-item">';
			$config['prev_tagl_close'] = '</li>';
			$config['first_tag_open'] = '<li class="page-item disabled">';
			$config['first_tagl_close'] = '</li>';
			$config['last_tag_open'] = '<li class="page-item">';
			$config['last_tagl_close'] = '</a></li>';
			$config['attributes'] = array('class' => 'page-link');
			 $this->pagination->initialize($config);
			$this->data['all_question']=$this->modeltest->get_all_question(QUESTION_PER_PAGE,$offset,$question_ids,$category_id,$subject_id,$section_id,$topic_id);
			$this->data['serial']=$offset;
			$this->data['total_rows']=$config['total_rows'];
			$this->data['model_test_id']=$model_test_id;
			return $this->load->view("all-question-view",$this->data,true);
    }
    private function model_question($offset,$category_id,$model_test_id,$subject_id,$section_id,$topic_id)
	{
			$this->load->library('pagination');
			$config['base_url']    = base_url('modeltest/all_question_view');
			$config['total_rows']  = $this->modeltest->get_model_question("","",$category_id,$model_test_id,$subject_id,$section_id,$topic_id,true);
			$config['per_page']    = QUESTION_PER_PAGE;
			$config['full_tag_open'] = '<ul class="pagination">';
			$config['full_tag_close'] = '</ul>';
			$config['num_tag_open'] = '<li class="page-item">';
			$config['num_tag_close'] = '</li>';
			$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0)">';
			$config['cur_tag_close'] = '</a></li>';
			$config['next_tag_open'] = '<li class="page-item">';
			$config['next_tagl_close'] = '</a></li>';
			$config['prev_tag_open'] = '<li class="page-item">';
			$config['prev_tagl_close'] = '</li>';
			$config['first_tag_open'] = '<li class="page-item disabled">';
			$config['first_tagl_close'] = '</li>';
			$config['last_tag_open'] = '<li class="page-item">';
			$config['last_tagl_close'] = '</a></li>';
			$config['attributes'] = array('class' => 'page-link');
			 $this->pagination->initialize($config);
			$this->data['all_question']=$this->modeltest->get_model_question(QUESTION_PER_PAGE,$offset,$category_id,$model_test_id,$subject_id,$section_id,$topic_id);
			$this->data['serial']=$offset;
			$this->data['total_rows']=$config['total_rows'];
			return $this->load->view("model-all-question-view",$this->data,true);
	}

	public function delete_model_question()
	{
		if($_POST)
		{
			$model_question_id=$this->input->post('model_question_id');
			$this->modeltest->delete("model_test_question",array("id"=>$model_question_id));
			echo json_encode(array("message"=>"Delete Success"));
			exit();
		}
	}
	public function add_model_question()
	{
		if($_POST)
		{
			$data['model_test_id']=$this->input->post('model_test_id');
			$model_test=$this->modeltest->get_single("model_test",array("id"=>$data['model_test_id']));
			$model_question=$this->modeltest->count_all("model_test_question",array("model_test_id"=>$data['model_test_id']));
			if($model_question>=$model_test->total_question)
			{
				echo json_encode(array("message"=>"You cann't Add Question","status"=>false));
				exit();
			}else{
				$data['question_id']=$this->input->post('question_id');
				$data['subject_id']=$this->input->post('subject_id');
				$data['section_id']=$this->input->post('section_id');
				$data['topic_id']=$this->input->post('topic_id');
				$this->modeltest->insert("model_test_question",$data);
				echo json_encode(array("message"=>"Insert Success","status"=>true));
				exit();

			}
		}
	}
}

/* End of file Users.php */
