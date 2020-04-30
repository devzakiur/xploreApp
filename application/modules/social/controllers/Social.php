<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Social
 * @property MY_Model $social;
 */
class Social extends MY_Controller
{
    public $data = array();

   public function __construct()
    {
        parent::__construct();
        $this->load->model('MY_Model','social',true);
        $this->session->set_userdata('top_menu', 'social');
        $this->session->set_userdata('sub_menu', 'social');
    }
    public function index()
    {
        checkPermission("social",VIEW);
        $this->layout->title("Social Setting");
        $this->data['single']=$this->social->get_last_row("social");
        $this->layout->view('social', $this->data);
    }
    /** ***************Function edit**********************************
     * @type            : Function
     * @function name   : edit
     * @description     : edit batch                  
     *                       
     * @param           : null
     * @return          : null
     * ********************************************************** */
    public function add($id = null)
    {
      checkPermission("social",EDIT);
        if ($_POST) {
            $this->_prepare_validation();
            if ($this->form_validation->run() == true) {
                $data = $this->_get_posted_data();
                if($this->input->post("id")!='')
				{
					$this->social->update("social",$data,array("id"=>$this->input->post("id")));
				}else{
					$this->social->insert("social",$data);
				}
                setMessage("msg", "success", "Updated Successfully!");
            } else {
                setMessage("msg", "danger", validation_errors());
            }
            redirect("social");
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
        $this->form_validation->set_rules('facebook', "Facebook", 'trim');
        $this->form_validation->set_rules('twitter', "Twitter", 'trim');
        $this->form_validation->set_rules('linked_in', "Linked In", 'trim');
        $this->form_validation->set_rules('youtube', "Youtube", 'trim');
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
        $items[] = 'facebook';
        $items[] = 'twitter';
        $items[] = 'linked_in';
        $items[] = 'youtube';

        $data = elements($items, $_POST);
        return $data;
    }

}
