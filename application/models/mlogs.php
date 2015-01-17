<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Mlogs extends CI_Model {
    public function get_log_login($type=1,$cond=null,$index=null,$pp=null,$sort=null,$search=null) {
        if(1 == $type) {
            $curdb = $this->load->database('log',TRUE);
            $tbl   = 'loginlog';
            if(null == $sort)
                $sort = array('time','desc');
        }
        if(null != $cond){ $curdb->where($cond); }
        if(null != $search){ $curdb->like($search); }
        if(null !== $index && null !== $pp) { $curdb->limit($pp,$index); }
        $curdb->order_by($sort[0],$sort[1]);
        $query = $curdb->get($tbl);
        $this->db->close();
        return (0 < $query->num_rows()?$query->result():null);
    }
    
    public function get_log_chat($cond=null,$index=null,$pp=null,$sort=null,$search=null) {
        $curdb = $this->load->database('log',TRUE);
        $tbl   = 'chatlog';
        if(null == $sort)
            $sort = array('time','desc');
        if(null != $cond){ $curdb->where($cond); }
        if(null != $search){ $curdb->like($search); }
        if(null !== $index && null !== $pp) { $curdb->limit($pp,$index); }
        $curdb->order_by($sort[0],$sort[1]);
        $query = $curdb->get($tbl);
        $this->db->close();
        return (0 < $query->num_rows()?$query->result():null);
    }
    
    public function get_log_pick($cond=null,$index=null,$pp=null,$sort=null,$search=null) {
        $curdb = $this->load->database('log',TRUE);
        $tbl   = 'picklog';
        if(null == $sort)
            $sort = array('time','desc');
        if(null != $cond){ $curdb->where($cond); }
        if(null != $search){ $curdb->like($search); }
        if(null !== $index && null !== $pp) { $curdb->limit($pp,$index); }
        $curdb->order_by($sort[0],$sort[1]);
        $query = $curdb->get($tbl);
        $this->db->close();
        return (0 < $query->num_rows()?$query->result():null);
    }
    
    public function get_log_zeny($cond=null,$index=null,$pp=null,$sort=null,$search=null) {
        $curdb = $this->load->database('log',TRUE);
        $tbl   = 'zenylog';
        if(null == $sort)
            $sort = array('time','desc');
        if(null != $cond){ $curdb->where($cond); }
        if(null != $search){ $curdb->like($search); }
        if(null !== $index && null !== $pp) { $curdb->limit($pp,$index); }
        $curdb->order_by($sort[0],$sort[1]);
        $query = $curdb->get($tbl);
        $this->db->close();
        return (0 < $query->num_rows()?$query->result():null);
    }
    
    public function get_log_mvp($cond=null,$index=null,$pp=null,$sort=null,$search=null) {
        $curdb = $this->load->database('log',TRUE);
        $tbl   = 'mvplog';
        if(null == $sort)
            $sort = array('mvp_date','desc');
        if(null != $cond){ $curdb->where($cond); }
        if(null != $search){ $curdb->like($search); }
        if(null !== $index && null !== $pp) { $curdb->limit($pp,$index); }
        $curdb->order_by($sort[0],$sort[1]);
        $query = $curdb->get($tbl);
        $this->db->close();
        return (0 < $query->num_rows()?$query->result():null);
    }
    
    public function get_log_atcommand($cond=null,$index=null,$pp=null,$sort=null,$search=null) {
        $curdb = $this->load->database('log',TRUE);
        $tbl   = 'atcommandlog';
        if(null == $sort)
            $sort = array('atcommand_date','desc');
        if(null != $cond){ $curdb->where($cond); }
        if(null != $search){ $curdb->like($search); }
        if(null !== $index && null !== $pp) { $curdb->limit($pp,$index); }
        $curdb->order_by($sort[0],$sort[1]);
        $query = $curdb->get($tbl);
        $this->db->close();
        return (0 < $query->num_rows()?$query->result():null);
    }
    
    public function get_log_donate($cond=null,$index=null,$pp=null,$sort=null,$search=null) {
        $tbl   = 'tcp_donate_log';
        if(null == $sort)
            $sort = array('date','desc');
        if(null != $cond){ $this->db->where($cond); }
        if(null != $search){ $this->db->like($search); }
        if(null !== $index && null !== $pp) { $this->db->limit($pp,$index); }
        $this->db->order_by($sort[0],$sort[1]);
        $query = $this->db->get($tbl);
        return (0 < $query->num_rows()?$query->result():null);
    }
    
    public function get_log_vote($cond=null,$index=null,$pp=null,$sort=null,$search=null) {
        $tbl   = 'tcp_vote_log';
        if(null == $sort)
            $sort = array('date','desc');
        if(null != $cond){ $this->db->where($cond); }
        if(null != $search){ $this->db->like($search); }
        if(null !== $index && null !== $pp) { $this->db->limit($pp,$index); }
        $this->db->order_by($sort[0],$sort[1]);
        $query = $this->db->get($tbl);
        return (0 < $query->num_rows()?$query->result():null);
    }
    
    public function get_log_shop($cond=null,$index=null,$pp=null,$sort=null,$search=null) {
        $tbl   = 'tcp_order_items';
        
        $this->db->join('tcp_order','tcp_order.order_id=tcp_order_items.order_id');
        
        if(null == $sort)
            $sort = array('date','desc');
        if(null !== $index && null !== $pp) { $this->db->limit($pp,$index); }
        if(null != $cond){ $this->db->where($cond); }
        if(null != $search){ $this->db->like($search); }
        $this->db->order_by($sort[0],$sort[1]);
        $query = $this->db->get($tbl);
        return (0 < $query->num_rows()?$query->result():null);
    }
    
    public function get_log_tcp($type=null,$cond=null,$index=null,$pp=null,$sort=null,$search=null) {
        $tbl = 'tcp_logs';
        
        if(null == $sort)
            $sort = array('date','desc');
        if(null != $type){ $this->db->where_in('type',$type); }
        if(null != $cond){ $this->db->where($cond); }
        if(null != $search){ $this->db->or_like($search); }
        if(null !== $index && null !== $pp) { $this->db->limit($pp,$index); }
        $this->db->order_by($sort[0],$sort[1]);
        $query = $this->db->get($tbl);
        //echo $this->db->last_query(); die();
        return (0 < $query->num_rows()?$query->result():null);
    }
    
    public function add_log_tcp($data) {
        $query = $this->db->insert('tcp_logs',$data);
        return ($query?true:false);
    }
}