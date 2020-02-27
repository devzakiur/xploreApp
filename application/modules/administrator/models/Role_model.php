<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Role_model extends MY_Model {

    public function get_permission_list($role_id)
    {
        $this->db->select('PG.id,PG.name,PG.short_code');
        $this->db->from('permission_group as PG');
        $this->db->order_by('PG.name', 'ASC');
        $result=$this->db->get()->result_array();
        $permission=array();
        if(!empty($result)){
            foreach ($result as $key => $value) {
                $permission[]=array(
                    "group_name"=>$value['name'],
                    "group_code"=>$value['short_code'],
                    "permission"=>$this->get_permission($value['id'],$role_id),
                );
            }
        }
        return $permission;
    }
    public function get_permission($id,$role_id)
    {
        $this->db->select('PC.*,PC.id as pc_id,RP.*,RP.id as rp_id,IFNULL(RP.id,0)');
        $this->db->from('permission_category as PC');
        $this->db->join('roles_permissions as RP', 'PC.id = RP.perm_cat_id and RP.role_id='.$role_id.'', 'left');
        $this->db->where('PC.perm_group_id', $id);
        // if(!is_super_admin()){
        // }
        $this->db->where_not_in('PC.short_code', "module");
        return $this->db->get()->result_array();
        
        
    }
    public function getInsertBatch($role_id, $to_be_insert = array(), $to_be_update = array(), $to_be_delete = array()) {
        $this->db->trans_start();
        $this->db->trans_strict(FALSE);
        if (!empty($to_be_insert) && is_array($to_be_insert)) {
           $this->db->insert_batch('roles_permissions', $to_be_insert);
        }
        if (!empty($to_be_update)) {

            $this->db->update_batch('roles_permissions', $to_be_update, 'id');
        }


// # Updating data
        if (!empty($to_be_delete)) {
            $this->db->where('role_id', $role_id);
            $this->db->where_in('id', $to_be_delete);
            $this->db->delete('roles_permissions');
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

/* End of file Role_model.php */
