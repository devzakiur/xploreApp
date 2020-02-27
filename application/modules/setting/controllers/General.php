<?php

defined('BASEPATH') or exit('No direct script access allowed');

class General extends MY_Controller
{
    public $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Setting_model', "general", true);
        $this->session->set_userdata('top_menu', 'setting');
    }
    public function index()
    {
        if (!hasPermission("general", VIEW)) {
            setMessage("msg", "warning", "Permission Denied!");
            redirect('dashboard');
        }
        $this->session->set_userdata('sub_menu', 'general-setting');
        $this->layout->title("General Setting");
        $this->config->load('timezone');
        $this->data['timezone'] = $this->config->item('timezone');
        $this->data["session"]=$this->general->get("session","","name","asc");
        $this->data["session_name"]=$this->general->get_single("session",array("id"=>$this->running_year));
        $this->data['single']=$this->general->get_single_setting();
        $this->layout->view('setting/general', $this->data);
    }
    /** ***************Function edit**********************************
     * @type            : Function
     * @function name   : edit
     * @description     : edit batch                  
     *                       
     * @param           : null
     * @return          : null
     * ********************************************************** */
    public function edit($id = null)
    {
        if (!hasPermission("general", EDIT)) {
            setMessage("msg", "warning", "Permission Denied!");
            redirect('dashboard');
        }
        if ($_POST) {
            $this->_prepare_validation();
            if ($this->form_validation->run() == true) {
                $data = $this->_get_posted_data();
                $this->general->update("setting", $data, array("id" => $id));
                setMessage("msg", "success", "Setting Updated Successfully!");
                redirect("setting/general");
            } else {
                setMessage("msg", "danger", validation_errors());
                redirect("setting/general");
            }
        }
    }
    public function reset()
    {
        if (!hasPermission("reset_profile", EDIT)) {
            setMessage("msg", "warning", "Permission Denied!");
            redirect('dashboard');
        }
        if ($_POST) {
            $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
            $this->form_validation->set_rules('username', "User Name", 'trim|required|callback_username');
            $this->form_validation->set_rules('password', "Password", 'trim');
            if ($this->form_validation->run() == true) {
                // $id=$this->input->post("id");
                $data['username']=$this->input->post("username");
                if($this->input->post("password"))
                {
                    $this->load->library('Enc_lib');
                    $data['password'] = $this->enc_lib->passHashEnc($this->input->post('password'));
                }
                $this->general->update("admin", $data, array("id" =>logged_in_user_id()));
                setMessage("msg", "success", "Reset Successfully!");
                redirect("setting/general/reset");
            } else {
                setMessage("msg", "danger", validation_errors());
                redirect("setting/general/reset");
            }
        }
        $this->data['single']=$this->general->get_single("admin",array("id"=>logged_in_user_id()));
        $this->session->set_userdata('sub_menu', 'general-setting');
        $this->layout->title("Reset Password");
        $this->layout->view('setting/reset-profile', $this->data);

    }
    /** ***************Function name**********************************
     * @type            : Function
     * @function name   : name
     * @description     : Unique check for role role" data/value                  
     *                       
     * @param           : null
     * @return          : boolean true/false 
     * ********************************************************** */
    public function username()
    {
        if ($this->input->post('id') == '') {
            $username = $this->general->duplicate_check("admin", "username", $this->input->post('username'));
            if ($username) {
                $this->form_validation->set_message('username', "Username Aready Exits");
                return FALSE;
            } else {
                return TRUE;
            }
        } else if ($this->input->post('id') != '') {
            $username = $this->general->duplicate_check("admin", "username", $this->input->post('username'), $this->input->post('id'));
            if ($username) {
                $this->form_validation->set_message('username', "Username Aready Exits");
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
     * @description     : Process "sesstin" user input data validation                 
     *                       
     * @param           : null
     * @return          : null 
     * ********************************************************** */
    private function _prepare_validation()
    {
        $this->form_validation->set_error_delimiters('<div class="error-message" style="color: red;">', '</div>');
        $this->form_validation->set_rules('company_name', "Company Name", 'trim|required');
        $this->form_validation->set_rules('logo', "Logo", 'trim');
        $this->form_validation->set_rules('time_zone', "Timezone", 'trim');
        $this->form_validation->set_rules('running_session', "Running Session", 'trim|required');
        $this->form_validation->set_rules('signature', "Authorize Signature", 'trim');
        $this->form_validation->set_rules('receiver_signature', "Recevier Signature", 'trim');
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

        $items = array();
        $items[] = 'company_name';
        $items[] = 'time_zone';
        $items[] = 'running_session';
        $items[] = 'address';

        $data = elements($items, $_POST);
        if ($_FILES['logo']['name']) {
            $data['logo'] ="uploads/logo/" . $this->_upload_logo();
        }
        return $data;
    }
    public function _upload_logo()
    {
        $name = $_FILES['logo']['name'];
        $arr = explode('.', $name);
        $ext = end($arr);
        $imageName = "DC" . time() . "L.$ext";
        $config['upload_path']          = './uploads/logo';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        $config['file_name']            = $imageName;
        $config['max_size']             = 500;
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('logo')) {
            setMessage("msg", "danger", "Logo" . $this->upload->display_errors());
            redirect("setting/general");
        } else {
            $this->load->library('image_lib');
            $config['image_library']  = 'gd2';
            $config['source_image'] = './uploads/logo/' . $imageName;
            $config['create_thumb']   = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width']          = 150;
            $config['height']         = 80;
            $config['new_image']      = './uploads/logo/' . $imageName;
            $this->image_lib->initialize($config);
            if ($this->image_lib->resize()) {
                $this->image_lib->clear();
            }
                $prev_photo = $this->general->get_single("setting", array("id" => $this->input->post('id')))->logo;
                @unlink($prev_photo);
            return $imageName;
        }
    }
    public function _upload_signature()
    {
        $name = $_FILES['signature']['name'];
        $arr = explode('.', $name);
        $ext = end($arr);
        $imageName = "DC" . time() . "A.$ext";
        $config['upload_path']          = './uploads/signature';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        $config['file_name']            = $imageName;
        $config['max_size']             = 500;
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('signature')) {
            setMessage("msg", "danger", "Authorize Signature" . $this->upload->display_errors());
            redirect("setting/general");
        } else {
            $this->load->library('image_lib');
            $config['image_library']  = 'gd2';
            $config['source_image'] = './uploads/signature/' . $imageName;
            $config['create_thumb']   = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width']          = 120;
            $config['height']         = 40;
            $config['new_image']      = './uploads/signature/' . $imageName;
            $this->image_lib->initialize($config);
            if ($this->image_lib->resize()) {
                $this->image_lib->clear();
            }
                $prev_photo = $this->general->get_single("setting", array("id" => $this->input->post('id')))->signature;
                @unlink(str_replace(base_url(), '', $prev_photo));
            return $imageName;
        }
    }
    public function _upload_receiver_signature()
    {
        $name = $_FILES['receiver_signature']['name'];
        $arr = explode('.', $name);
        $ext = end($arr);
        $imageName = "DC" . time() . "R.$ext";
        $config['upload_path']          = './uploads/signature';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        $config['file_name']            = $imageName;
        $config['max_size']             = 500;
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('receiver_signature')) {
            setMessage("msg", "danger", "Receiver Signaure" . $this->upload->display_errors());
            redirect("setting/general");
        } else {
            $this->load->library('image_lib');
            $config['image_library']  = 'gd2';
            $config['source_image'] = './uploads/signature/' . $imageName;
            $config['create_thumb']   = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width']          = 120;
            $config['height']         = 40;
            $config['new_image']      = './uploads/signature/' . $imageName;
            $this->image_lib->initialize($config);
            if ($this->image_lib->resize()) {
                $this->image_lib->clear();
            }
                $prev_photo = $this->general->get_single("setting", array("id" => $this->input->post('id')))->receiver_signature;
                @unlink(str_replace(base_url(), '', $prev_photo));
            return $imageName;
        }
    }
}
