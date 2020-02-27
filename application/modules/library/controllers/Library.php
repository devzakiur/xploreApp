<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 * @property Library_Model $library
 */
class Library extends MY_Controller {
    public $data=array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Library_Model','library',true);
        $this->session->set_userdata('top_menu', 'library_setup');
        $this->session->set_userdata('sub_menu', 'library');
    }

	public function index()
    {
        checkPermission("library",VIEW);

        $this->layout->title("Manage Library");
        $this->data['topic']= $this->library->get_assign_topic_list();
        $this->data['subject']=$this->library->get_assign_subject_list();
			$this->data['users']=$this->library->get_user();
        $this->data['category_list']=$this->library->get_list("category",array("status=>1"),'','','','position','asc');
        $this->data['add']=true;
        $this->layout->view('index',$this->data);
    }

	public function add()
    {
    	checkPermission("library",ADD);
        if($_POST)
        {
           $this->_prepare_validation();
           if ($this->form_validation->run() ==TRUE) {
                $data=$this->_get_posted_data();
                $this->library->trans_start();
                $library_insert_id=$this->library->insert('library', $data);
                $topic_id=$this->input->post("topic_id");
                $library_topic_data=array();
                $category_id=$this->input->post("category_id");
                foreach ($category_id as $key=>$value)
				{
					$library_topic_data[$key]['category_id']=$value;
					$library_topic_data[$key]['library_id']=$library_insert_id;
					$library_topic_data[$key]['topic_id']=$topic_id;
				}
                $this->library->insert_batch("topic_library",$library_topic_data);
                $code=$this->input->post("video_url");

                $library_video_data=array();
                if($code[0]!='')
					{
						foreach ($code as $key=>$value)
						{
							$library_video_data[$key]['library_id']=$library_insert_id;
							$library_video_data[$key]['video_url']=$value;
							$library_video_data[$key]['video_title']=$this->input->post("video_title")[$key];
						}
					$this->library->insert_batch("library_video",$library_video_data);
				}
                if(!empty($_FILES['slide_picture']['name']))
				{
					$slide_data=array();
					$picture_name=$this->_upload_slide_picture();
					foreach ($picture_name as $key=>$value)
					{
						$slide_data[$key]['library_id']=$library_insert_id;
						$slide_data[$key]['slide_picture_title']=$value['picture_title'];
						$slide_data[$key]['picture']="uploads/library/slideimage/".$value['image_name'];
					}
					if(!empty($slide_data))
                	$this->library->insert_batch("library_image",$slide_data);
				}
                $this->library->trans_complete();
                if($this->library->trans_status())
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
            redirect('library');
        }
    }
    //library ajax view
    public function view()
    {
        if($_GET)
        {
        	$search_key=trim($this->input->get("search_key"));
        	$created_by=trim($this->input->get("created_by"));
        	$category_id=trim($this->input->get("category_id"));
        	$subject_id=trim($this->input->get("subject_id"));
        	$section_id=trim($this->input->get("section_id"));
        	$topic_id=trim($this->input->get("topic_id"));
        	$filter_by=trim($this->input->get("filter_by"));
        	$offset=($this->uri->segment(3))? $this->uri->segment(3):0;
        	$this->load->library('pagination');
			$config['base_url']    = base_url('library/view');
			$config['total_rows']  = $this->library->get_all_library("","",$search_key,$created_by,$filter_by,$category_id,$subject_id,$section_id,$topic_id,true);
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
			$this->data['all_library']=$this->library->get_all_library(QUESTION_PER_PAGE,$offset,$search_key,$created_by,$filter_by,$category_id,$subject_id,$section_id,$topic_id);
			$this->data['serial']=$offset;
			$this->data['total_rows']=$config['total_rows'];
			$result=$this->load->view("library-view",$this->data,true);
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
			$library_id=$this->input->get("library_id");
			$result=$this->library->get_library_details($library_id);
			$html=$this->load->view("library-details",$result,true);
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
			$result=$this->library->get_topic_relation($topic_id);
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
    	checkPermission("library",EDIT);

        $single=$this->library->get_library($id);
//        debug_r($single);
        if($single){
        	if($_POST)
        	{
				$this->_prepare_validation();
				if ($this->form_validation->run() ==TRUE) {
						 $data=$this->_get_posted_data();
						 $this->library->trans_start();
						 $this->library->update('library', $data,array("id"=>$id));
           				 $this->library->delete("library_video",array("library_id" => $id));
           				 $this->library->delete("topic_library",array("library_id" => $id));
           				 $topic_id=$this->input->post("topic_id");
						$library_topic_data=array();
						$category_id=$this->input->post("category_id");
						foreach ($category_id as $key=>$value)
						{
							$library_topic_data[$key]['category_id']=$value;
							$library_topic_data[$key]['library_id']=$id;
							$library_topic_data[$key]['topic_id']=$topic_id;
						}
						$this->library->insert_batch("topic_library",$library_topic_data);
						$library_picture=$this->library->get_list("library_image",array("library_id"=>$id));
						$slide_picture_name=array();
						$slide_picture_name=$this->input->post("slide_picture_name");
						if($library_picture)
						{
							foreach ($library_picture as $value)
							{
								if(!in_array($value['picture'], $slide_picture_name))
								{

									$this->library->delete("library_image",array("id" => $value['id']));
									@unlink($value['picture']);

								}

							}
						}
						$code=$this->input->post("video_url");
						$library_video_data=array();
						if($code[0]!='')
						{
							foreach ($code as $key=>$value)
							{
								$library_video_data[$key]['library_id']=$id;
								$library_video_data[$key]['video_url']=$value;
								$library_video_data[$key]['video_title']=$this->input->post("video_title")[$key];
							}

							$this->library->insert_batch("library_video",$library_video_data);
						}
						if(!empty($_FILES['slide_picture']['name']))
						{
							$slide_data=array();
							$picture_name=$this->_upload_slide_picture();
							foreach ($picture_name as $key=>$value)
							{
								$slide_data[$key]['library_id']=$id;
								$slide_data[$key]['slide_picture_title']=$value['picture_title'];
								$slide_data[$key]['picture']="uploads/library/slideimage/".$value['image_name'];
							}
							if(!empty($slide_data))
							$this->library->insert_batch("library_image",$slide_data);
						}
						$this->library->trans_complete();
						if($this->library->trans_status())
						{
							setMessage('msg','success',"Update Successfully");
						}
						redirect("library");
					} else {
						setMessage("msg","warning",validation_errors());
					}
					redirect('library');
        	}

            $this->layout->title("Manage Library");
            $this->data['edit']=true;
			$result=$this->library->get_topic_relation($single['topic_id']);
			$category=array();
			if($result)
			{
				foreach ($result as $rs_key=>$rs_value){
					$category[$rs_key]=array("id"=>$rs_value['category_id'],"name"=>$rs_value['category_name']);
				}
			}
			$this->data['topic']= $this->library->get_assign_topic_list();
			$this->data['subject']=$this->library->get_assign_subject_list();
			$this->data['users']=$this->library->get_user();
        	$this->data['category_list']=$this->library->get_list("category",array("status=>1"),'','','','position','asc');
			$this->data['category']= $category;
			$this->data['video_code']=$this->library->get_list("library_video",array("library_id"=>$id));
			$this->data['image_slide']=$this->library->get_list("library_image",array("library_id"=>$id));
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
        $result = $this->library->get_single("library", array("id" => $id));
        if (isset($result)) {
            $this->library->trans_start();
            $slide_result=$this->library->get_list("library_image",array("library_id"=>$id));
			@unlink($result->cover_image);
            $this->library->delete("library",array("id" => $id));
            $this->library->delete("library_video",array("library_id" => $id));
            $this->library->delete("library_image",array("library_id" => $id));
            $this->library->delete("topic_library",array("library_id" => $id));
				if($slide_result)
				{
					foreach ($slide_result as $value)
					{
						@unlink($value['picture']);

					}
				}
            $this->library->trans_complete();
            if($this->library->trans_status()){
            	setMessage("msg", "success", " Deleted Successfuly");
			}else
			{
            	setMessage("msg", "danger", " Not Deleted");

			}
        }
        redirect('library');
    }
    public function control($id = null)
    {
        $result = $this->library->get_single("library", array("id" => $id));
        $status = 0;
        if (isset($result)) {
        	if($result->status==0)
			{
				$status=1;
            	setMessage("msg", "success", "Approved Successfuly");
            	$this->library->update("library",array("approved_by"=>logged_in_user_id()),array("id"=>$id));
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
            $this->library->update("library",array("status"=>$status),array("id" => $id));
        }
        redirect('library');
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
        $this->form_validation->set_rules('title', 'Title Required', 'trim|required');
        $this->form_validation->set_rules('topic_id', 'Topic ', 'trim|required');
        $this->form_validation->set_rules('details', 'Details Required', 'trim|required');
        $this->form_validation->set_rules('gist', 'Gist Required', 'trim');
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
    	 $topic_id=$this->input->post("topic_id");
    	 $category_id=$this->input->post("category_id");
    	 $category_name=array();
    	 $is_exit=false;
		foreach ($category_id as $key=>$value)
		{
			if($this->input->post("id"))
			{
				$exit=$this->library->exits_check("topic_library",array("topic_id"=>$topic_id,"category_id"=>$value),$this->input->post("id"));

			}
			else
			{
				$exit=$this->library->exits_check("topic_library",array("topic_id"=>$topic_id,"category_id"=>$value));

			}
			if($exit)
			{
				$is_exit=true;
				$category_name[]=$this->library->get_single("category",array("id"=>$value))->name;
			}
		}
		if($is_exit)
		{
			if($this->input->post("id"))
			{
 				setMessage("msg","danger",implode(', ',$category_name)." these category already exits for this topic");
				redirect("library");
			}else
			{
				$send_data['msg']=implode(', ',$category_name)." these category already exits for this topic";
				$send_data['success']="error";
				echo json_encode($send_data);
			}
			exit;
		}
        $data=array();
        $data['title']=$this->input->post("title");
        if($this->input->post("position")!='')
		{
        	$data['position']=$this->input->post("position");

		}else{
        	$data['position']=$this->library->count_all('library')+1;
		}
        $data['details']=htmlentities($this->input->post("details"));
        $data['gist']=htmlentities($this->input->post("gist"));
        if ($_FILES['picture']['name']) {
			$image_name=$this->_upload_picture();
			$data['cover_image'] ="uploads/library/coverimage/".$image_name;
		}
        if($this->input->post("id"))
        {
        	$data['updateby']=logged_in_user_id();
        }else{
        	$data['created_by']=logged_in_user_id();
		}
        return $data;
    }
    public function _upload_picture()
    {
        $name = $_FILES['picture']['name'];
        $arr = explode('.', $name);
        $ext = end($arr);
        $imageName=APP_NAME.'_'.time()."C.$ext";
        $config['upload_path']          = './uploads/library/coverimage';
        $config['allowed_types']        = 'jpg|jpeg|png';
        $config['file_name']            = $imageName;
        $config['max_size']             = 500;
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('picture'))
        {
            if($this->input->post('id'))
			{
				 setMessage("msg","danger","Picture".$this->upload->display_errors());
				redirect("library");
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
            $config['source_image'] = './uploads/library/coverimage/'.$imageName;
            $config['create_thumb']   = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width']          = 300;
            $config['height']         = 300;
            $config['new_image']      = './uploads/library/coverimage/'.$imageName;
            $this->image_lib->initialize($config);
            if ($this->image_lib->resize()) {
                $this->image_lib->clear();
            }
            if($this->input->post('id'))
            {
                $prev_photo=$this->library->get_single("library",array("id"=>$this->input->post('id')))->picture;
                @unlink($prev_photo);
            }
            return $imageName;
        }

    }

    public function _upload_slide_picture()
    {
    	$is_error=false;
    	$error=array();
    	$data=array();
    	$count = count($_FILES['slide_picture']['name']);
    	for ($i=0;$i<$count;$i++)
		{
			if($_FILES['slide_picture']['name'][$i]!='')
			{
				$_FILES['file']['name'] = $_FILES['slide_picture']['name'][$i];
				$_FILES['file']['type'] = $_FILES['slide_picture']['type'][$i];
				$_FILES['file']['tmp_name'] = $_FILES['slide_picture']['tmp_name'][$i];
				$_FILES['file']['error'] = $_FILES['slide_picture']['error'][$i];
				$_FILES['file']['size'] = $_FILES['slide_picture']['size'][$i];

				$name = $_FILES['slide_picture']['name'][$i];
				$arr = explode('.', $name);
				$ext = end($arr);
				$imageName=APP_NAME.'_'.time()."S_$i".".$ext";
				$config['upload_path']          = './uploads/library/slideimage';
				$config['allowed_types']        = 'jpg|jpeg|png';
				$config['file_name']            = $imageName;
				$config['max_size']             = 500;
				$this->load->library('upload');
				$this->upload->initialize($config);
				if (!$this->upload->do_upload('file'))
				{
					setMessage("msg","danger","Slide Picture".$this->upload->display_errors());
					$error=$this->upload->display_errors();
					$is_error=true;
				}
				else
				{
					$this->load->library('image_lib');
					$config['image_library']  = 'gd2';
					$config['source_image'] = './uploads/library/slideimage/'.$imageName;
					$config['create_thumb']   = FALSE;
					$config['maintain_ratio'] = TRUE;
					$config['width']          = 300;
					$config['height']         = 300;
					$config['new_image']      = './uploads/library/slideimage/'.$imageName;
					$this->image_lib->initialize($config);
					if ($this->image_lib->resize()) {
						$this->image_lib->clear();
					}
					$data[$i]['image_name']=$imageName;
					$data[$i]['picture_title']=$this->input->post("slide_picture_title")[$i];
				}
			}

		}
		if($is_error){
			if($this->input->post('id'))
			{
				redirect("library");
			}
			else
			{
				$send_data['msg']=$error;
				$send_data['success']="error";
				echo json_encode($send_data);
				exit;
			}
		}
		else
		{
			return $data;
		}

    }

}

/* End of file Users.php */
