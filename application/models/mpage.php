<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Mpage extends CI_Model{
    public function get_pages($pageid=null,$index=null,$pp=null,$count=null) {
        $return_value = null;
        $this->db->select('page_id,title,content,author,disp_name as userid,date');
        $this->db->from('tcp_page');
        $this->db->join('tcp_set_adm','tcp_set_adm.admin_id=tcp_page.author');
        $this->db->order_by('date','desc');
        if(null !== $index AND null !== $pp) { $this->db->limit($pp,$index); }
        if(null != $pageid) { $this->db->where(array('tcp_page.page_id'=>$pageid)); }
        if(null != $count AND true == $count) {
            $query = $this->db->count_all_results();
            $return_value = $query;
        } else {
            $query = $this->db->get();
            if(0 < $query->num_rows()) { $return_value = $query->result(); }
        }
        
        return $return_value;
    }
    
    function save_page($id=null,$title,$content,$author,$date) {
        $return_value = false;
        
        if(null == $id) {
            $data = array('title'=>$title,'content'=>$content,'author'=>$author,'date'=>$date);
            $query = $this->db->insert('tcp_page',$data);
        } else {
            $data = array('title'=>$title,'content'=>$content,'author'=>$author);
            $this->db->where('page_id',$id);
            $query = $this->db->update('tcp_page',$data);
        }
        
        $return_value = ($query ? true:false);
        return $return_value;
    }
    
    public function delete_page($id) {
        $return_value = false;
        
        $query = $this->db->delete('tcp_page',array('page_id'=>$id));
        if($query) { $return_value = true; }
        
        return $return_value;
    }
}
