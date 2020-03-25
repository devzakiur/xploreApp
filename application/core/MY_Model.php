<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class MY_Model extends CI_Model {

    function __construct() {

        parent::__construct();
    }

    // insert new data

    function insert($table_name, $data_array) {

        $this->db->insert($table_name, $data_array);

        return $this->db->insert_id();
    }

    // insert new data

    function insert_batch($table_name, $data_array) {

        $this->db->insert_batch($table_name, $data_array);

        return $this->db->insert_id();
    }

    // update data by index

    function update($table_name, $data_array, $index_array) {

        $this->db->update($table_name, $data_array, $index_array);

        return $this->db->affected_rows();
    }

    // delete data by index

    function delete($table_name, $index_array) {
        $this->db->delete($table_name, $index_array);

        return $this->db->affected_rows();
    }
    public function exits_check($table_name,$index_array,$id=null)
    {
        if ($id) {
            $this->db->where_not_in('id', $id);
        }
        $this->db->where($index_array);
        return $this->db->get($table_name)->num_rows();
    }
    public function duplicate_check($table_name,$coloum_name,$value, $id = null ){

        if($id){
            $this->db->where_not_in('id', $id);
        }
        $this->db->where($coloum_name, $value);
        return $this->db->get($table_name)->num_rows();
    }
    public function get_menu()
    {
        $this->db->select('id,name,short_code,link');
        $this->db->from('permission_group');
        $this->db->order_by('position', 'asc');
        $result= $this->db->get()->result_array();
        $data=array();
        if(isset($result))
        {
            foreach($result as $key=>$value)
            {
                $data[$value['short_code']]['id']=$value['id'];
                $data[$value['short_code']]['name']=$value['name'];
                $data[$value['short_code']]['short_code']=$value['short_code'];
                $data[$value['short_code']]['link']=$value['link'];
                $data[$value['short_code']][$value['short_code']]=$this->get_submenu($value['short_code']);
            }
        }
        return $data;
    }
    public function get_submenu($menu_code)
    {
        $id=$this->get_single("permission_category",array("short_code"=>$menu_code),"perm_group_id")->perm_group_id;
        $this->db->select('id,name,short_code,link,icon');
        $this->db->from('permission_category');
        $this->db->order_by('position', 'asc');
        $this->db->where('perm_group_id', $id);
        $this->db->where('submenu', 1);
        $this->db->where('subparent', 0);
        if(!is_super_admin()){
            $this->db->where_not_in('short_code', "module");
        }
        $result= $this->db->get()->result_array();
        $data=array();
        if(isset($result))
        {
            foreach($result as $key=>$value)
            {
                $data[$value['short_code']]['id']=$value['id'];
                $data[$value['short_code']]['name']=$value['name'];
                $data[$value['short_code']]['short_code']=$value['short_code'];
                $data[$value['short_code']]['link']=$value['link'];
                $data[$value['short_code']]['sub_icon']=$value['icon'];
                $data[$value['short_code']][$value['short_code']]=$this->get_seceond_submenu($value['id']);
            }
        }
        return $data;
    }
    public function get_seceond_submenu($id)
    {
        $this->db->select('id,name,short_code,link,icon');
        $this->db->from('permission_category');
        $this->db->order_by('position', 'asc');
        $this->db->where('subparent', $id);
        $this->db->where('submenu', 1);
        return $this->db->get()->result_array();
    }
    public function get($table,$coloum=null,$order_coloum=null,$order_type=null)
    {
        if($coloum=='')
        {
            $this->db->select('*');
        }
        else
        {
            $this->db->select($coloum);
        }
        $this->db->from($table);
        if($order_coloum!='' && $order_type!=''){
            $this->db->order_by($order_coloum,$order_type);
        }
        return $this->db->get()->result_array();
    }
    public function get_list($table_name, $index_array, $columns = null, $limit = null, $offset = 0, $order_field = null, $order_type = null) {

        if ($columns)
            $this->db->select($columns);

        if ($limit)
            $this->db->limit($limit, $offset);

        if ($order_type) {
            $this->db->order_by($order_field, $order_type);
        } else {
            $this->db->order_by('id', 'DESC');
        }

        return $this->db->get_where($table_name, $index_array)->result_array();
    }

    // get data list by index order

    function get_list_order($table_name, $index_array, $order_array, $limit = null) {

        if ($limit) {

            $this->db->limit($limit);
        }

        if ($order_array) {

            $this->db->order_by($order_array['by'], $order_array['type']);
        } else {

            $this->db->order_by('id', 'desc');
        }

        return $this->db->get_where($table_name, $index_array)->result_array();
    }

    // get single data by index

    function get_single($table_name, $index_array=null, $columns = null) {

        if ($columns)
            $this->db->select($columns);

        $this->db->order_by('id', 'desc');
        $this->db->limit(1);
        $row = $this->db->get_where($table_name, $index_array)->row();

        return $row;
    }
    function get_last_row($table_name, $columns = null) {

        if ($columns)
            $this->db->select($columns);

        $this->db->order_by('id', 'desc');
        $this->db->limit(1);

        $row = $this->db->get($table_name)->row();

        return $row;
    }

    function get_single_random($table_name, $index_array, $columns = null) {

        if ($columns)
            $this->db->select($columns);

        $this->db->order_by('rand()');
        $this->db->limit(1);
        $row = $this->db->get_where($table_name, $index_array)->row();
        return $row;
    }

    // get number of rows in database

    function count_all($table_name, $index_array = null) {

        if ($index_array) {
            $this->db->where($index_array);
        }
        return $this->db->count_all_results($table_name);
    }
    public function get_table_fields($table) {

        return $this->db->list_fields($table);
    }
    public function create_user(){
        $this->load->library('Enc_lib');

        $data = array();
        $data['role_id']    = $this->input->post('role_id');
        $data['password']   = $this->enc_lib->passHashEnc($this->input->post('password'));
        $data['temp_password'] = base64_encode($this->input->post('password'));
        $data['username']      = $this->input->post('email');
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['status']     = 1; // by default would not be able to login
        $this->db->insert('admin', $data);
        return $this->db->insert_id();
    }
    public function get_custom_id($table, $prefix)
    {
        $max_id = '';
        $this->db->select_max('id');
        $max_id = $this->db->get($table)->row()->id;

        if(isset($max_id) && $max_id > 0)
        {
            $max_id = $max_id+1;
        }else{
            $max_id = 1;
        }

        return $prefix.str_pad($max_id,3,0,STR_PAD_LEFT);
    }
    public function trans_start()
    {
       return $this->db->trans_start();
    }
    public function trans_complete()
    {
       return $this->db->trans_complete();
    }
    public function trans_status()
    {
        if ($this->db->trans_status() === TRUE)
        {
            $this->db->trans_commit();
            return true;
        }else{
            $this->db->trans_rollback();
            return false;
        }
    }

}

?>
