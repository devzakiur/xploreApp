<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 * @property Question_Model $question
 */
class Question extends MY_Controller {
    public $data=array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Question_Model','question',true);
        $this->session->set_userdata('top_menu', 'question_setup');
        $this->session->set_userdata('sub_menu', 'question');
    }

	public function index()
    {
        checkPermission("question",VIEW);

        $this->layout->title("Manage Question");
        $this->data['topic']= $this->question->get_assign_topic_list();
		$this->data['subject']=$this->question->get_assign_subject_list();
		$this->data['users']=$this->question->get_user();
         //batch and year
		 $this->config->load('bcs');
        $this->data['year']=$this->config->item('year');
        $this->data['category_list']=$this->question->get_list("category",array("status=>1"),'','','','position','asc');
        $this->data['batch']=$this->question->get("batch",'','id','desc');
        $this->data['add']=true;
        $this->layout->view('index',$this->data);
    }

	public function add()
    {
    	checkPermission("question",ADD);
        if($_POST)
        {
           $this->_prepare_validation();
           if ($this->form_validation->run() ==TRUE) {
                $data=$this->_get_posted_data();
                $this->question->trans_start();
                $question_insert_id=$this->question->insert('question', $data);
                $topic_hidden_id=$this->input->post("topic_hidden_id");
                $topics_questions_data=array();
                $question_batch_year_data=array();
                foreach ($topic_hidden_id as $t_key=>$t_value)
				{
					$topic_id= $this->input->post('topic_id_'.$t_value);
					$category_id= $this->input->post('category_id_'.$t_value);
					foreach ($category_id as $c_key=>$c_value)
					{
						$topics_questions_data[$c_key]['category_id']=$c_value;
						$topics_questions_data[$c_key]['question_id']=$question_insert_id;
						$topics_questions_data[$c_key]['topic_id']=$topic_id;
					}
					$this->question->insert_batch("topics_questions",$topics_questions_data);
					$topics_questions_data=array();
				}
                $question_batch=$this->input->post("question_batch");
                if(!empty($question_batch[0]))
				{
					foreach ($question_batch as $key=>$value)
					{
						$question_batch_year_data[$key]['question_id']=$question_insert_id;
						$question_batch_year_data[$key]['batch_id']=$value;
						$question_batch_year_data[$key]['question_year']=$this->input->post("question_year")[$key];
					}
                	$this->question->insert_batch("question_batch_year",$question_batch_year_data);
				}
                $this->question->trans_complete();
                if($this->question->trans_status())
				{
					$send_data['msg']="success";
					$send_data['success']="Add Successfully";
				}
                else
				{
					$send_data['msg']="Something Wrong. Try Again";
					$send_data['success']="error";

				}
                echo json_encode($send_data);
                exit;
            } else {
                $send_data['msg']=validation_errors();
                echo json_encode($send_data);
                exit;
            }
            redirect('question');
        }
    }

	/**
	 * @param $array
	 * @return bool
	 */
    function is_array_unique($array) {
    	return count($array) === count(array_unique($array));
    }
    //question ajax view
    public function view()
    {
        if($_POST)
        {
        	$search_key=trim($this->input->post("search_key"));
        	$created_by=trim($this->input->post("created_by"));
        	$category_id=trim($this->input->post("category_id"));
        	$subject_id=trim($this->input->post("subject_id"));
        	$section_id=trim($this->input->post("section_id"));
        	$topic_id=trim($this->input->post("topic_id"));
        	$batch_id=trim($this->input->post("batch_id"));
        	$year=trim($this->input->post("year"));
        	$filter_by=trim($this->input->post("filter_by"));
//        	debug_r($search_key);
        	$offset=($this->uri->segment(3))? $this->uri->segment(3):0;
        	$this->load->library('pagination');
			$config['base_url']    = base_url('question/view');
			$config['total_rows']  = $this->question->get_all_question("","",$search_key,$created_by,$filter_by,$category_id,$subject_id,$section_id,$topic_id,$batch_id,$year,true);
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
			$this->data['all_question']=$this->question->get_all_question(QUESTION_PER_PAGE,$offset,$search_key,$created_by,$filter_by,$category_id,$subject_id,$section_id,$topic_id,$batch_id,$year);
			$this->data['serial']=$offset;
			$this->data['total_rows']=$config['total_rows'];
			$result=$this->load->view("question-view",$this->data,true);
			echo json_encode($result);
			exit;
        }else
		{
			show_404();
		}
    }
	public function details_view()
	{
		if($_GET)
		{
			$question_id=$this->input->get("question_id");
			$result=$this->question->get_question_details($question_id);
			$html=$this->load->view("question-details",$result,true);
//			debug_r($result);
			echo json_encode($html);
			exit;
		}
    }
