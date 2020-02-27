<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
class UserController extends RestController
{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->model("MY_Model","auth",true);
	}

	public function users_get()
    {
       	verify_request();
    	$tokenData = 'Hello World!';
        // Create a token
         // Users from a data store e.g. database
        $users["user"] = [
            ['id' => 0, 'name' => 'John', 'email' => 'john@example.com'],
            ['id' => 1, 'name' => 'Jim', 'email' => 'jim@example.com'],
        ];
        $this->data["user"] = [
            ['id' => 0, 'name' => 'John', 'email' => 'john@example.com'],
            ['id' => 1, 'name' => 'Jim', 'email' => 'jim@example.com'],
        ];
		$this->data['names']=['joy','sujon'];
        $id = $this->get( 'id' );

        if ( $id === null )
        {
            // Check if the users data store contains users
            if ( $users )
            {
                // Set the response and exit
                $this->response( [
                    'status' => false,
                    "statuscode"=>RestController::HTTP_OK,
                    'message' => ['No users were found'],
					"data"=>$this->data
                ], RestController::HTTP_OK );
                $this->response( $users, RestController::HTTP_OK );
            }
            else
            {
                // Set the response and exit
                $this->response( [
                    'status' => false,
                    'message' => 'No users were found'
                ], RestController::HTTP_NOT_FOUND );
            }
        }
        else
        {
            if ( array_key_exists( $id, $users ) )
            {
                $this->response( $users[$id], RestController::HTTP_OK );
            }
            else
            {
                $this->response( [
                    'status' => false,
                    'message' => 'No such user found'
                ], RestController::HTTP_NOT_FOUND );
            }
        }
    }

    public function users_post()
    {
        $this->response($_POST,RestController::HTTP_OK);
    }
    public function login_post()
	 {
	 		$_POST = json_decode(file_get_contents("php://input"), true);
        	$this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
            	$this->response( [
                    'status' => false,
                    'message' => $this->form_validation->error_array()
                ], RestController::HTTP_NOT_FOUND );
            }
            else
            {
                $username = $this->input->post('username');
                $password =$this->input->post('password');
                $check_username=$this->auth->get_single("admin",array("username"=>$username));
                if($check_username)
                {
                    if($check_username->status==1)
                    {
                        $this->load->library("Enc_lib");
                        $password_verify=$this->enc_lib->passHashDyc($password,$check_username->password);
                        if($password_verify)
                        {
                            if(!$check_username->status==1)
                            {
                                //account not active
									$this->response( [
									'status' => false,
									'message' =>"Account Not active"
								], RestController::HTTP_NOT_FOUND );
                            }
                            $role=$this->auth->get_single("roles",array("id"=>$check_username->role_id));
                            if(empty($role)){
									$this->response( [
									'status' => false,
									'message' =>"You have No Permission"
								], RestController::HTTP_NOT_FOUND );
                            }
                            if($role->id!=1)
                            {
                                $permission=$this->auth->get_list("roles_permissions",array("role_id"=>$check_username->role_id));
                                if (empty($permission)) {
                                   //you have no permission
										$this->response( [
										'status' => false,
										'message' =>"You have No Permission"
									], RestController::HTTP_NOT_FOUND );
                                }
                            }
                           //login successfull
							$token_data=array(
							"id"=>$check_username->id,
							"user_name"=>$check_username->username,
							"timestamp"=>time()
							);
							$this->response( [
								'status' => true,
								'message' =>"Login Successfull",
								'token'=>AUTHORIZATION::generateToken($token_data)
							], RestController::HTTP_OK );
                        }
                        else
                        {
                        	//Password Incorrect!

							$this->response( [
								'status' => false,
								'message' =>"Password Incorrect"
							], RestController::HTTP_NOT_FOUND );
                        }
                    }else{
                    	//Your Account Disabled!
						$this->response( [
							'status' => false,
							'message' =>"Your Account Disabled!"
						], RestController::HTTP_NOT_FOUND );
                    }
                }
                else
                {
                	//Username No Matched!
						$this->response( [
							'status' => false,
							'message' =>"Username No Matched!"
						], RestController::HTTP_NOT_FOUND );
                }
            }

	 }
}
