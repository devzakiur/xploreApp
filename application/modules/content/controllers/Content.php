<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Content
 * @property MY_Model $content
 */

class Content extends MY_Controller
{
	public $data=array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MY_Model','content',true);
        $this->session->set_userdata('top_menu', 'content');
        $this->session->set_userdata('sub_menu', 'content');
    }

	public function index()
	{
		checkPermission("content",VIEW);

        $this->layout->title("Manage Content");
        $this->data['add']=true;
        $this->layout->view('index',$this->data);
    }

	public function add()
	{
		checkPermission("content",ADD);
		$slug=$this->input->post("slug");
		$description=htmlentities($this->input->post("description"));
		$check=$this->content->get_single("content",array("slug"=>$slug));
		if($check){
			$check->description=$description;
			$this->content->update("content",$check,array("slug"=>$slug));
		}else{
			$this->content->insert("content",array("slug"=>$slug,"description"=>$description));
		}
		setMessage("msg","success","Successfully");
		redirect("content");
    }

	public function single_view()
	{
		$slug=$this->input->get("slug");
		$result=$this->content->get_single("content",array("slug"=>$slug));
		if(!empty($result))
		{
			$data=html_entity_decode($result->description);
		}else{
			$data="";
		}
		echo json_encode($data);
		exit;
    }
}
