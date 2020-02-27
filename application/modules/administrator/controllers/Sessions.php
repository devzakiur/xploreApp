<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Sessions extends MY_Controller {
    public $data=array();
    public $table="session";

    public function __construct()
    {
        parent::__construct();
        $this->session->set_userdata('top_menu', 'administrator');
        $this->load->model('MY_Model',"session_model",true);
    }

    public function index()
    {
        if(!hasPermission("manage_session",VIEW)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
       $this->session->set_userdata('sub_menu',"manage-session");
       $this->data['add']=true;
       $this->layout->title("Session"); 
       $this->data['session']=$this->session_model->get($this->table,"","name","ASC");
       $this->layout->view('sessions',$this->data);
    }
    public function add()
    {
        if(!hasPermission("manage_session",ADD)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
       if($_POST){
           $this->form_validation->set_rules('name', 'Session Name Required', 'trim|required|callback_name');
           $this->form_validation->set_rules('note', 'Note', 'trim');
           if ($this->form_validation->run() ==TRUE) {
                $data['name']=$this->input->post("name");
                $data['note']=$this->input->post("note");
                $insert=$this->session_model->insert($this->table,$data);
                if($insert)
                {
                    setMessage("msg","success","Session Add Sucessfully.");
                }
            } else {
                setMessage("msg","warning",validation_errors());
            }
            redirect('administrator/sessions');
        }else{
            redirect('administrator/sessions');
       }
    }
    public function edit($id=null)
    {
        if(!hasPermission("manage_session",EDIT)){
            setMessage("msg","warning","Permission Denied!");
            redirect('dashboard');
        }
        $this->data['single']=$this->session_model->get_single($this->table,array('id'=>$id));
       if($_POST){
           $this->form_validation->set_rules('name', 'Session Name Required', 'trim|required');
           $this->form_validation->set_rules('note', 'Note', 'trim');
           if ($this->form_validation->run() ==TRUE) {
                $data['name']=$this->input->post("name");
                $data['note']=$this->input->post("note");
                $this->session_model->update($this->table,$data,array("id"=>$id));
                setMessage("msg","success","Session Update Sucessfully.");
            } else {
                setMessage("msg","warning",validation_errors());
            }
            redirect('administrator/sessions');
       }
       $this->data['edit']=true;
       $this->layout->title("Session"); 
       $this->data['session']=$this->session_model->get($this->table,"","name","ASC");
       $this->layout->view('sessions',$this->data);
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
            $name = $this->session_model->duplicate_check($this->table,"name",$this->input->post('name'));
            if ($name) {
                $this->form_validation->set_message('name', "Session  Name Aready Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $name = $this->session_model->duplicate_check($this->table,"name",$this->input->post('name'), $this->input->post('id'));
            if ($name) {
                $this->form_validation->set_message('name', "Session Name Aready Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else {
            return TRUE;
        }
    }
}

/* End of file Session.php */
