<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Mdatabase extends CI_Model {
    public function search($tbl,$col,$query,$index=null,$pp=null,$logic_op='AND') {
        $queries = explode(' ', $query);
        
        foreach($queries as $i => $q) {
            if($logic_op == 'AND')
                $this->db->like($col,$q);
            else if($logic_op == 'OR' AND $i == 0)
                $this->db->like($col,$q);
            else if($logic_op == 'OR' AND $i > 0)
                $this->db->or_like($col,$q);
        }
        
        if(null !== $index AND null !== $pp) { $this->db->limit($pp,$index); }
        
        $query = $this->db->get($tbl);
        
        return ($query ? $query->result():null);
    }
    
    public function get_item_info($id) {
        $this->db->where('id',$id);
        $query = $this->db->get('item_db');
        
        return ($query ? $query->result():null);
    }
}
