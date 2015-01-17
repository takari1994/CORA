<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Madmin extends CI_Model{
    public function authenticate($data) {
        $this->db->where($data);
        $query = $this->db->get('tcp_set_adm');
        
        return (0 < $query->num_rows() ? true:false);
    }
    
    public function get_admin_info($cond) {
        $this->db->where($cond);
        $query = $this->db->get('tcp_set_adm');
        return ($query ? $query->result():null);
    }
    
    public function update($data) {
        $query = $this->db->update('tcp_set_adm',$data);
        return ($query ? true:false);
    }
}
