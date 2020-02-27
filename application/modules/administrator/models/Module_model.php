<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Module_model extends MY_Model {

    public function get_all_module()
    {
        $this->db->select('PG.*,PG.name as group_name,PG.short_code');
        $this->db->from('permission_group as PG');
        $this->db->order_by('PG.name', 'ASC');
        $result=$this->db->get()->result_array();
        $category=array();
        if(!empty($result)){
            foreach ($result as $key => $value) {
                $category[$key]['group_id']=$value['id'];
                $category[$key]['is_active']=$value['is_active'];
                $category[$key]['group_name']=$value['group_name'];
                $category[$key]['short_code']=$value['short_code'];
                $category[$key]['category']=$this->module_category($value['id']);
            }
        }
        return $category;
    }
    public function module_category($group_id)
    {
        $this->db->select('*,id as cat_id,name as category_name,submenu');
        $this->db->from('permission_category');
        $this->db->order_by('name', 'ASC');
        $this->db->where('perm_group_id', $group_id);
        return $this->db->get()->result_array();
    }
    public function getInsertBatch($to_be_update = array()) {
        $this->db->trans_start();
        $this->db->trans_strict(FALSE);
        if (!empty($to_be_update)) {

            $this->db->update_batch('permission_category', $to_be_update, 'id');
        }
        $this->db->trans_complete();

        if ($this->db->trans_status() === FALSE) {

            $this->db->trans_rollback();
            return FALSE;
        } else {

            $this->db->trans_commit();
            return TRUE;
        }
    }





}

/* End of file Module_model.php */
