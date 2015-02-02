<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Mpost extends CI_Model {
    public function get_posts($postid=null,$event=false,$index=null,$pp=null,$cond=null,$count=null) {
        $return_value = null;
        if(true != $event)
            $this->db->select('tcp_post.post_id,title,content,author,disp_name as userid,date,type');
        else
            $this->db->select('tcp_post.post_id,title,content,author,disp_name as userid,date,type,post_event_id,start,end');
        
        $this->db->from('tcp_post');
        $this->db->join('tcp_set_adm','tcp_set_adm.admin_id=tcp_post.author');
        if(true == $event) { $this->db->join('tcp_post_event','tcp_post_event.post_id=tcp_post.post_id'); }
        $this->db->order_by('date','desc');
        if(null !== $index AND null !== $pp) { $this->db->limit($pp,$index); }
        
        if(null != $postid) { $this->db->where(array('tcp_post.post_id'=>$postid)); }
        if(null != $cond) { $this->db->where($cond); }
        
        if(null != $count AND true == $count) {
            $query = $this->db->count_all_results();
            $return_value = $query;
        } else {
            $query = $this->db->get();
            if(0 < $query->num_rows()) { $return_value = $query->result(); }
        }
        
        return $return_value;
    }
    
    public function save_post($id=null,$title,$content,$author,$date,$type,$event=null) {
        $return_value = null;
        
        if($type == 1):
            if(null == $id) {
                $data = array('title' => $title,'content' => $content,'author' => $author,'date' => $date,'type'=>1);
                $query = $this->db->insert('tcp_post',$data);
                $post_id = $this->db->insert_id();
            } else {
                $post_id = $id;
                $data = array('title' => $title,'content' => $content,'author' => $author,'type'=>1);
                $this->db->where('post_id',$id);
                $query = $this->db->update('tcp_post',$data);
            }
            $return_value = ($query ? $post_id:null);
        elseif($type == 2):
            if(null != $event['start'] AND null != $event['end']) {
                if(null == $id) {
                    $data = array('title' => $title,'content' => $content,'author' => $author,'date' => $date,'type'=>2);
                    $query = $this->db->insert('tcp_post',$data);
                } else {
                    $data = array('title' => $title,'content' => $content,'author' => $author,'type'=>2);
                    $this->db->where('post_id',$id);
                    $query = $this->db->update('tcp_post',$data);
                }
                if(null == $id) { $post_id = $this->db->insert_id(); } else { $post_id = $id; }
                $data2 = array('post_id'=>$post_id,'start'=>$event['start'],'end'=>$event['end']);
                if(null == $id)
                    $query2 = $this->db->insert('tcp_post_event',$data2);
                else {
                    $this->db->where('post_id',$id);
                    $query2 = $this->db->update('tcp_post_event',$data2);                    
                }
                $return_value = ($query && $query2 ? $post_id:null);
            }
        endif;
        
        return $return_value;
    }
    
    public function delete_post($id) {
        $return_value = false;
        
        $query = $this->db->delete('tcp_post',array('post_id'=>$id));
        
        $this->db->select('post_id');
        $event = $this->db->get('tcp_post_event');
        
        if(0 < $event->num_rows()) {
            
            $query2 = $this->db->delete('tcp_post_event',array('post_id'=>$id));
            
            if($query AND $query2) {
                $return_value = true;
            }
            
        } else if($query) {
            $return_value = true;
        }
        
        return $return_value;
    }
}
