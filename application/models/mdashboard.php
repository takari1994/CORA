<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Mdashboard extends CI_Model {
    public function query($q,$bind=null) {
        $q = mysql_real_escape_string($q);
        if(null == $bind)
            $query = $this->db->query($q);
        else
            $query = $this->db->query($q,$bind);
        return ($query ? $query->result():null );
    }
    public function get_dash_nav() {
        $return_value = null;
        $query = $this->db->get('tcp_dash_li');
        if(0 < $query->num_rows()) { $return_value = $query->result(); }
        return $return_value;
    }
}