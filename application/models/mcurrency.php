<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Mcurrency extends CI_Model {
    public function get_v4p_links($v4p_id=null) {
        if(null != $v4p_id)
            $this->db->where('v4p_id',$v4p_id);
            
        $query = $this->db->get('tcp_v4p');
        return ($query ? $query->result():null);
    }
    
    public function add_v4p_link($label,$url,$value) {
        $data = array('label'=>$label,'url'=>$url,'value'=>$value);
        $query = $this->db->insert('tcp_v4p',$data);
        return ($query ? true:false);
    }
    
    public function update_v4p($id,$label,$url,$value,$cooldown,$image=null) {
        $this->db->where('v4p_id',$id);
        $data =  array('label'=>$label,'url'=>$url,'value'=>$value,'cooldown'=>$cooldown,'image'=>$image);
        $query = $this->db->update('tcp_v4p',$data);
        return ($query ? true:false);
    }
    
    public function delete_v4p($id) {
        $this->db->where('v4p_id',$id);
        $query = $this->db->delete('tcp_v4p');
        return ($query ? true:false);
    }
    
    public function update_log($v4p_id,$account_id,$reward) {
        $this->db->set('vote_points', 'vote_points + '.(int)$reward, FALSE);
        $this->db->where('account_id',$account_id);
        $reward = $this->db->update('tcp_profile');
        
        $this->db->where(array('v4p_id'=>$v4p_id,'account_id'=>$account_id));
        $log_exist = $this->db->get('tcp_vote_log');
        $last_vote = strtotime(date("Y-m-d H:i:s"));
        $data =      array('last_vote'=>$last_vote);
            
        if(0 < $log_exist->num_rows()) {
            $this->db->where(array('v4p_id'=>$v4p_id,'account_id'=>$account_id));
            $update_log = $this->db->update('tcp_vote_log',$data);
        } else {
            $data['account_id'] = $account_id;
            $data['v4p_id'] =     $v4p_id;
            $update_log = $this->db->insert('tcp_vote_log',$data);
        }
        
        return ($reward AND $update_log ? true:false);
    }
    
    public function get_donate_amounts($donate_id=null) {
        if(null != $donate_id)
            $this->db->where('donate_id',$donate_id);
            
        $query = $this->db->get('tcp_donate');
        return ($query ? $query->result():null);
    }
    
    public function add_donate_amount($amount,$value) {
        $data = array('amount'=>$amount,'value'=>$value);
        $query = $this->db->insert('tcp_donate',$data);
        return ($query ? true:false);
    }
    
    public function update_donate($id,$amount,$value) {
        $this->db->where('donate_id',$id);
        $data =  array('amount'=>$amount,'value'=>$value);
        $query = $this->db->update('tcp_donate',$data);
        return ($query ? true:false);
    }
    
    public function delete_donate($id) {
        $this->db->where('donate_id',$id);
        $query = $this->db->delete('tcp_donate');
        return ($query ? true:false);
    }
    
    public function update_donate_log($account_id,$amount,$currency,$date,$ip,$reward) {
        $this->db->set('donate_points', 'donate_points + '.(int)$reward, FALSE);
        $this->db->where('account_id',$account_id);
        $reward =     $this->db->update('tcp_profile');
        $data =       array('account_id'=>$account_id,'amount'=>$amount,'currency'=>$currency,'date'=>$date,'ip'=>$ip);
        $insert_log = $this->db->insert('tcp_donate_log',$data);
        
        return ($reward AND $insert_log ? true:false);
    }
    
    public function get_set_cur() {
        $query = $this->db->get('tcp_set_cur');
        return ($query ? $query->result():null);
    }
    
    public function update_set_cur($use_sandbox,$pp_merch_id,$pp_org_name,$pp_currency,$return_url,$cancel_url,$status) {
        $data = array(
            'use_sandbox' => $use_sandbox,
            'pp_merch_id' => $pp_merch_id,
            'pp_org_name' => $pp_org_name,
            'pp_currency' => $pp_currency,
            'return_url'  => $return_url,
            'cancel_url'  => $cancel_url,
            'status'      => $status
        );
        
        $query = $this->db->update('tcp_set_cur',$data);
        
        return($query ? true:false);
    }
}