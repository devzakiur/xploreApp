<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Game
 * @property MY_Model $game
 */

class Game extends MY_Controller
{
	public $data=array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model('MY_Model','game',true);
        $this->session->set_userdata('top_menu', 'game_setting');
        $this->session->set_userdata('sub_menu', 'game_setting');
    }

	public function index()
	{
		checkPermission("game_setting",VIEW);

        $this->layout->title("Manage Game");
        $this->data['add']=true;
        $this->data['game_type']=$this->game->get("game_type","","position","asc");
        $this->layout->view('index',$this->data);
    }

	public function add()
	{
		checkPermission("game_setting",ADD);
		$game_type_id=$this->input->post("game_type_id");
		$name=$this->input->post("name");
		$this->game->update("game_type",array("name"=>$name),array("id"=>$game_type_id));
		$question_number=$this->input->post("question_number");
		$game_time=$this->input->post("game_time");
		$correct=$this->input->post("correct");
		$wrong=$this->input->post("wrong");
		$total_point=$this->input->post("total_point");
		$check=$this->game->get_single("game_setting",array("game_type_id"=>$game_type_id));
		if($check){
			$check->question_number=$question_number;
			$check->game_time=$game_time;
			$check->correct=$correct;
			$check->wrong=$wrong;
			$check->total_point=$total_point;
			$this->game->update("game_setting",$check,array("game_type_id"=>$game_type_id));
		}else{
			$this->game->insert("game_setting",array("game_type_id"=>$game_type_id,"question_number"=>$question_number,"game_time"=>$game_time,"correct"=>$correct,"wrong"=>$wrong,"total_point"=>$total_point));
		}
		setMessage("msg","success","Successfully");
		redirect("game");
    }

	public function single_view()
	{
		$game_type_id=$this->input->get("game_type_id");
		$result=$this->game->get_single("game_setting",array("game_type_id"=>$game_type_id));
		if(!empty($result))
		{
			$data=$result;
		}else{
			$data="";
		}
		echo json_encode($data);
		exit;
    }
}
