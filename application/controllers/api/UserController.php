<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;

/**
 * Class UserController
 * @property Auth_model $user;
 */
class UserController extends RestController
{
	private $id="";
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		date_default_timezone_set("Asia/Dhaka");
		$this->load->model("Auth_model","user",true);
		$this->load->helper('string');
	}

	/**
	 * get request
	 */
	public function terms_condition_get()
	{
		$toc=$this->user->get_single("content",array("slug"=>"toc"));
		if($toc)
		{
			$toc->description=html_entity_decode($toc->description);
		}else{
			$toc=null;
		}
		$this->response( [
			'status' => true,
			'status_code' =>HTTP_OK,
			'message' => ["Terms Of Conditions"],
			"data"=>$toc
		], RestController::HTTP_OK );
	}
	/**
	 * post request 
	 */
	public function login_post()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		if($this->form_validation->run() === TRUE) {
			$email = $this->input->post('email');
			$password =$this->input->post('password');
			$check_email=get_users(array("email"=>$email),"password,token_key");
			if($check_email)
			{
				if($check_email->status==1)
                    {
                        $this->load->library("Enc_lib");
                        $password_verify=$this->enc_lib->passHashDyc($password,$check_email->password);
                        if($password_verify)
                        {
                        	$token_key=random_string("alpha",10);
                        	$this->user->update("users",array("token_key"=>$token_key),array("id"=>$check_email->id));
                           //login successfull
							$token_data=array(
								"id"=>$check_email->id,
								"email"=>$check_email->email,
								"token_key"=>$token_key,
								"timestamp"=>time()
							);
							$check_email->password="";
							$check_email->token_key="";
							$this->response( [
								'status' => true,
								'status_code' => 200,
								'message' =>["Login Successfull"],
								'token'=>AUTHORIZATION::generateToken($token_data),
								"data"=>$check_email
							], RestController::HTTP_OK );
                        }
                        else
                        {
                        	//Password Incorrect!

							$this->response( [
								'status' => false,
								'status_code' => 455,
								'message' =>["Password Incorrect"]
							], RestController::HTTP_OK );
                        }
                    }else{
                    	//Your Account Disabled!
						$this->response( [
							'status' => false,
							'status_code' => 456,
							'message' =>["Your Account Disabled!"]
						], RestController::HTTP_OK );
                    }
			}
			else{
				$this->response( [
					'status' => false,
					"status_code"=>455,
					'message' =>["Email No Found!"]
				], RestController::HTTP_OK );
			}
		}
		else
		{
			custom_validation_error();
		}
	}
	public function register_post()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean|callback_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
		$this->form_validation->set_rules('toc', 'Terms & Condition', 'trim|xss_clean|required|callback_toc');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|xss_clean|matches[password]');
		if($this->form_validation->run() === TRUE) {
        	$this->load->library('Enc_lib');
			$code=generateNumericOTP();
			$this->data['email']=$this->input->post("email");
			$this->data['email_code']=$code;
			$this->data['email_time']=date("Y-m-d H:i:s");
			$this->data['email_status']=false;
			$this->data['token_key']=random_string('alpha', 10);
			$this->data['password']=$this->enc_lib->passHashEnc($this->input->post('password'));
			$this->data['toc']=$this->input->post("toc");
			$check=$this->user->exits_check("users",array("email"=>$this->input->post("email"),"email_status"=>0));
			if($check){
				$this->user->update("users",$this->data,array("email"=>$this->input->post("email")));
			}
			else{
				$this->user->insert("users",$this->data);
			}
			$send=$this->_send_email($code,$this->input->post("email"));
			$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Message Sent Successfully"]
			], RestController::HTTP_OK );

		}else{
			custom_validation_error();
		}
	}
	public function email_resend_post()
	{
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
			if($this->form_validation->run() === TRUE) {
				$user=$this->user->get_single("users",array("email"=>$this->input->post("email")));
				if(!empty($user))
				{
					if($user->email_status)
					{
						$this->response( [
							'status' => true,
							'status_code' =>HTTP_OK,
							'message' => ["Already Verified"]
						], RestController::HTTP_OK );
					}
					$code=generateNumericOTP();
					$send=$this->_send_email($code,$this->input->post("email"));
					$data['email_code']=$code;
					$data['email_time']=date("Y-m-d H:i:s");
					$this->user->update("users",$data,array("id"=>$user->id));
					$this->response( [
						'status' => true,
						'status_code' =>HTTP_OK,
						'message' => ["Message Sent Successfully"]
					], RestController::HTTP_OK );
				}
				else
				{
					$this->response( [
						'status' => false,
						'status_code' =>HTTP_NOT_FOUND,
						'message' => ["User Not Found"]
					], RestController::HTTP_OK );
				}
			}else
			{
				custom_validation_error();
			}
	}

	public function email_verification_post()
	{
		$this->form_validation->set_rules('code', 'Code', 'trim|required|xss_clean');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|xss_clean');
		if($this->form_validation->run() === TRUE) {
			$email=$this->input->post("email");
			$user_data=get_users(array("email"=>$email,"email_code"=>$this->input->post("code")),"email_time,token_key");
			if(!empty($user_data)){
				if($user_data->email_status)
				{
					$user_data->email_time="";
					$this->response( [
						'status' => false,
						'status_code' =>HTTP_OK,
						'message' =>["Already Verify"],
						"data"=>$user_data
					], RestController::HTTP_OK );
				}
				$email_time=new DateTime($user_data->email_time);
				$now_date_diff=$email_time->diff(new DateTime("now"));
				$minutes = $now_date_diff->days * 24 * 60;
				$minutes += $now_date_diff->h * 60;
				$minutes += $now_date_diff->i;
				if($minutes<=5)
				{
					$data['email_status']=1;
					$data['status']=1;
					$this->user->update("users",$data,array("email"=>$email));
					$user_data->email_time="";
					$token_data=array(
						"id"=>$user_data->id,
						"email"=>$user_data->email,
						"token_key"=>$user_data->token_key,
						"timestamp"=>time()
						);
					$user_data->email_status=1;
					$user_data->token_key="";
					$user_data->status=1;
					$this->response( [
						'status' => true,
						'status_code' =>200,
						'message' =>["Email Verification Successfully"],
						'token'=>AUTHORIZATION::generateToken($token_data),
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

	public function profile_setup_post()
	{
		$this->id=verify_request();
		$this->_prepare_form_validation();
		if($this->form_validation->run() === TRUE) {
			$data=$this->_get_posted_data();
			$this->user->update("users",$data,array("id"=>$this->id));
			$user_data=get_users(array("id"=>$this->id));
			$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Profile Setup Successfully"],
				"data"=>$user_data
			], RestController::HTTP_OK );

		}else{
			custom_validation_error();
		}
    }

    public function phone_verification_post()
	{
		$this->id=verify_request();

		$this->form_validation->set_rules('code', 'Code', 'trim|required|xss_clean');
		if($this->form_validation->run() === TRUE) {
			$user_data=get_users(array("id"=>$this->id,"phone_code"=>$this->input->post("code")),"phone_time");
			if(!empty($user_data)){
				if($user_data->phone_status)
				{
					$user_data->phone_time="";
					$this->response( [
						'status' => false,
						'status_code' =>HTTP_OK,
						'message' =>['Already Verified'],
						"data"=>$user_data
					], RestController::HTTP_OK );
				}
				$phone_time=new DateTime($user_data->phone_time);
				$now_date_diff=$phone_time->diff(new DateTime("now"));
				$minutes = $now_date_diff->days * 24 * 60;
				$minutes += $now_date_diff->h * 60;
				$minutes += $now_date_diff->i;
				if($minutes<=5)
				{
					$data['phone_status']=1;
					$this->user->update("users",$data,array("id"=>$this->id));
					$user_data->phone_status=1;
					$user_data->phone_time="";
					$this->response( [
						'status' => true,
						'status_code' =>200,
						'message' =>["Phone Verification Successfully"],
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

	public function phone_resend_post()
	{
		$this->id=verify_request();

		$this->form_validation->set_rules('phone', 'Phone', 'trim|required|xss_clean|callback_phone');
			if($this->form_validation->run() === TRUE) {
				$user=get_users(array("id"=>$this->id));
				if($user->phone_status)
				{
					$this->response( [
						'status' => true,
						'status_code' =>HTTP_OK,
						'message' => ["Already Verified"]
					], RestController::HTTP_OK );
				}
				$code=generateNumericOTP();
				$send=$this->_send_message($code,$this->input->post("phone"));
				$data['phone_code']=$code;
				$data['phone_time']=date("Y-m-d H:i:s");
				$this->user->update("users",$data,array("id"=>$this->id));
				$this->response( [
					'status' => true,
					'status_code' =>HTTP_OK,
					'message' => ["Message Sent Successfully"],
					"data"=>["phone_code"=>$code]
				], RestController::HTTP_OK );
			}else
			{
				custom_validation_error();
			}
	}

	public function phone(){
		$email = $this->user->duplicate_check("users","phone",$this->input->post('phone'),$this->id);
		if ($email) {
			$this->form_validation->set_message('phone', "Phone Already Exits");
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function category_setup_post()
	{
		$this->id=verify_request();

		$this->form_validation->set_rules('category_id', 'Category', 'trim|xss_clean');
		$this->form_validation->set_rules('subject_id', 'Subject', 'trim|xss_clean');
		$this->form_validation->set_rules('notification', 'Notification', 'trim|xss_clean');
		if($this->form_validation->run() === TRUE) {
			$data['category_id']=$this->input->post("category_id");
			$data['subject_id']=$this->input->post("subject_id");
			if($this->input->post("notification")!='')
			{
				$data['notification']=$this->input->post("notification");
			}
			$this->user->update("users",$data,array("id"=>$this->id));
			$user_data=get_users(array("id"=>$this->id));
//			$user_data->subject_id=explode(",",$user_data->subject_id);
			$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Category Save Successfully"],
				"data"=>$user_data
			], RestController::HTTP_OK );

		}else{
			custom_validation_error();
		}
	}

	public function device_info_post()
	{
		$this->id=verify_request();

		$this->form_validation->set_rules('device_id', 'Device Id', 'trim|required|xss_clean');
		$this->form_validation->set_rules('model', 'Model', 'trim|required|xss_clean');
		$this->form_validation->set_rules('manufacture', 'Manufacture', 'trim|required|xss_clean');
		$this->form_validation->set_rules('version', 'Version', 'trim|required|xss_clean');
		$this->form_validation->set_rules('fcm_token', 'FCM Token', 'trim|required|xss_clean');
		if($this->form_validation->run() === TRUE) {
			$this->data['user_id']=$this->id;
			$this->data['device_id']=$this->input->post("device_id");
			$this->data['model']=$this->input->post("model");
			$this->data['manufacture']=$this->input->post("manufacture");
			$this->data['version']=$this->input->post("version");
			$this->data['fcm_token']=$this->input->post("fcm_token");
			$exits=$this->user->exits_check("device_info",array("user_id"=>$this->id));
			if($exits){
				$this->data['updated_at']=date("Y-m-d H:i:s");
				$this->user->update("device_info",$this->data,array("user_id"=>$this->id));
			}else{
				$this->user->insert("device_info",$this->data);
			}
			$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Save Successfully"]
			], RestController::HTTP_OK );

		}else{
			custom_validation_error();
		}
	}

	public function email(){
		$email = $this->user->exits_check("users",array("email"=>$this->input->post('email'),"email_status"=>1));
		if ($email) {
			$this->form_validation->set_message('email', "Email Already Exits");
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function toc()
	{
		$toc=$this->input->post("toc");
		if($toc==1){
			return true;
		}
		$this->form_validation->set_message('toc', "Please Check Terms Of Conditions");
		return false;
	}

	/**
	 *profile setup from validation
	 */
	
	public function _prepare_form_validation()
	{
		$this->form_validation->set_rules('name', 'Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('display_name', 'Display Name', 'trim|required|xss_clean');
		$this->form_validation->set_rules('phone', 'Phone', 'trim|xss_clean|required|callback_phone');
		$this->form_validation->set_rules('gender', 'Gender', 'trim|xss_clean|required');
		$this->form_validation->set_rules('dob', 'Date Of Birth', 'trim|xss_clean|required');
//		$this->form_validation->set_rules('picture', 'Picture', 'trim|xss_clean');
//		$this->form_validation->set_rules('cover_picture', 'Cover Picture', 'trim|xss_clean');
	}

	public function _get_posted_data()
	{
		$data['name']=$this->input->post("name");
		$data['display_name']=$this->input->post("display_name");
		$data['phone']=$this->input->post("phone");
		$data['gender']=$this->input->post("gender");
		$data['dob']=$this->input->post("dob");
//		$data['picture']=$this->input->post("picture");
		if (isset($_FILES['picture']['name'])) {
			if (!is_dir('uploads/users')) {
					mkdir('./uploads/users', 0777, TRUE);
				}
			$image_name=$this->_upload_picture();

			$data['picture'] ="uploads/users/".$image_name;
		}
//		$data['cover_picture']=$this->input->post("cover_picture");
		$phone=$this->user->get_single("users",array("id"=>$this->id))->phone;
		if($phone!=$data['phone'])
			$data['phone_status']=false;
		return $data;
	}

	public function _upload_picture()
    {
        $name = $_FILES['picture']['name'];
        $arr = explode('.', $name);
        $ext = end($arr);
        $imageName=APP_NAME.'_'.time()."U.$ext";
        $config['upload_path']          = './uploads/users';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        $config['file_name']            = $imageName;
        $config['max_size']             = 500;
        $this->load->library('upload');
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('picture'))
        {
        	$this->response( [
				'status' => false,
				'status_code' =>422,
				'message' => [strip_tags($this->upload->display_errors())]
			], RestController::HTTP_OK );
        }
        else
        {
            $this->load->library('image_lib');
            $config['image_library']  = 'gd2';
            $config['source_image'] = './uploads/users/'.$imageName;
            $config['create_thumb']   = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width']          = 300;
            $config['height']         = 300;
            $config['new_image']      = './uploads/users/'.$imageName;
            $this->image_lib->initialize($config);
            if ($this->image_lib->resize()) {
                $this->image_lib->clear();
            }
			$prev_photo=$this->user->get_single("users",array("id"=>$this->id))->picture;
			@unlink($prev_photo);
            return $imageName;
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
        $this->email->subject("Email Verification");
        $message  = 'Your Verification Code is: '.$code;
        $message .= '<br/><br/>';
        $message .= 'If you did not  request this email there is no need for further action.<br/><br/>';
         $message.='<p>Regards</p>';
        $message.='<P>The Xplore Team </p>';

        $this->email->message($message);

        $this->email->send();
    }

	public function _send_message($code,$phone)
	{
		return true;
    }
	//social login

	public function fb_social_login_post()
	{
		$data['name']=$this->input->post("name");
		$data['phone']=$this->input->post("phone");
		$data['email']=$this->input->post("email");
		$data['gender']=$this->input->post("gender");
		$data['fb_id']=$this->input->post("fb_id");
		$user=get_users(array("fb_id"=>$data['fb_id']),"token_key");
		if($user)
		{
			$token_data=array(
				"id"=>$user->id,
				"email"=>$user->email,
				"token_key"=>$user->token_key,
				"timestamp"=>time()
			);
			$this->response( [
				'status' => true,
				'status_code' =>200,
				'message' =>["User Information"],
				'token'=>AUTHORIZATION::generateToken($token_data),
				"data"=>$user
			], RestController::HTTP_OK );
		}else{
			$data['token_key']=random_string('alpha', 10);
			$data['email_status']=1;
			$data['phone_status']=1;
			$data['status']=1;
			$data['toc']=1;
			$exits=$this->user->login_check($data['email'],$data['phone']);
			if($exits)
			{
				$id=$exits->id;
				$this->user->update("users",array("fb_id"=>$data['fb_id'],"token_key"=>$data['token_key']),array("id"=>$exits->id));
			}else{
				$insert_id=$this->user->insert("users",$data);
				$id=$insert_id;
			}
			$user=get_users(array("id"=>$id));
			$token_data=array(
				"id"=>$id,
				"email"=>$data['email'],
				"token_key"=>$data['token_key'],
				"timestamp"=>time()
			);
			$this->response( [
				'status' => true,
				'status_code' =>200,
				'message' =>["User Information"],
				'token'=>AUTHORIZATION::generateToken($token_data),
				"data"=>$user
			], RestController::HTTP_OK );
		}
    }

	public function google_social_login_post()
	{
		$data['name']=$this->input->post("name");
		$data['phone']=$this->input->post("phone");
		$data['email']=$this->input->post("email");
		$data['gender']=$this->input->post("gender");
		$data['google_id']=$this->input->post("google_id");
		$user=get_users(array("google_id"=>$data['google_id']),"token_key");
		if($user)
		{
			$token_data=array(
				"id"=>$user->id,
				"email"=>$user->email,
				"token_key"=>$user->token_key,
				"timestamp"=>time()
			);
			$this->response( [
				'status' => true,
				'status_code' =>200,
				'message' =>["User Information"],
				'token'=>AUTHORIZATION::generateToken($token_data),
				"data"=>$user
			], RestController::HTTP_OK );
		}else{
			$data['token_key']=random_string('alpha', 10);
			$data['email_status']=1;
			$data['phone_status']=1;
			$data['status']=1;
			$data['toc']=1;
			$exits=$this->user->login_check($data['email'],$data['phone']);
			if($exits)
			{
				$id=$exits->id;
				$this->user->update("users",array("google_id"=>$data['google_id'],"token_key"=>$data['token_key']),array("id"=>$exits->id));
			}else{
				$insert_id=$this->user->insert("users",$data);
				$id=$insert_id;
			}
			$user=get_users(array("id"=>$id));
			$token_data=array(
				"id"=>$id,
				"email"=>$data['email'],
				"token_key"=>$data['token_key'],
				"timestamp"=>time()
			);
			$this->response( [
				'status' => true,
				'status_code' =>200,
				'message' =>["User Information"],
				'token'=>AUTHORIZATION::generateToken($token_data),
				"data"=>$user
			], RestController::HTTP_OK );
		}
    }
    
    // need api token
	public function logout_get()
	{
		$this->id=verify_request();
		$this->user->update("users",array("token_key"=>random_string("alpha",10)),array("id"=>$this->id));
		$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Logout Successfully"],
			], RestController::HTTP_OK );
    }
    // server time check
	public function get_time_get()
	{
		$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Server Time"],
				'data' =>[
					"time"=>date("Y-m-d H:i:s")
				],
			], RestController::HTTP_OK );
    }

}
