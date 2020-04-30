<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Info
 * @property NewsModel $news
 */
class News extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('NewsModel',"news",true);

        $this->session->set_userdata('top_menu', 'news_setup');
	}
	public function index()
    {
        checkPermission("news",VIEW);
        $this->session->set_userdata('sub_menu', 'news');
        $this->layout->title("Manage News");
        $this->data['category']= $this->news->get_list("news_category",array("status"=>1),"","","","position","asc");
        $this->data['add']=true;
        $this->layout->view('index',$this->data);
    }

	public function add()
    {
    	checkPermission("news",ADD);
        if($_POST)
        {
           $this->_prepare_validation();
           if ($this->form_validation->run() ==TRUE) {
                $data=$this->_get_posted_data();
                $this->news->trans_start();
                $news_insert_id=$this->news->insert('news', $data);
                $code=$this->input->post("video_url");

                $news_video_data=array();
                if($code[0]!='')
					{
						foreach ($code as $key=>$value)
						{
							$news_video_data[$key]['news_id']=$news_insert_id;
							$news_video_data[$key]['video_url']=$value;
							$news_video_data[$key]['video_title']=$this->input->post("video_title")[$key];
						}
					$this->news->insert_batch("news_video",$news_video_data);
				}
                if(!empty($_FILES['slide_picture']['name']))
				{
					$slide_data=array();
					$picture_name=$this->_upload_slide_picture();
					foreach ($picture_name as $key=>$value)
					{
						$slide_data[$key]['news_id']=$news_insert_id;
						$slide_data[$key]['slide_picture_title']=$value['picture_title'];
						$slide_data[$key]['picture']="uploads/news/slideimage/".$value['image_name'];
					}
					if(!empty($slide_data))
                	$this->news->insert_batch("news_image",$slide_data);
				}
                $this->news->trans_complete();
                if($this->news->trans_status())
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
        	$category_id=trim($this->input->get("category_id"));
        	$filter_by=trim($this->input->get("filter_by"));
        	$is_popular=trim($this->input->get("is_popular"));
        	$offset=($this->uri->segment(3))? $this->uri->segment(3):0;
        	$this->load->library('pagination');
			$config['base_url']    = base_url('news/view');
			$config['total_rows']  = $this->news->get_all_news("","",$search_key,$filter_by,$is_popular,$category_id,true);
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
			$this->data['all_news']=$this->news->get_all_news(QUESTION_PER_PAGE,$offset,$search_key,$filter_by,$is_popular,$category_id);
			$this->data['serial']=$offset;
			$this->data['total_rows']=$config['total_rows'];
			$result=$this->load->view("news-view",$this->data,true);
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
			$news_id=$this->input->get("news_id");
			$result=$this->news->get_news_details($news_id);
			$html=$this->load->view("news-details",$result,true);
			echo json_encode($html);
			exit;
		}
    }

    public function edit($id=null)
    {
    	checkPermission("news",EDIT);

        $single=$this->news->get_single("news",array("id"=>$id));
//        debug_r($single);
        if($single){
        	if($_POST)
        	{
				$this->_prepare_validation();
				if ($this->form_validation->run() ==TRUE) {
						 $data=$this->_get_posted_data();
						 $this->news->trans_start();
							 $this->news->update('news', $data,array("id"=>$id));
							 $this->news->delete("news_video",array("news_id" => $id));
							$news_picture=$this->news->get_list("news_image",array("news_id"=>$id));
							$slide_picture_name=array();
							$slide_picture_name=$this->input->post("slide_picture_name");
							$slide_picture_id=$this->input->post("slide_picture_id");

							if($news_picture)
							{
								foreach ($news_picture as $value)
								{
									if(!in_array($value['picture'], $slide_picture_name))
									{
											$this->news->delete("news_image",array("id" => $value["id"]));
											@unlink($value['picture']);
									}
								}
							}

							foreach ($slide_picture_name as $key=>$pre_image)
							{
								if ($pre_image!='' && !empty($_FILES['slide_picture']['name'][$key]))
								{
									$this->news->delete("news_image",array("id" => $slide_picture_id[$key]));
									@unlink($pre_image);
								}
							}
							$code=$this->input->post("video_url");
							$news_video_data=array();
							if($code[0]!='')
							{
								foreach ($code as $key=>$value)
								{
									$news_video_data[$key]['news_id']=$id;
									$news_video_data[$key]['video_url']=$value;
									$news_video_data[$key]['video_title']=$this->input->post("video_title")[$key];
								}

								$this->news->insert_batch("news_video",$news_video_data);
							}
							if(!empty($_FILES['slide_picture']['name']))
							{
								$slide_data=array();
								$picture_name=$this->_upload_slide_picture();
								foreach ($picture_name as $key=>$value)
								{
									$slide_data[$key]['news_id']=$id;
									$slide_data[$key]['slide_picture_title']=$value['picture_title'];
									$slide_data[$key]['picture']="uploads/news/slideimage/".$value['image_name'];
								}
								if(!empty($slide_data))
								$this->news->insert_batch("news_image",$slide_data);
							}
						$this->news->trans_complete();
						if($this->news->trans_status())
						{
							setMessage('msg','success',"Update Successfully");
						}
						redirect("news");
					} else {
						setMessage("msg","warning",validation_errors());
					}
					redirect('news');
        	}

            $this->layout->title("Manage News");
            $this->data['edit']=true;
       		 $this->session->set_userdata('sub_menu', 'news');
        	$this->data['category']= $this->news->get_list("news_category",array("status"=>1),"","","","position","asc");
			$this->data['video_code']=$this->news->get_list("news_video",array("news_id"=>$id));
			$this->data['image_slide']=$this->news->get_list("news_image",array("news_id"=>$id));
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
        $result = $this->news->get_single("news", array("id" => $id));
        if (isset($result)) {
            $this->news->trans_start();
            $slide_result=$this->news->get_list("news_image",array("news_id"=>$id));
			@unlink($result->cover_image);
            $this->news->delete("news",array("id" => $id));
            $this->news->delete("news_video",array("news_id" => $id));
            $this->news->delete("news_image",array("news_id" => $id));
				if($slide_result)
				{
					foreach ($slide_result as $value)
					{
						@unlink($value['picture']);

					}
				}
            $this->news->trans_complete();
            if($this->news->trans_status()){
            	setMessage("msg", "success", " Deleted Successfuly");
			}else
			{
            	setMessage("msg", "danger", " Not Deleted");

			}
        }
        redirect('news');
    }
    public function control($id = null)
    {
        $result = $this->news->get_single("news", array("id" => $id));
        $status = 0;
        if (isset($result)) {
        	if($result->status==0)
			{
				$status=1;
            	setMessage("msg", "success", "Published News");
			}
        	else if($result->status==1)
			{
				$status=0;
            	setMessage("msg", "success", "Not Published News");
			}
            $this->news->update("news",array("status"=>$status),array("id" => $id));
        }
        redirect('news');
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
        $this->form_validation->set_rules('date', 'Date ', 'trim|required');
        $this->form_validation->set_rules('is_popular', 'Is Popular ', 'trim|required');
        $this->form_validation->set_rules('category_id', 'Category ', 'trim|required');
        $this->form_validation->set_rules('details', 'Details Required', 'trim|required');
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
        $data['category_id']=$this->input->post("category_id");
        $data['date']=date("Y-m-d",strtotime($this->input->post("date")));
        $data['is_popular']=$this->input->post("is_popular");
        $data['details']=htmlentities($this->input->post("details"));
        if ($_FILES['picture']['name']) {
			$image_name=$this->_upload_picture();
			$data['cover_image'] ="uploads/news/coverimage/".$image_name;
		}
        return $data;
    }
    public function _upload_picture()
    {
        $name = $_FILES['picture']['name'];
        $arr = explode('.', $name);
        $ext = end($arr);
        $imageName=APP_NAME.'_'.time()."C.$ext";
        $config['upload_path']          = './uploads/news/coverimage';
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
				redirect("news");
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
            $config['source_image'] = './uploads/news/coverimage/'.$imageName;
            $config['create_thumb']   = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width']          = 300;
            $config['height']         = 300;
            $config['new_image']      = './uploads/news/coverimage/'.$imageName;
            $this->image_lib->initialize($config);
            if ($this->image_lib->resize()) {
                $this->image_lib->clear();
            }
            if($this->input->post('id'))
            {
                $prev_photo=$this->news->get_single("news",array("id"=>$this->input->post('id')))->picture;
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
				$config['upload_path']          = './uploads/news/slideimage';
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
					$config['source_image'] = './uploads/news/slideimage/'.$imageName;
					$config['create_thumb']   = FALSE;
					$config['maintain_ratio'] = TRUE;
					$config['width']          = 300;
					$config['height']         = 300;
					$config['new_image']      = './uploads/news/slideimage/'.$imageName;
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
				redirect("news");
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

	public function title()
	{
		if ($this->input->post('id') == '') {
            $title = $this->news->duplicate_check("news","title",$this->input->post('title'));
            if ($title) {
                $this->form_validation->set_message('title', "News Title Already Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $title = $this->news->duplicate_check("news","title",$this->input->post('title'), $this->input->post('id'));
            if ($title) {
                $this->form_validation->set_message('title', "News Title  Already Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
	
	/**
	 * category part
	 */
	public function news_category()
	{
		checkPermission("news_category",VIEW);

        $this->session->set_userdata('sub_menu', 'news_category');
        $this->layout->title("Manage News Category");
        $this->data['add']=true;
        $this->layout->view('news-category',$this->data);
	}

	public function news_category_add()
	{
		checkPermission("news_category",ADD);
        if($_POST)
        {
        	$this->form_validation->set_rules('name', 'Name Required', 'trim|required');
           if ($this->form_validation->run() ==TRUE) {
                 $data['name']=$this->input->post("name");
                 $data['position']=$this->input->post("position");
                 if(!$this->news->duplicate_check("news_category","name",$data['name']))
				 {
					 $insert=$this->news->insert('news_category', $data);
					 $send_data['msg']="success";
					 $send_data['success']="Add Successfully";

				 }
                 else{
					 $send_data['msg']="News category already exits!";
				 }
                echo json_encode($send_data);
                exit;
            } else {
                $send_data['msg']=validation_errors();
                echo json_encode($send_data);
                exit;
            }
            redirect('news/news_category');
        }
	}

    //category ajax view
    public function news_category_view()
    {
        if($_GET)
        {
            $this->data['all_category']=$this->news->get("news_category",'','position','asc');
            $result=$this->load->view("category-view",$this->data,true);
            echo json_encode($result);
            exit;
        }
    }
    public function news_category_edit($id=null)
    {
    	checkPermission("news_category",EDIT);

        $single=$this->news->get_single("news_category",array("id"=>$id));
        if($single){
        	if($_POST)
        	{
        		$this->form_validation->set_rules('name', 'Name Required', 'trim|required');
				if ($this->form_validation->run() ==TRUE) {
					 $data['name']=$this->input->post("name");
					 $data['position']=$this->input->post("position");
					 if(!$this->news->duplicate_check("news_category","name",$data['name'],$id))
					 {
						$this->news->update('news_category', $data,array("id"=>$id));
						setMessage("msg","success","Update Sucessfully.");

					 }
					 else{
						setMessage("msg","warning","News category already exits!");
					 }
					} else {
						setMessage("msg","warning",validation_errors());
					}
					redirect('news/news_category');
        	}

            $this->layout->title("Manage Category");
            $this->data['edit']=true;
            $this->data['single']=$single;
            $this->layout->view('news-category',$this->data);

        }else{
            show_404();
        }

    }
    public function news_category_delete($id = null)
    {
        $result = $this->news->get_single("news_category", array("id" => $id));
        if (isset($result)) {
            setMessage("msg", "success", "Deleted Successfuly");
            $this->news->delete("news_category",array("id" => $id));
        }
        redirect('news/news_category');
    }
    public function news_category_control($id = null)
    {
        $result = $this->news->get_single("news_category", array("id" => $id));
        $status = 0;
        if (isset($result)) {
        	setMessage("msg", "success", "Disable Successfuly");
        	if($result->status==0)
			{
				$status=1;
            	setMessage("msg", "success", "Enable Successfuly");
			}
            $this->news->update("news_category",array("status"=>$status),array("id" => $id));
        }
        redirect('news/news_category');
    }

}

/* End of file Info.php */
