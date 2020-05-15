<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;

/**
 * Class NewsController
 * @property MY_Model $contact;
 */
class ContactController extends MY_ApiController
{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->model("MY_Model","contact",true);
	}

	public function find_us_get()
	{
		$result=$this->contact->get_last_row("social");
		$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Social List "],
				"data"=>$result
			], RestController::HTTP_OK );
	}

	public function contact_us_post()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean');
		$this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');
		if($this->form_validation->run() === TRUE) {
			$email=$this->input->post("email");
			$message=strip_tags($this->input->post("message"));
			$this->_send_email($email,$message);
			$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Message Sent Successfully"],
			], RestController::HTTP_OK );

		}else{
			custom_validation_error();
		}
	}

	public function invite_friends_post()
	{
			$email=$this->input->post("email");
			$emails=$this->input->post("emails");
			$this->_send_invitation_email($email,$emails);
			$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Invitation Sent Successfully"],
			], RestController::HTTP_OK );
	}

	private function _send_email($email,$message) {

		$this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);

        $this->email->from($email);
        $this->email->to($this->config->item("webmail"));
        $this->email->subject("Message From User");

        $this->email->message($message);

        $this->email->send();
    }
	private function _send_invitation_email($email,$emails) {

		$this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);

        $this->email->from($email);
        $this->email->to($emails);
        $this->email->subject("Invitation to join Xplore");
		$message="App Link";
        $message .= '<br/><br/>';
		$message.=$this->config->item("app_link");
        $this->email->message($message);

        $this->email->send();
    }

}
