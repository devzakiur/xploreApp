<?php

defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;

/**
 * Class PasswordController
 * @property MY_Model $password
 */
class PasswordController extends RestController
{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->model("MY_Model","password",true);
	}

	public function forgot_password_post()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
			if($this->form_validation->run() === TRUE) {
			$user=$this->password->get_single("users",array("email"=>$this->input->post("email")));
			if(!empty($user))
			{
				$code=generateNumericOTP();
				$send=$this->_send_email($code,$this->input->post("email"));
				$data['reset_key']=$code;
				$data['reset_time']=date("Y-m-d H:i:s");
				$this->password->update("users",$data,array("id"=>$user->id));
				$this->response( [
					'status' => true,
					'status_code' =>HTTP_OK,
					'code' =>$code,
					'message' => ["Message Sent Successfully"]
				], RestController::HTTP_OK );
			}
			else
			{
				$this->response( [
					'status' => false,
					'status_code' =>HTTP_NOT_FOUND,
					'message' => ["Email Not Found"]
				], RestController::HTTP_OK );
			}
		}else
		{
			custom_validation_error();
		}
	}

    public function reset_code_verification_post()
	{
		$this->form_validation->set_rules('code', 'Code', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
		if($this->form_validation->run() === TRUE) {
			$email=$this->input->post("email");
			$user_data=get_users(array("email"=>$email,"reset_key"=>$this->input->post("code")),"reset_time");
			if(!empty($user_data)){
				$reset_time=new DateTime($user_data->reset_time);
				$now_date_diff=$reset_time->diff(new DateTime("now"));
				$minutes = $now_date_diff->days * 24 * 60;
				$minutes += $now_date_diff->h * 60;
				$minutes += $now_date_diff->i;
				if($minutes<=5)
				{
					$data['reset_time']=null;
					$data['reset_key']=null;
					$this->password->update("users",$data,array("email"=>$email));
					$user_data->reset_time="";
					$this->response( [
						'status' => true,
						'status_code' =>200,
						'message' =>["Verification Successfully"],
						"data"=>$user_data
					], RestController::HTTP_OK );
				}
				else{
					$this->response( [
						'status' => false,
						'status_code' =>Expired,
						'message' =>["Code Time Expired"]
					], RestController::HTTP_OK );
				}
			}else{
				$this->response( [
					'status' => false,
					'status_code' =>NOT_MATCHED,
					'message' =>["Code Not Matched"]
				], RestController::HTTP_OK );
			}
		}
		else
		{
			custom_validation_error();
		}
    }

    public function change_password_post()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean');
		if($this->form_validation->run() === TRUE) {
        	$this->load->library('Enc_lib');
			$email=$this->input->post("email");
			$user_data=get_users(array("email"=>$email));
			if(!empty($user_data)){
				$data['password']=$this->enc_lib->passHashEnc($this->input->post('password'));
				$this->password->update("users",$data,array("email"=>$email));
				$this->response( [
						'status' => true,
						'status_code' =>200,
						'message' =>["Password Update Successfully"],
						"data"=>$user_data
					], RestController::HTTP_OK );
			}else{
				$this->response( [
					'status' => false,
					'status_code' =>NOT_MATCHED,
					'message' =>["Email Not Found"]
				], RestController::HTTP_OK );
			}
		}
		else
		{
			custom_validation_error();
		}
    }

	private function _send_email($code,$email) {

		$this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);

        $this->email->from($this->config->item("webmail"));
        $this->email->to($email);
        $this->email->subject("Password Reset Code");
        $message  = 'Your Password Reset Code is: '.$code;
        $message .= '<br/><br/>';
        $message .= 'If you did not  request this email there is no need for further action.<br/><br/>';
         $message.='<p>Regards</p>';
        $message.='<P>The Xplore Team </p>';

        $this->email->message($message);

        $this->email->send();
    }
}
