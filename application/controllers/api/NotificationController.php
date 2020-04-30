<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;

/**
 * Class NewsController
 * @property NofitifactionModel $notification;
 */
class NotificationController extends MY_ApiController
{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->model("NofitifactionModel","notification",true);
	}

	public function get_notification_post()
	{
		$page=$this->input->post("page");
		$category_id=$this->input->post("category_id");
		$total_rows=$this->notification->get_notification_list("","",$category_id,true);
		if($total_rows>0)
		{
			$per_page=10;
			$total_page=ceil($total_rows/$per_page);
			if ($page>=$total_page)
			{
				$page=$total_page;
				$next_page=0;
			}elseif($page<=0)
			{
				$page=1;
				$next_page=2;
			}
			else{
				$next_page=$page+1;
			}
			$offset=($page-1)*$per_page;
			$result=$this->notification->get_notification_list($per_page,$offset,$category_id);
			$data['data']=$result;

			$data['next_page']=$next_page;
		}
		else{
			$data['data']=null;
			$data['next_page']=0;
		}
			$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["Notification List"],
				"data"=>$data
			], RestController::HTTP_OK );
	}

}
