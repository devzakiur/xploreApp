<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Users
 * @property MY_Model $category
 */
class Category extends MY_Controller {
    public $data=array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MY_Model','category',true);
        $this->session->set_userdata('top_menu', 'general_setup');
        $this->session->set_userdata('sub_menu', 'category');
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
        if(!hasPermission("category",VIEW)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        $this->layout->title("Manage Category");
        $this->data['add']=true;
        $this->layout->view('index',$this->data);
    }
    public function add()
    {
        if(!hasPermission("category",ADD)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        if($_POST)
        {
           $this->_prepare_validation();
           if ($this->form_validation->run() ==TRUE) {
                $data=$this->_get_posted_data();
                $insert=$this->category->insert('category', $data);
                $send_data['msg']="success";
                $send_data['success']="Add Successfully";
                echo json_encode($send_data);
                exit;
            } else {
                $send_data['msg']=validation_errors();
                echo json_encode($send_data);
                exit;
            }
            redirect('category');
        }
    }
    //category ajax view
    public function view()
    {
        if($_GET)
        {
            $this->data['all_category']=$this->category->get("category",'','position','asc');
            $result=$this->load->view("category-view",$this->data,true);
            echo json_encode($result);
            exit;
        }
    }
    public function edit($id=null)
    {
        if(!hasPermission("category",EDIT)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }

        $single=$this->category->get_single("category",array("id"=>$id));
        if($single){
        	if($_POST)
        	{
				$this->_prepare_validation();
				if ($this->form_validation->run() ==TRUE) {
						$data=$this->_get_posted_data();
						$this->category->update('category', $data,array("id"=>$id));
						setMessage("msg","success","Update Sucessfully.");
					} else {
						setMessage("msg","warning",validation_errors());
					}
					redirect('category');
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
        $result = $this->category->get_single("category", array("id" => $id));
        $status = 0;
        if (isset($result)) {
            setMessage("msg", "success", "Deleted Successfuly");
            $this->category->delete("category",array("id" => $id));
        }
        redirect('category');
    }
    public function control($id = null)
    {
        $result = $this->category->get_single("category", array("id" => $id));
        $status = 0;
        if (isset($result)) {
        	setMessage("msg", "success", "Disable Successfuly");
        	if($result->status==0)
			{
				$status=1;
            	setMessage("msg", "success", "Enable Successfuly");
			}
            $this->category->update("category",array("status"=>$status),array("id" => $id));
        }
        redirect('category');
    }
    public function subject_show($id = null)
    {
    	$category_id=$this->input->post("category_id");
        $value=$this->input->post("value");
        $this->category->update("category",array("subject_show"=>$value),array("id"=>$category_id));
        echo json_encode($value);
        exit;
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
            $name = $this->category->duplicate_check("category","name",$this->input->post('name'));
            if ($name) {
                $this->form_validation->set_message('name', "Category Name Already Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $name = $this->category->duplicate_check("category","name",$this->input->post('name'), $this->input->post('id'));
            if ($name) {
                $this->form_validation->set_message('name', "Category name Already Exits");
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

}

/* End of file Users.php */
