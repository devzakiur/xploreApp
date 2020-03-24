<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Class Game
 * @property MY_Model game
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
        $this->data['game_type']=$this->game->get_list("game_type",array("type"=>"challenge"),"","","","position","asc");
        $this->layout->view('index',$this->data);
    }

	public function add()
	{
		checkPermission("game_setting",ADD);
		$game_type_id=$this->input->post("game_type_id");
		$question_number=$this->input->post("question_number");
		$game_time=$this->input->post("game_time");
		$check=$this->game->get_single("game_setting",array("game_type_id"=>$game_type_id));
		if($check){
			$check->question_number=$question_number;
			$check->game_time=$game_time;
			$this->game->update("game_setting",$check,array("game_type_id"=>$game_type_id));
		}else{
			$this->game->insert("game_setting",array("game_type_id"=>$game_type_id,"question_number"=>$question_number,"game_time"=>$game_time));
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
