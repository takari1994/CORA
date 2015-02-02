<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Msettings extends CI_Model {
    public function get_set_gen() {
        $query = $this->db->get('tcp_set_gen');
        return ($query ? $query->result():null);
    }
    
    public function update_set_gen($data) {
        $query = $this->db->update('tcp_set_gen',$data);
        return ($query ? true:false);
    }
    
    public function get_set_acc() {
        $query = $this->db->get('tcp_set_acc');
        return ($query ? $query->result():null);
    }
    
    public function update_set_acc($data) {
        $query = $this->db->update('tcp_set_acc',$data);
        return ($query ? true:false);
    }
    
    public function get_set_mail() {
        $query = $this->db->get('tcp_set_mail');
        return ($query ? $query->result():null);
    }
    
    public function update_set_mail($data) {
        $query = $this->db->update('tcp_set_mail',$data);
        return ($query ? true:false);
    }
}