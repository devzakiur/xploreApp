<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Sms extends MY_Controller
{
    public $data = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Setting_model', "sms", true);
        $this->session->set_userdata('top_menu', 'setting');
    }
    public function index()
    {
        if (!hasPermission("sms", VIEW)) {
            setMessage("msg", "warning", "Permission Denied!");
            redirect('dashboard');
        }
        $this->session->set_userdata('sub_menu', 'setting/sms');
        $this->layout->title("Sms Setting");
        $this->data['single'] = $this->sms->get_single("sms_settings",array("id"=>1));
        // debug_r($this->data['single']);
        $this->layout->view('setting/smssetting', $this->data);
    }
    public function edit()
    {
        if (!hasPermission("sms", EDIT)) {
            setMessage("msg", "warning", "Permission Denied!");
            redirect('dashboard');
        }
        if($_POST)
        {
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_rules('api_key', 'Api Key', 'required');
            $this->form_validation->set_rules('sender_id', 'Sender Id', 'required');
            $this->form_validation->set_rules('type', 'Type', 'required');
            $this->form_validation->set_rules('url', 'Api URL', 'required');
            if ($this->form_validation->run()) {

                $data = array(
                    'type' => $this->input->post('type'),
                    'api_key' => $this->input->post('api_key'),
                    'sender_id' => $this->input->post('sender_id'),
                    'url' => $this->input->post('url'),
                    'status' => $this->input->post('status'),
                );
                $this->sms->update("sms_settings", $data,array("id"=>1));
                $this->session->set_flashdata('msg', "<div class='alert alert-success'>Record updated successfully </div>");
                setMessage("msg", "success", "Sms Setting Updated Successfully!");
                redirect("setting/sms");
            } else {
                setMessage("msg", "danger", validation_errors());
                redirect("setting/sms");
            }
        }
    }
}
