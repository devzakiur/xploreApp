<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends MY_Model {

    public function total_pay()
    {
        $this->db->select('sum(P.pay) as total_pay,sum(P.discount) as total_discount');
        $this->db->from('payment as P');
        $this->db->where(array("running_session" => $this->running_session));
        return $this->db->get()->row_array();
    }
    public function total_due()
    {
        $this->db->select('sum(CD.course_fee) as total_course_fee');
        $this->db->from('course_details as CD');
        $this->db->where(array("running_session" => $this->running_session));
        $total_course_fee=$this->db->get()->row_array()['total_course_fee'];
        $total_pay=$this->total_pay();
        return $total_course_fee-$total_pay['total_discount']-$total_pay['total_pay'];
    }
    public function total_student_by_session()
    {
        $this->db->select('COUNT(SE.student_id) as total_student,S.name as session_name');
        $this->db->from('student_enrollment as SE');
        $this->db->join('session as S', 'SE.running_session = S.id');
        $this->db->group_by('SE.running_session');
        $result= $this->db->get()->result_array();
        $data=array();
        if(isset($result))
        {
            foreach ($result as $key => $value) {
                $data[$key]['name']=$value['session_name'];
                $data[$key]['y']=$value['total_student'];
            }
        }
        return $data;
    }
    public function total_payment_by_session()
    {
        $this->db->select('SUM(P.pay) as total_payment,S.name as session_name');
        $this->db->from('payment as P');
        $this->db->join('session as S', 'P.running_session = S.id');
        $this->db->group_by('P.running_session');
        $result= $this->db->get()->result_array();
        $data=array();
        if(isset($result))
        {
            foreach ($result as $key => $value) {
                $data[$key]['name']=$value['session_name'];
                $data[$key]['y']=$value['total_payment'];
            }
        }
        return $data;
    }

}

/* End of file Dashboard_model.php */
