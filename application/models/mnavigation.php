<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Mnavigation extends CI_Model {
    public function get_navs($id=null) {
        $this->db->select('*');
        $this->db->from('tcp_nav');
        if(null != $id) { $this->db->where(array('nav_id'=>$id)); }
        $query = $this->db->get();
        return ($query ? $query->result():null);
    }
    
    public function get_nav_li($id) {
        $this->db->select('*');
        $this->db->from('tcp_nav_li');
        $this->db->where(array('nav_id'=>$id));
        $this->db->order_by('position','asc');
        $query = $this->db->get();
        return ($query ? $query->result():null);
    }
    
    public function save_nav($desc) {
        $data = array('description'=>$desc);
        $query = $this->db->insert('tcp_nav',$data);
        $nav_id = $this->db->insert_id();
        return ($query ? $nav_id:null);
    }
    
    public function save_nav_li($navid,$label,$url,$pos) {
        $data = array('nav_id'=>$navid,'label'=>$label,'url'=>$url,'position'=>$pos);
        $query = $this->db->insert('tcp_nav_li',$data);
        $nav_li_id = $this->db->insert_id();
        return ($query ? $nav_li_id:null);
    }
    
    public function delete_nav($id) {
        $return_value = 0;
        $this->db->where(array('nav_id'=>$id));
        $query = $this->db->get('tcp_nav');
        $result = $query->result();
        if(0 == is_nav_wid($id) AND 0 == $result[0]->status) {
            $query = $this->db->delete('tcp_nav',array('nav_id'=>$id));
            $query2 = $this->db->delete('tcp_nav_li',array('nav_id'=>$id));
            if($query AND $query2) { $return_value = 1; }
        } else {
            $return_value = 2;
        } return $return_value;
    }
    
    public function delete_nav_li($id) {
        $query = $this->db->delete('tcp_nav_li',array('nav_li_id'=>$id));
        return ($query ? true:false);
    }
    
    //import
    
    public function sort_nav_li($navid) {
        $links = $this->get_nav_li($navid);
        $count = 1;
        foreach($links as $link) {
            if($count != $link->position) {
                $this->db->where(array('nav_li_id'=>$link->nav_li_id));
                $query = $this->db->update('tcp_nav_li',array('position'=>$count));
            }
            $count++;
        }
    }
    
    public function switch_nav_li_pos($old_pos,$new_pos) {
        $old_pos = mysql_real_escape_string($old_pos); mysql_real_escape_string($new_pos);
        $str = "UPDATE tcp_nav_li SET position = if(position = $old_pos, $new_pos, $old_pos) WHERE position IN ($old_pos, $new_pos)";
        $query = $this->db->query($str);
        return ($query ? true:false);
    }
    
    public function change_nav_li_label($nav_li_id,$label) {
        $data = array('label'=>$label);
        $this->db->where(array('nav_li_id'=>$nav_li_id));
        $query = $this->db->update('tcp_nav_li',$data);
        return ($query ? true:false);
    }
    
    public function change_nav_li_url($nav_li_id,$url) {
        $data = array('url'=>$url);
        $this->db->where(array('nav_li_id'=>$nav_li_id));
        $query = $this->db->update('tcp_nav_li',$data);
        return ($query ? true:false);
    }
}