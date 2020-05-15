<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NewsModel extends MY_Model
{
	public function get_all_news($per_page='',$offset='',$search_key=null,$filter_by=null,$is_popular=null,$category_id=null,$count=false)
	{
		$this->db->select('N.*,NC.name as category_name');
		$this->db->from('news as N');
		$this->db->join('news_category as NC', 'N.category_id = NC.id', 'left');
		if($category_id!='')
		{
			$this->db->where('N.category_id', $category_id);
		}

		if($filter_by!='')
		{
			$this->db->where('N.status', $filter_by);
		}
		if($is_popular!='')
		{
			$this->db->where('N.is_popular', $is_popular);
		}
		if($search_key)
		{
			$this->db->where("N.title LIKE '%$search_key%' ");
			$this->db->or_where("N.date LIKE '%$search_key%' ");
		}
		if($count)
		{
			return $this->db->count_all_results();
		}
		$this->db->order_by('N.date', 'desc');
		$this->db->limit($per_page,$offset);
		return $this->db->get()->result_array();
	}

	public function get_news_details($details_id)
	{
		$this->db->select('N.*,NC.name as category_name');
		$this->db->from('news as N');
		$this->db->join('news_category as NC', 'N.category_id = NC.id', 'left');
		$this->db->where('N.id', $details_id);
		$result=$this->db->get()->row_array();
		$result['all_images']=$this->get_list("news_image",array("news_id"=>$details_id));
		$result['all_videos']=$this->get_list("news_video",array("news_id"=>$details_id));
		return $result;
	}

}

/* End of file .php */
