<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Class Users
 * @property Reports_Model $reports
 */
class Reports extends MY_Controller
{
	public $data = array();

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Reports_Model', 'reports', true);
		$this->session->set_userdata('top_menu', 'reports');
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
		$this->session->set_userdata('sub_menu', 'reports');
		checkPermission("reports", VIEW);
		$this->session->set_userdata('sub_menu', 'modeltest');
		$this->layout->title(" Model Test Reports");
		$this->data['category_list'] = $this->reports->get_list("category", array("status" => 1));
		$this->layout->view('index', $this->data);
	}
	public function view()
	{

		$category_id = $this->input->get("category_id");
		$from_date = $this->input->get("from_date");
		$to_date = $this->input->get("to_date");
		$this->load->library('pagination');
		$config['base_url']    = base_url('reports/view');
		$config['total_rows']  = $this->reports->get_reports("", "", $category_id, $from_date, $to_date, true);
		$config['per_page']    = QUESTION_PER_PAGE;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0)">';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tagl_close'] = '</a></li>';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tagl_close'] = '</li>';
		$config['first_tag_open'] = '<li class="page-item disabled">';
		$config['first_tagl_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tagl_close'] = '</a></li>';
		$config['attributes'] = array('class' => 'page-link');
		$this->pagination->initialize($config);
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->data['all_reports'] = $this->reports->get_reports(QUESTION_PER_PAGE, $offset, $category_id, $from_date, $to_date);
		$this->data['serial'] = $offset;
		$result = $this->load->view("reports-view", $this->data, true);
		echo json_encode($result);
		exit;
	}
	public function gameresult()
	{
		$model_test_id = $this->input->get("model_test_id");
		$page = $this->input->get("page");
		$this->layout->title(" Model Test Reports");
		$this->load->library('pagination');
		if ($this->input->get('model_test_id')) $config['suffix'] = '?' . http_build_query($_GET, '', "&");
		$config["base_url"] = base_url("reports/gameresult");
		$config['first_url'] = $config['base_url'] . '?' . http_build_query($_GET);
		$config['total_rows']  = $this->reports->get_leader_board("", "", $model_test_id, true);
		$config['per_page']    = QUESTION_PER_PAGE;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0)">';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tagl_close'] = '</a></li>';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tagl_close'] = '</li>';
		$config['first_tag_open'] = '<li class="page-item disabled">';
		$config['first_tagl_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tagl_close'] = '</a></li>';
		$config['attributes'] = array('class' => 'page-link');
		$this->pagination->initialize($config);
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->data['all_leaderboard'] = $this->reports->get_leader_board(QUESTION_PER_PAGE, $offset, $model_test_id);
		$this->data['serial'] = $page;
		// debug_r($this->data);

		$this->layout->view('leaderboard', $this->data);
	}
	public function game_challenge()
	{
		$this->session->set_userdata('sub_menu', 'game_challenge');
		checkPermission("game_challenge", VIEW);
		$this->session->set_userdata('sub_menu', 'game_challenge');
		$this->layout->title(" Game Challenge Reports");
		$this->data['category_list'] = $this->reports->get_list("category", array("status" => 1));
		$this->data['challenge_type'] = $this->reports->get_list("game_type", array("type" => "challenge"));
		$this->layout->view('game-challange-reports', $this->data);
	}
	public function challenge_view()
	{
		$challenge_type = $this->input->get("challenge_type");
		$category_id = $this->input->get("category_id");
		$from_date = $this->input->get("from_date");
		$to_date = $this->input->get("to_date");
		$this->load->library('pagination');
		$config['base_url']    = base_url('reports/challenge_view');
		$config['total_rows']  = $this->reports->get_challenge_leader_borad("", "", $category_id, $from_date, $to_date, $challenge_type, true);
		$config['per_page']    = QUESTION_PER_PAGE;
		$config['full_tag_open'] = '<ul class="pagination">';
		$config['full_tag_close'] = '</ul>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="javascript:void(0)">';
		$config['cur_tag_close'] = '</a></li>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tagl_close'] = '</a></li>';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tagl_close'] = '</li>';
		$config['first_tag_open'] = '<li class="page-item disabled">';
		$config['first_tagl_close'] = '</li>';
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tagl_close'] = '</a></li>';
		$config['attributes'] = array('class' => 'page-link');
		$this->pagination->initialize($config);
		$offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		$this->data['all_leaderboard'] = $this->reports->get_challenge_leader_borad(QUESTION_PER_PAGE, $offset, $category_id, $from_date, $to_date, $challenge_type);
		$this->data['serial'] = $offset;
		$result = $this->load->view("challenge_leaderboard", $this->data, true);
		echo json_encode($result);
		exit;
	}
}

/* End of file Users.php */
