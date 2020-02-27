<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Ajax
 * @property Ajax_model $ajax;
 */
class Ajax extends MY_Controller {
    public $data=array();
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model("Ajax_model",'ajax',true);
    }
    
    public function index()
    {
        
    }
   
    public function add_parent()
    {
        if($_POST){
            $data=array();
            $this->data['name']=$this->input->post("name");
            if(strtolower($this->data['name'])!="module")
            {
                $this->data['position']=$this->input->post("position");
                $this->data['link']=strtolower(str_replace(" ","-",$this->data['name']));
                $this->data['short_code']=strtolower(str_replace(" ","_",$this->data['name']));
                $check=$this->ajax->get_single("permission_group",array("short_code"=>$this->data['short_code']));
                if(empty($check))
                {
                    $insert_id=$this->ajax->insert("permission_group",$this->data);
                    $this->data['perm_group_id']=$insert_id;
                    $this->ajax->insert("permission_category",$this->data);
                }
                $result=$this->ajax->get("permission_group","id,name","name","ASC");
                echo json_encode($result);
            }else{
                echo json_encode(array("failed"));
            }
        }
    }
    public function get_user_by_role_id()
    {
        if($_GET){
            $role_id=$this->input->get("role_id");
            $check=$this->ajax->get_list("admin",array("role_id"=>$role_id),"","","username","ASC");
            echo json_encode($check);
        }
    }
    public function get_subject_by_category()
    {
        if($_GET){
            $category_id=$this->input->get("category_id");
            $result=$this->ajax->get_subject_by_category($category_id);
            echo json_encode($result);
        }
    }
    public function get_section_by_subject()
    {
        if($_GET){
            $subject_id=$this->input->get("subject_id");
            $result=$this->ajax->get_section_by_subject($subject_id);
            echo json_encode($result);
        }
    }
    public function get_topic_by_section()
    {
        if($_GET){
            $section_id=$this->input->get("section_id");
            $result=$this->ajax->get_topic_by_section($section_id);
            echo json_encode($result);
        }
    }
    public function get_all_batch()
    {
        if($_GET){
            $result=$this->ajax->get("batch",'','id','desc');
            echo json_encode($result);
        }
    }
    public function get_subparent()
    {
        if($_POST){
            $parent_id=$this->input->post("parent_id");
            $result=$this->ajax->get_list("permission_category",array("perm_group_id"=>$parent_id,"submenu"=>1,"subparent"=>0),"","","name","ASC");
            echo json_encode($result);
        }
    }

	public function get_last_order_position()
	{
		$table_name=$this->input->get("table_name");
		$position=$this->ajax->count_all($table_name)+1;
		echo json_encode($position);
		exit;
	}
}

/* End of file Ajax.php */
