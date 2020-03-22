<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 * @property Users_Model $users
 */
class Users extends MY_Controller {
    public $data=array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_Model','users',true);
        $this->session->set_userdata('top_menu', 'users');
        $this->session->set_userdata('sub_menu', 'users');
    }

	public function index()
    {
        checkPermission("users",VIEW);

        $this->layout->title("Users");
        $this->layout->view('index',$this->data);
    }
    //library ajax view
    public function view()
    {
        if($_GET)
        {
        	$search_key=trim($this->input->get("search_key"));
        	$filter_by=trim($this->input->get("filter_by"));
        	$offset=($this->uri->segment(3))? $this->uri->segment(3):0;
        	$this->load->library('pagination');
			$config['base_url']    = base_url('users/view');
			$config['total_rows']  = $this->users->get_all_users("","",$search_key,$filter_by,true);
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
			$this->data['all_users']=$this->users->get_all_users(QUESTION_PER_PAGE,$offset,$search_key,$filter_by);
			$this->data['serial']=$offset;
			$this->data['total_rows']=$config['total_rows'];
			$result=$this->load->view("users-view",$this->data,true);
			echo json_encode($result);
			exit;
        }else
		{
			show_404();
		}
    }


	/**
	 * @param null $id
	 */
	public function delete($id = null)
    {
        $result = $this->users->get_single("library", array("id" => $id));
        if (isset($result)) {
            $this->users->trans_start();
            $slide_result=$this->users->get_list("library_image",array("library_id"=>$id));
			@unlink($result->cover_image);
            $this->users->delete("library",array("id" => $id));
            $this->users->delete("library_video",array("library_id" => $id));
            $this->users->delete("library_image",array("library_id" => $id));
            $this->users->delete("topic_library",array("library_id" => $id));
				if($slide_result)
				{
					foreach ($slide_result as $value)
					{
						@unlink($value['picture']);

					}
				}
            $this->users->trans_complete();
            if($this->users->trans_status()){
            	setMessage("msg", "success", " Deleted Successfuly");
			}else
			{
            	setMessage("msg", "danger", " Not Deleted");

			}
        }
        redirect('users');
    }
    public function control($id = null)
    {
        $result = $this->users->get_single("users", array("id" => $id));
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
            $this->users->update("users",array("status"=>$status),array("id" => $id));
        }
        redirect('users');
    }
}

/* End of file Users.php */
