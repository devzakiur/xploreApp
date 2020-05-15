<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Library_Model extends MY_Model
{
	public function get_assign_topic_list()
	{
		$this->db->select('T.*');
		$this->db->from('topic_assign as TA');
		$this->db->join('topic as T', 'TA.topic_id = T.id', 'left');
		$this->db->group_by('TA.topic_id');
		return $this->db->get()->result_array();
	}

	public function get_assign_subject_list()
	{
		$this->db->select('S.*');
		$this->db->from('subject_assign as SA');
		$this->db->join('subject as S', 'SA.subject_id = S.id', 'left');
		$this->db->group_by('SA.subject_id');
		return $this->db->get()->result_array();
	}
	public function get_topic_relation($topic_id)
	{
		$this->db->select('S.name as section_name,SB.name as subject_name,C.name as category_name,C.id as category_id');
		$this->db->from('topic_assign as TA');
		$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
		$this->db->join('section as S', 'SA.section_id = S.id', 'left');
		$this->db->join('subject_assign as SBA', 'SA.subject_id = SBA.subject_id', 'left');
		$this->db->join('subject as SB', 'SBA.subject_id = SB.id', 'left');
		$this->db->join('category as C', 'SBA.category_id = C.id', 'left');
		$this->db->where('TA.topic_id', $topic_id);
		return $this->db->get()->result_array();
	}

	public function get_all_library_old($per_page = '', $offset = '', $search_key = null, $filter_by = null, $count = false)
	{
		$this->db->select('L.*');
		$this->db->from('library as L');
		$this->db->order_by('L.id', 'desc');
		if ($filter_by != '') {
			$this->db->where('L.status', $filter_by);
		}
		if ($search_key) {
			$search = $search_key['search_key'];
			if ($search) {
				$this->db->where("L.title LIKE '%$search%' ");
				$this->db->or_where("T.name LIKE '%$search%' ");
			}
		}
		if ($count) {
			return $this->db->count_all_results();
		}
		$this->db->limit($per_page, $offset);
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['topic_name'] = $this->get_topic_name($value['id']);
				$data[$key]['category_name'] = $this->get_category($value['id']);;
				$data[$key]['status'] = $value['status'];
				$data[$key]['title'] = $value['title'];
				$data[$key]['details'] = $value['details'];
			}
		}
		return $data;
	}

	public function get_all_library($per_page = '', $offset = '', $search_key = null, $created_by = null, $filter_by = null, $category_id = null, $subject_id = null, $section_id = null, $topic_id = null, $count = false)
	{
		$this->db->select('L.*');
		$this->db->distinct();
		$this->db->from('library as L');
		$this->db->join('topic_library as TL', 'L.id = TL.library_id', 'left');
		$this->db->join('category as C', 'TL.category_id = C.id', 'left');
		$this->db->join('topic as T', 'TL.topic_id = T.id', 'left');
		$this->db->order_by('L.id', 'desc');
		if ($category_id != '') {
			$this->db->where('TL.category_id', $category_id);
			if ($topic_id != '') {
				$this->db->join('topic_assign as TA', 'TL.topic_id = TA.topic_id', 'left');
				$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
				$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id', 'left');
				$this->db->where('SUBA.subject_id', $subject_id);
				$this->db->where('SA.section_id', $section_id);
				$this->db->where('TL.topic_id', $topic_id);
			} else if ($section_id != '') {
				$this->db->join('topic_assign as TA', 'TL.topic_id = TA.topic_id', 'left');
				$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
				$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id', 'left');
				$this->db->where('SUBA.subject_id', $subject_id);
				$this->db->where('SA.section_id', $section_id);
			} else if ($subject_id != '') {
				$this->db->join('topic_assign as TA', 'TL.topic_id = TA.topic_id', 'left');
				$this->db->join('section_assign as SA', 'TA.section_id = SA.section_id', 'left');
				$this->db->join('subject_assign as SUBA', 'SA.subject_id = SUBA.subject_id', 'left');
				$this->db->where('SUBA.subject_id', $subject_id);
			}
		}
		if ($filter_by != '') {
			$this->db->where('L.status', $filter_by);
		}
		if ($created_by != '') {
			$this->db->where('L.created_by', $created_by);
		}
		if ($search_key) {
			$this->db->like('L.title', $search_key, "both");
			$this->db->or_like('T.name', $search_key, "both");
			$this->db->or_like('C.name', $search_key, "both");
		}
		if ($count) {
			return $this->db->count_all_results();
		}
		$this->db->limit($per_page, $offset);
		$result = $this->db->get()->result_array();
		$data = array();
		if ($result) {
			foreach ($result as $key => $value) {
				$data[$key]['id'] = $value['id'];
				$data[$key]['topic_name'] = $this->get_topic_name($value['id']);
				$data[$key]['category_name'] = $this->get_category($value['id'])['category_name'];
				$data[$key]['status'] = $value['status'];
				$data[$key]['title'] = $value['title'];
				$data[$key]['details'] = $value['details'];
			}
		}
		return $data;
	}
	function get_topic_name($library_id)
	{
		$this->db->select('T.name as topic_name');
		$this->db->from('topic_library as TL');
		$this->db->join('topic as T', 'TL.topic_id = T.id', 'left');
		$this->db->where('TL.library_id', $library_id);
		$this->db->order_by('library_id', 'desc');
		$this->db->limit(1);
		return $this->db->get()->row_array()['topic_name'];
	}
	public function get_library_details($library_id)
	{
		$this->db->select('');
		$this->db->from('library as L');
		$this->db->where('L.id', $library_id);
		$result = $this->db->get()->row_array();
		$result['image_slide'] = $this->get_list('library_image', array("library_id" => $result['id']));
		$result['video_slide'] = $this->get_list('library_video', array("library_id" => $result['id']));
		$result['category_name'] = $this->get_category($library_id)["category_name"];
		$result['topic_name'] = $this->get_topic_name($library_id);
		return $result;
	}

	function get_library_history_details($library_id)
	{
		$this->db->select('EH.*,A.name as user_name');
		$this->db->from('edit_history as EH');
		$this->db->join('admin as A', 'EH.update_by = A.id', 'left');
		$this->db->where('EH.slug', "library");
		$this->db->where('EH.edit_id', $library_id);
		$this->db->order_by('EH.id', 'desc');
		return $this->db->get()->result_array();
	}
	function get_category($library_id)
	{
		$this->db->select('C.name as category_name,C.id as category_id');
		$this->db->from('topic_library as TL');
		$this->db->join('category as C', 'TL.category_id = C.id', 'left');
		$this->db->where('TL.library_id', $library_id);
		$result = $this->db->get()->result_array();
		$data = array();
		$category_id = array();
		foreach ($result as $value) {
			$data[] = $value['category_name'];
			$category_id[] = $value['category_id'];
		}
		$final["category_id"] = implode(',', $category_id);
		$final["category_name"] = implode(', ', $data);
		return $final;
	}

	public function get_library($id)
	{
		$this->db->select('');
		$this->db->from('library');
		$this->db->where('id', $id);
		$result = $this->db->get()->row_array();
		$result['topic_id'] = $this->get_single("topic_library", array("library_id" => $id))->topic_id;
		$result['category_id'] = $this->get_category($id)['category_id'];
		return $result;
	}

	/**
	 * override
	 * @param $table_name
	 * @param $index_array
	 * @param null $id
	 * @return mixed
	 */
	public function exits_check($table_name, $index_array, $id = null)
	{
		if ($id) {
			$this->db->where_not_in('library_id', $id);
		}
		$this->db->where($index_array);
		return $this->db->get($table_name)->num_rows();
	}
	public function get_user()
	{
		$this->db->select('A.*,A.id as admin_id,R.name as role_name');
		$this->db->from('admin as A');
		$this->db->join('roles as R', 'A.role_id = R.id');
		$this->db->order_by('A.id', 'desc');
		$this->db->where('R.name!=', "Super Admin");
		return $this->db->get()->result_array();
	}
}

/* End of file .php */
