<?php
error_reporting(E_ALL);
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller {
    function __construct() {
        parent::__construct();
        if (!logged_in_user_id()) {
            redirect();
            exit;
        }
    }
}
