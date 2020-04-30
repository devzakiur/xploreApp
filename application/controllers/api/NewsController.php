<?php
defined('BASEPATH') OR exit('No direct script access allowed');
use chriskacerguis\RestServer\RestController;

/**
 * Class NewsController
 * @property NewsModel $news;
 */
class NewsController extends MY_ApiController
{
	public function __construct($config = 'rest')
	{
		parent::__construct($config);
		$this->load->model("NewsModel","news",true);
	}

	public function get_news_category_get()
	{
		$result=$this->news->get_list("news_category",array("status"=>1),"","","","position","asc");
		$this->response( [
				'status' => true,
				'status_code' =>HTTP_OK,
				'message' => ["News Category"],
				"data"=>$result
			], RestController::HTTP_OK );
	}

	public function get_news_list_post()
	{
		$search_key=$this->input->post("search_key");
		$page=$this->input->post("page");
		$category_id=$this->input->post("category_id");
		$is_popular=$this->input->post("is_popular");
		$total_rows=$this->news->get_news_list("","",$search_key,$category_id,$is_popular,true);
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
			$result=$this->news->get_news_list($per_page,$offset,$search_key,$category_id,$is_popular);
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
				'message' => ["News List"],
				"data"=>$data
			], RestController::HTTP_OK );
	}

}
