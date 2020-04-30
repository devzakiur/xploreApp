<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 * @property Notification_Model $notification
 */
class Notification extends MY_Controller {
    public $data=array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Notification_Model','notification',true);
        $this->session->set_userdata('top_menu', 'notification');
        $this->session->set_userdata('sub_menu', 'notification');
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
    	checkPermission("notification",VIEW);
        $this->layout->title("Manage Notification");
        $this->data['add']=true;
        $this->data['category']=$this->notification->get_list("category",array("status"=>1),"","","","position","asc");
        $this->layout->view('index',$this->data);
    }
    public function add()
    {
    	checkPermission("notification",ADD);
        if($_POST)
        {
           $this->_prepare_validation();
           if ($this->form_validation->run() ==TRUE) {
                $data=$this->_get_posted_data();
                $insert_id=$this->notification->insert('notification', $data);
                $noti=$this->send_notification($insert_id,$data['category_id']);
                $send_data['msg']="success";
                $send_data['notification']=$noti;
                $send_data['success']="Sent Successfully";
                echo json_encode($send_data);
                exit;
            } else {
                $send_data['msg']=validation_errors();
                echo json_encode($send_data);
                exit;
            }
            redirect('notification');
        }
    }

    //notification ajax view

    public function view()
    {
        if(isset($_POST))
        {
        	$category_id=trim($this->input->post("category_id"));
        	$offset=($this->uri->segment(3))? $this->uri->segment(3):0;
        	$this->load->library('pagination');
			$config['base_url']    = base_url('notification/view');
			$config['total_rows']  = $this->notification->get_all_notification("","",$category_id,true);
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
			$this->data['all_notification']=$this->notification->get_all_notification(QUESTION_PER_PAGE,$offset,$category_id);
			$this->data['serial']=$offset;
			$this->data['total_rows']=$config['total_rows'];
			$result=$this->load->view("notification-view",$this->data,true);
			echo json_encode($result);
			exit;
        }else
		{
			show_404();
		}
    }
    public function edit($id=null)
    {
    	checkPermission("notification",EDIT);
        $single=$this->notification->get_single("notification",array("id"=>$id));
        if($single){
        	if($_POST)
        	{
				$this->_prepare_validation();
				if ($this->form_validation->run() ==TRUE) {
						$data=$this->_get_posted_data();
						$this->notification->update('notification', $data,array("id"=>$id));
						setMessage("msg","success","Update Sucessfully.");
					} else {
						setMessage("msg","warning",validation_errors());
					}
					redirect('notification');
        	}

            $this->layout->title("Manage Notification");
            $this->data['edit']=true;


            $this->data['single']=$single;
            $this->data['category']=$this->notification->get_list("category",array("status"=>1),"","","","position","asc");
            $this->layout->view('index',$this->data);

        }else{
            show_404();
        }

    }
    public function delete($id = null)
    {
        $result = $this->notification->get_single("notification", array("id" => $id));
        if (isset($result)) {
            setMessage("msg", "success", "Deleted Successfuly");
            $this->notification->delete("notification",array("id" => $id));
            @unlink($result->picture);
        }
        redirect('notification');
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
        $this->form_validation->set_rules('category_id', 'Category Required', 'trim|required');
        $this->form_validation->set_rules('details', 'Details Required', 'trim|required');
        $this->form_validation->set_rules('action', 'Action Required', 'trim|required');
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
        $data['details']=htmlentities($this->input->post("details"));
        $data['action']=$this->input->post("action");
          if ($_FILES['picture']['name']) {
          	if (!is_dir('uploads/notification')) {
				mkdir('./uploads/notification', 0777, TRUE);
			}
			$image_name=$this->_upload_picture();
			$data['picture'] ="uploads/notification/".$image_name;
		}
        return $data;
    }
    public function _upload_picture()
    {
        $name = $_FILES['picture']['name'];
        $arr = explode('.', $name);
        $ext = end($arr);
        $imageName=APP_NAME.'_'.time()."C.$ext";
        $config['upload_path']          = './uploads/notification';
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
				redirect("notification");
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
            $config['source_image'] = './uploads/notification/'.$imageName;
            $config['create_thumb']   = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width']          = 300;
            $config['height']         = 300;
            $config['new_image']      = './uploads/notification/'.$imageName;
            $this->image_lib->initialize($config);
            if ($this->image_lib->resize()) {
                $this->image_lib->clear();
            }
            if($this->input->post('id'))
            {
                $prev_photo=$this->news->get_single("notification",array("id"=>$this->input->post('id')))->picture;
                @unlink($prev_photo);
            }
            return $imageName;
        }

    }

	private function send_notification($id,$category_id)
	{
		 $user_reg_ids=$this->notification->get_user_ids($category_id);
		 $url = 'https://fcm.googleapis.com/fcm/send';
		 $data=$this->notification->get_single_notification($id);
		 $data['details']=strip_tags(html_entity_decode($data['details']));
		$fields = array (
				'registration_ids' => $user_reg_ids,
				'data' =>$data
		);
		$fields = json_encode ($fields);

		$headers = array (
				'Authorization:'.$this->config->item("server_key"),
				'Content-Type: application/json'
		);

		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_POST, true );
		curl_setopt ( $ch, CURLOPT_HTTPHEADER, $headers );
		curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		curl_setopt ( $ch, CURLOPT_POSTFIELDS, $fields );

		$result = curl_exec ($ch);
		curl_close ( $ch );
		return $result;
	}

}

/* End of file Users.php */
