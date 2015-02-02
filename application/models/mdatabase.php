<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Mdatabase extends CI_Model {
    public function search($tbl,$col,$query,$index=null,$pp=null,$logic_op='AND',$count=null) {
        $select = "*";
        
        if(true == $count AND (($tbl == 'item_db' AND !$this->db->table_exists('item_db2')) OR ($tbl == 'mob_db' AND !$this->db->table_exists('mob_db2'))))
            $select = "COUNT(*) AS rows";
        
        if('item_db' == $tbl and $this->db->table_exists('item_db_re'))
            $tbl = 'item_db_re';
        else if('mob_db' == $tbl AND $this->db->table_exists('mob_db_re'))
            $tbl = 'mob_db_re';
        
        $qstr = "SELECT $select FROM "; $where = null; $limit = null;
        
        $qstr .= "(`$tbl`)";
        
        $queries = explode(' ', $query);
        
        if(0 < count($queries)) {
            foreach($queries as $i => $q) {
                if($i == 0)
                    $where .= " WHERE `$col` LIKE '%".$this->db->escape_like_str($q)."%'";
                else if($i > 0 AND $logic_op == 'AND')
                    $where .= " AND `$col` LIKE '%".$this->db->escape_like_str($q)."%'";
                else if($i > 0 AND $logic_op == 'OR')
                    $where .= " OR `$col` LIKE '%".$this->db->escape_like_str($q)."%'";
            }
        }
        
        $qstr .= $where;
        
        if(null !== $index AND null !== $pp) { $limit = " LIMIT ".$this->db->escape($index).", ".$this->db->escape($pp); }
        
        if(null != $count AND true == $count)
            $selectB = "COUNT(*) AS rows";
        else
            $selectB = "*";
        
        if(('item_db' == $tbl OR 'item_db_re' == $tbl) AND $this->db->table_exists('item_db2')) {
            $qstr = "SELECT $selectB FROM (SELECT $select FROM (`item_db2`)$where UNION $qstr) i $limit";
        } else if(('item_db' == $tbl OR 'item_db_re' == $tbl) AND !$this->db->table_exists('item_db2')) {
            $qstr .= $limit;
        } else if(('mob_db' == $tbl OR 'mob_db_re' == $tbl) AND $this->db->table_exists('mob_db2')) {
            $qstr = "SELECT $selectB FROM (SELECT $select FROM (`mob_db2`)$where UNION $qstr) i $limit";
        } else if(('mob_db' == $tbl OR 'mob_db_re' == $tbl) AND !$this->db->table_exists('mob_db2')) {
            $qstr .= $limit;
        }
        
        if(null != $count AND true == $count) {
            $query = $this->db->query($qstr);
            $query = $query->result();
            $query = $query[0]->rows;
            //echo $this->db->last_query();die();
            return (0 < $query ? $query:null);
        } else {
            $query = $this->db->query($qstr);
            //echo $this->db->last_query();die();
            return ($query ? $query->result():null);
        }
    }
    
    public function get_item_info($id) {
        if($this->db->table_exists('item_db_re'))
            $tbl = 'item_db_re';
        else
            $tbl = 'item_db';
        
        $this->db->where('id',$id);
        
        if($this->db->table_exists('item_db2')) {
            $query = $this->db->get('item_db2');
            if(0 >= $query->num_rows()) {
                $this->db->where('id',$id);
                $query = $this->db->get($tbl);
            }
        } else {
            $query = $this->db->get($tbl);
        }
        
        return ($query ? $query->result():null);
    }
}
