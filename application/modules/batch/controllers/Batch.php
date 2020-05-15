<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Users
 * @property Batch_Model $batch
 */
class Batch extends MY_Controller
{
	public $data = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Batch_Model', 'batch', true);
		$this->session->set_userdata('top_menu', 'general_setup');
		$this->session->set_userdata('sub_menu', 'batch');
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
		checkPermission("batch", VIEW);
		$this->layout->title("Manage Batch");
		$this->data['add'] = true;
		$this->data['category'] = $this->batch->get("category");
		$this->layout->view('index', $this->data);
	}
	public function add()
	{
		checkPermission("batch", ADD);
		if ($_POST) {
			$this->_prepare_validation();
			if ($this->form_validation->run() == TRUE) {
				$data = $this->_get_posted_data();
				$insert = $this->batch->insert('batch', $data);
				$send_data['msg'] = "success";
				$send_data['success'] = "Add Successfully";
				echo json_encode($send_data);
				exit;
			} else {
				$send_data['msg'] = validation_errors();
				echo json_encode($send_data);
				exit;
			}
			redirect('batch');
		}
	}
	//category ajax view
	public function view()
	{
		if ($_GET) {
			$this->data['all_batch'] = $this->batch->get_all_batch();
			$result = $this->load->view("batch-view", $this->data, true);
			echo json_encode($result);
			exit;
		}
	}
	public function edit($id = null)
	{
		checkPermission("batch", EDIT);

		$single = $this->batch->get_single("batch", array("id" => $id));
		//        debug_r($single);
		if ($single) {
			if ($_POST) {
				$this->_prepare_validation();
				if ($this->form_validation->run() == TRUE) {
					$data = $this->_get_posted_data();
					$this->batch->update('batch', $data, array("id" => $id));
					setMessage("msg", "success", "Update Sucessfully.");
				} else {
					setMessage("msg", "warning", validation_errors());
				}
				redirect('batch');
			}

			$this->layout->title("Manage Batch");
			$this->data['edit'] = true;
			$this->data['category'] = $this->batch->get("category");
			$this->data['single'] = $single;
			$this->layout->view('index', $this->data);
		} else {
			show_404();
		}
	}
	public function delete($id = null)
	{
		$result = $this->batch->get_single("batch", array("id" => $id));
		$status = 0;
		if (isset($result)) {
			setMessage("msg", "success", "Deleted Successfuly");
			$this->batch->delete("batch", array("id" => $id));
		}
		redirect('batch');
	}
	public function control($id = null)
	{
		$result = $this->batch->get_single("batch", array("id" => $id));
		$status = 0;
		if (isset($result)) {
			setMessage("msg", "success", "Disable Successfuly");
			if ($result->status == 0) {
				$status = 1;
				setMessage("msg", "success", "Enable Successfuly");
			}
			$this->batch->update("batch", array("status" => $status), array("id" => $id));
		}
		redirect('batch');
	}
	/** ***************Function name**********************************
	 * @type            : Function
	 * @function name   : name
	 * @description     : Unique check for module name" data/value
	 *
	 * @param           : null
	 * @return          : boolean true/false
	 * ********************************************************** */
	public function name()
	{
		if ($this->input->post('id') == '') {
			$name = $this->batch->duplicate_check("batch", "name", $this->input->post('name'));
			if ($name) {
				$this->form_validation->set_message('name', "Batch Name Already Exits");
				return FALSE;
			} else {
				return TRUE;
			}
		} else if ($this->input->post('id') != '') {
			$name = $this->batch->duplicate_check("batch", "name", $this->input->post('name'), $this->input->post('id'));
			if ($name) {
				$this->form_validation->set_message('name', "Batch name Already Exits");
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
		$this->form_validation->set_rules('category_id', 'Category Required', 'trim|required');
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
		$data = array();
		$data['name'] = $this->input->post("name");
		$data['position'] = $this->input->post("position");
		$data['category_id'] = $this->input->post("category_id");
		if ($this->input->post("id")) {
			$data['updateby'] = logged_in_user_id();
		}
		return $data;
	}
}

/* End of file Users.php */
