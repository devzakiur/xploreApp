<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/* * ***************Auth.php**********************************
 * @product name    : Incentory
 * @type            : Class
 * @class name      : Auth
 * @description     : This class used to handle user authentication functionality 
 *                    of the application.  
 * @author          : 	
 * @url             :      
 * @support         : yousuf361@gmail.com	
 * @copyright       :  	
 * ********************************************************** */

class Auth extends CI_Controller {

    public $data = array();

    public function __construct() {

        parent::__construct();
        //date_default_timezone_set($setting->time_zone);
        $this->load->model('Auth_model', 'auth', true);
    }

    /** ***************Function login**********************************
     * @type            : Function
     * @function name   : login
     * @description     : Authenticatte when uset try lo login. 
     *                    if autheticated redirected to logged in user dashboard.
     *                    Also set some session date for logged in user.   
     * @param           : null 
     * @return          : null 
     * ********************************************************** */

    public function login() {
        if(logged_in_user_id())
        {
            redirect('dashboard');
        }
        if ($_POST) {
            $this->form_validation->set_rules('username', 'username', 'trim|required|xss_clean');
            $this->form_validation->set_rules('password', 'Password', 'trim|required|xss_clean');
            if ($this->form_validation->run() == FALSE) {
                $this->session->set_flashdata('msg', '<div class="alert alert-danger">Validation Error!</div>');
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
                                $this->session->set_flashdata('msg', '<div class="alert alert-warning">Your Account Not Active.</div>');
                                redirect("auth/login");    
                            }
                            $role=$this->auth->get_single("roles",array("id"=>$check_username->role_id));
                            if(empty($role)){
                                $this->session->set_flashdata('msg', '<div class="alert alert-warning">You have no permission</div>');
                                redirect("auth/login");
                            }
                            if($role->id!=1)
                            {
                                $permission=$this->auth->get_list("roles_permissions",array("role_id"=>$check_username->role_id));
                                if (empty($permission)) {
                                    $this->session->set_flashdata('msg', '<div class="alert alert-warning">You have no permission</div>');
                                    redirect("auth/login");
                                }
                            }
                            $this->session->set_userdata('id', $check_username->id);
                            $this->session->set_userdata('username', $check_username->username);
                            $this->session->set_userdata('role_id', $check_username->role_id);
                            $this->session->set_userdata('role_name', $role->name);
                            $this->session->set_userdata('top_menu',"dashboard");
                            $log_data=array(
                                "ip"=>$_SERVER['REMOTE_ADDR'],
                                "user_agent"=>set_loging_agent(),
                                "last_login"=>date("Y-m-d H:i:s")
                            );
                            $this->auth->update("admin",$log_data,array("id"=>$check_username->id));
                            $this->session->set_flashdata('msg', '<div class="alert alert-success">Login Successfully.</div>');
                            redirect('dashboard');
                        }
                        else
                        {
                            $this->session->set_flashdata('msg', '<div class="alert alert-danger">Password Incorrect!</div>');
                            redirect("auth/login");
                        }
                    }else{
                        $this->session->set_flashdata('msg', '<div class="alert alert-danger">Your Account Disabled!</div>');    
                    }
                }
                else
                {
                    $this->session->set_flashdata('msg', '<div class="alert alert-danger">Username No Matched!</div>');
                    redirect("auth/login");
                }
            }
        }
        $this->load->view("login");
    }

    /*     * ***************Function logout**********************************
     * @type            : Function
     * @function name   : logout
     * @description     : Log Out the logged in user and redirected to Login page  
     * @param           : null 
     * @return          : null 
     * ********************************************************** */

    public function logout() {
        if(!logged_in_user_id())
        {
            redirect('');
        }
        $this->session->unset_userdata('id');
        $this->session->unset_userdata('role_id');
        $this->session->unset_userdata('company_id');
        $this->session->unset_userdata('branch_id');
        $this->session->unset_userdata('location_id');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('name');

        $this->session->sess_destroy();
        redirect();
        exit;
    }


    /*     * ***************Function forgot**********************************
     * @type            : Function
     * @function name   : forgot
     * @description     : Load recover forgot password view file  
     * @param           : null 
     * @return          : null 
     * ********************************************************** */

    public function forgot() {
        $this->load->view('forgot');
    }

    /*     * ***************Function forgotpass**********************************
     * @type            : Function
     * @function name   : forgotpass
     * @description     : this function is used to send recover forgot password  email 
     * @param           : null 
     * @return          : null 
     * ********************************************************** */

    public function forgotpass() {
        if ($_POST) {
            $data['username'] = $this->input->post('email');
            $data['status'] = 1;
            $login = $this->auth->get_single('admin', $data);
            if (!empty($login)) {
                $this->_send_email($login);
                setMessage("msg","success","Check Your mail.");
            } else {
                setMessage("msg","danger"," Email Not Exits.");
            }
        }

        redirect('auth/forgot');
        // exit;
    }

    /*     * ***************Function _send_email**********************************
     * @type            : Function
     * @function name   : _send_email
     * @description     : this function used to send recover forgot password email 
     * @param           : $data array(); 
     * @return          : null 
     * ********************************************************** */

     /*     * ***************Function _send_email**********************************
     * @type            : Function
     * @function name   : _send_email
     * @description     : this function used to send recover forgot password email 
     * @param           : $data array(); 
     * @return          : null 
     * ********************************************************** */

    private function _send_email($data) {

        $this->load->library('email');
        $config['protocol'] = 'sendmail';
        $config['mailpath'] = '/usr/sbin/sendmail';
        $config['charset'] = 'iso-8859-1';
        $config['wordwrap'] = TRUE;
        $config['mailtype'] = 'html';
        $this->email->initialize($config);

        $this->email->from($this->config->item("webmail"));
        $this->email->to($data->username);
        $this->email->subject(DC . ': Password reset Email');
        $key = uniqid();
        $this->auth->update('admin', array('reset_key' => $key), array('id' => $data->id));

        $message = 'A request was received to reset the password for this account on ' . DC . '.<br/>';
        $message .= 'To change this password please click on the following link <br/><br/>';
        $message .= '<a href="'.site_url("auth/reset/" .$key).'">Click Here to reset</a>';
        $message .= '<br/><br/>';
        $message .= 'If you did not  request this email there is no need for further action.<br/><br/>';
         $message.='<p>Regards</p>';
        $message.='<P>The '.DC.' Team </p>';

        $this->email->message($message);

        $this->email->send();
    }
    

    /*     * ***************Function reset**********************************
     * @type            : Function
     * @function name   : reset
     * @description     : this function used to load password reset view file 
     * @param           : $key string parameter; 
     * @return          : null 
     * ********************************************************** */

    public function reset($key=null) {
        $data = array();
        $user = $this->auth->get_single('admin', array('reset_key' => $key));

        if (!empty($user)) {
            $data['user'] = $user;
            $data['key'] = $key;
            $this->load->view('reset', $data);
        } else {
            setMessage("msg","danger","This key is backded");
            redirect("auth/forgot");
        }
    }

        /*     * ***************Function resetpass**********************************
     * @type            : Function
     * @function name   : resetpass
     * @description     : this function used to reset user passwrd 
     *                    after sucessfull reset password it's redirected
     *                    user to log in page            
     * @param           : null; 
     * @return          : null 
     * ********************************************************** */

    public function resetpass() {

        $this->load->library('Enc_lib');    
        if ($_POST) {
            $this->form_validation->set_rules('password', $this->lang->line('password'), 'trim|required|min_length[4]|max_length[12]');
            $this->form_validation->set_rules('confrim_password', $this->lang->line('conf_password'), 'trim|required|matches[password]');

            if ($this->form_validation->run() === TRUE) {
                $data['password'] = $this->enc_lib->passHashEnc($this->input->post('password'));
                $data['temp_password'] = base64_encode($this->input->post('password'));
                $data['reset_key'] = NULL;
                $this->auth->update('admin', $data, array('id' => $this->input->post('id')));
                setMessage("msg","success","Password Reset Success.");
                redirect();
            } else {
                setMessage("msg","danger",validation_errors());
                redirect('auth/reset/' . $this->input->post('key'));
            }
        }
        redirect();
        exit;
    }
}
