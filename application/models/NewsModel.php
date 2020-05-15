<?php

defined('BASEPATH') or exit('No direct script access allowed');

class NewsModel extends MY_Model
{
	public function get_news_list($per_page = '', $offset = '', $search_key = '', $category_id = '', $is_popular = '', $count = false)
	{
		$this->db->select('N.*,NC.name as category_name');
		$this->db->from('news as N');
		$this->db->join('news_category as NC', 'N.category_id = NC.id', 'left');
		if ($category_id != '') {
			$this->db->where('N.category_id', $category_id);
		}
		if ($is_popular != '') {
			$this->db->where('N.is_popular', $is_popular);
		}
		if ($search_key) {
			$this->db->where("N.title LIKE '%$search_key%' ");
		}
		if ($count) {
			return $this->db->count_all_results();
		}
		$this->db->order_by('N.date', 'desc');
		$this->db->limit($per_page, $offset);
		$this->db->where('N.status', 1);
		$result = $this->db->get()->result_array();
		$news_id = array();
		if ($result) {
			foreach ($result as $value) {
				$news_id[] = $value['id'];
			}
		}
		$data['news'] = $result;
		$data['image_list'] = $this->get_news_image($news_id);
		$data['video_list'] = $this->get_news_video($news_id);
		return $data;
	}

	public function get_news_image(array $news_id)
	{
		$this->db->select('*');
		$this->db->from('news_image');
		$this->db->where_in('news_id', $news_id);
		return $this->db->get()->result_array();
	}
	public function get_news_video(array $news_id)
	{
		$this->db->select('*');
		$this->db->from('news_video');
		$this->db->where_in('news_id', $news_id);
		return $this->db->get()->result_array();
	}
}