//    ajax topic relation
	public function topic_relation()
	{
		$topic_id= $this->input->get('topic_id');
		$section_name=array();
		$subject_name=array();
		$category_name=array();
		$category=array();
		if($topic_id!=null){
			$result=$this->question->get_topic_relation($topic_id);
				if($result)
				{
					foreach ($result as $rs_key=>$rs_value){
						$section_name[$rs_key]=$rs_value['section_name'];
						$subject_name[$rs_key]=$rs_value['subject_name'];
						$category_name[$rs_key]=$rs_value['category_name'];
						$category[$rs_key]=array("id"=>$rs_value['category_id'],"name"=>$rs_value['category_name']);
					}
				}
		}
		$final['section_name']=implode(', ',array_unique($section_name));
		$final['subject_name']=implode(', ',array_unique($subject_name));
		$final['category_name']=implode(', ',array_unique($category_name));
		$html=$this->load->view("topic-relation",$final,true);
		$send_data["html_data"]=$html;
		$send_data["category_data"]=$category;
		echo json_encode($send_data);
		exit;
	}

    public function edit($id=null)
    {
    	checkPermission("question",EDIT);
        $single=$this->question->get_single('question',array("id"=>$id));
        if($single){
        	if($_POST)
        	{
				$this->_prepare_validation();
				if ($this->form_validation->run() ==TRUE) {
						$data=$this->_get_posted_data();
						$this->question->trans_start();
						$this->question->update('question', $data,array("id"=>$id));
						$this->question->delete("topics_questions",array("question_id"=>$id));
						 $topic_hidden_id=$this->input->post("topic_hidden_id");
						$topics_questions_data=array();
						$question_batch_year_data=array();
						foreach ($topic_hidden_id as $t_key=>$t_value)
						{
							$topic_id= $this->input->post('topic_id_'.$t_value);
							$category_id= $this->input->post('category_id_'.$t_value);
							foreach ($category_id as $c_key=>$c_value)
							{
								$topics_questions_data[$c_key]['category_id']=$c_value;
								$topics_questions_data[$c_key]['question_id']=$id;
								$topics_questions_data[$c_key]['topic_id']=$topic_id;
							}
							$this->question->insert_batch("topics_questions",$topics_questions_data);
							$topics_questions_data=array();
						}
						$question_batch=$this->input->post("question_batch");
						$this->question->delete("question_batch_year",array("question_id"=>$id));
						if(!empty($question_batch[0]))
						{
							foreach ($question_batch as $key=>$value)
							{
								$question_batch_year_data[$key]['question_id']=$id;
								$question_batch_year_data[$key]['batch_id']=$value;
								$question_batch_year_data[$key]['question_year']=$this->input->post("question_year")[$key];
							}
							$this->question->insert_batch("question_batch_year",$question_batch_year_data);
						}
						$this->question->trans_complete();
						if($this->question->trans_status())
						{
							setMessage('msg','success',"Update Successfully");
						}
						redirect("question");
					} else {
						setMessage("msg","warning",validation_errors());
					}
					redirect('question');
        	}

            $this->layout->title("Manage Question");
            $this->data['edit']=true;
			$this->data['topic_id']=$this->question->get_topic_id($id);
			$this->data['subject']=$this->question->get_assign_subject_list();
			$this->data['users']=$this->question->get_user();
			$this->data['category_list']=$this->question->get_list("category",array("status=>1"),'','','','position','asc');
//			debug_r($this->data['topic_id']);

			$this->data['topic']= $this->question->get_assign_topic_list();
			 //batch and year
			 $this->config->load('bcs');
			$this->data['year']=$this->config->item('year');
			$this->data['batch']=$this->question->get("batch",'','id','desc');
			$this->data['batch_year_list']=$this->question->get_list("question_batch_year",array("question_id"=>$id),'','','','id','asc');
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
        $result = $this->question->get_single("question", array("id" => $id));
        if (isset($result)) {
            $this->question->trans_start();
            $this->question->delete("question",array("id" => $id));
            $this->question->delete("topics_questions",array("question_id" => $id));
            $this->question->delete("question_batch_year",array("question_id" => $id));
            @unlink($result->picture);
            $this->question->trans_complete();
            if($this->question->trans_status()){
            	setMessage("msg", "success", " Deleted Successfuly");
			}else
			{
            	setMessage("msg", "danger", " Not Deleted");

			}
        }
        redirect('question');
    }
    public function control($id = null)
    {
        $result = $this->question->get_single("question", array("id" => $id));
        $status = 0;
        if (isset($result)) {
        	if($result->status==0)
			{
				$status=1;
            	setMessage("msg", "success", "Approved Successfuly");
			}
        	else if($result->status==1)
			{
				$status=2;
            	setMessage("msg", "success", "Disable Successfuly");
			}
        	else if($result->status==2)
			{
				$status=1;
            	setMessage("msg", "success", "Enable Successfuly");
			}
            $this->question->update("question",array("status"=>$status),array("id" => $id));
        }
        redirect('question');
    }
     /** ***************Function name**********************************
    * @type            : Function
    * @function name   : name
    * @description     : Unique check for module name" data/value
    *
    * @param           : null
    * @return          : boolean true/false
    * ********************************************************** */
    public function title() {
        if ($this->input->post('id') == '') {
            $name = $this->question->duplicate_check("question","title",$this->input->post('title'));
            if ($name) {
                $this->form_validation->set_message('title', "Question Title Already Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $name = $this->question->duplicate_check("question","title",$this->input->post('title'), $this->input->post('id'));
            if ($name) {
                $this->form_validation->set_message('title', "Question Title Already Exits");
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
        $this->form_validation->set_rules('title', 'Title Required', 'trim|required|callback_title');
        $this->form_validation->set_rules('option_a', 'Option A Required', 'trim|required');
        $this->form_validation->set_rules('option_b', 'Option B Required', 'trim|required');
        $this->form_validation->set_rules('option_c', 'Option C Required', 'trim|required');
        $this->form_validation->set_rules('option_d', 'Option D Required', 'trim|required');
        $this->form_validation->set_rules('answer_explain', 'Answer Explain Required', 'trim|required');
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
        $data['title']=$this->input->post("title");
        $data['option_1']=$this->input->post("option_a");
        $data['option_2']=$this->input->post("option_b");
        $data['option_3']=$this->input->post("option_c");
        $data['option_4']=$this->input->post("option_d");
        $data['answer']=$this->input->post("answer");
        if($this->input->post("position")!=''){
        	$data['position']=$this->input->post("position");
		}else{
        	$data['position']=$this->question->count_all('question')+1;
		}
        $data['difficulty']=$this->input->post("difficulty");
        $data['answer_explain']=htmlentities($this->input->post("answer_explain"));
        $topic_hidden_id= $this->input->post('topic_hidden_id');
        $topic_id=array();
			foreach ($topic_hidden_id as $t_key=>$t_value)
			{
				$topic_id[]= $this->input->post('topic_id_'.$t_value);
			}
			if(!$this->is_array_unique($topic_id))
			{
				if($this->input->post('id'))
				{
					setMessage("msg","danger",'Topic id must be unique');
				}else
				{
					$send_data['msg']="Topic id must be unique";
					$send_data['success']="error";
					echo json_encode($send_data);
					exit;

				}
			}
        if ($_FILES['picture']['name']) {
			$image_name=$this->_upload_picture();
			$data['picture'] ="uploads/question/".$image_name;
		}
        if($this->input->post("id"))
        {
        	$data['updateby']=logged_in_user_id();
        }else{
        	$data['created_by_admin']=logged_in_user_id();
		}
        return $data;
    }
    public function _upload_picture()
    {
        $name = $_FILES['picture']['name'];
        $arr = explode('.', $name);
        $ext = end($arr);
        $imageName=APP_NAME.'_'.time()."Q.$ext";
        $config['upload_path']          = './uploads/question';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        $config['file_name']            = $imageName;
        $config['max_size']             = 500;
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('picture'))
        {
            if($this->input->post('id'))
			{
				setMessage("msg","danger","Picture".$this->upload->display_errors());
				redirect("question");
			}
			else
			{
				$send_data['msg']=$this->upload->display_errors();
				$send_data['success']="error";
				echo json_encode($send_data);
				exit;
			}
        }
        else
        {
            $this->load->library('image_lib');
            $config['image_library']  = 'gd2';
            $config['source_image'] = './uploads/question/'.$imageName;
            $config['create_thumb']   = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width']          = 300;
            $config['height']         = 300;
            $config['new_image']      = './uploads/question/'.$imageName;
            $this->image_lib->initialize($config);
            if ($this->image_lib->resize()) {
                $this->image_lib->clear();
            }
            if($this->input->post('id'))
            {
                $prev_photo=$this->question->get_single("question",array("id"=>$this->input->post('id')))->picture;
                @unlink($prev_photo);
            }
            return $imageName;
        }

    }

}

/* End of file Users.php */
