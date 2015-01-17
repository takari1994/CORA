<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Mwidget extends CI_Model {
    public function get_widget_list($wid_id=null) {
        if(null != $wid_id)
            $this->db->where(array('wid_id'=>$wid_id));
        
        $this->db->order_by("desc","asc");
        $query = $this->db->get('tcp_wid');
        return ($query ? $query->result():null);
    }
    
    public function add_widget($wid_id,$title,$parent,$pos,$xtbl=null) {
        $data =  array('wid_id'=>$wid_id,'title'=>$title,'parent'=>$parent,'position'=>$pos);
        $query = $this->db->insert('tcp_wid_used',$data);
        $wuid =  $this->db->insert_id();
        
        if(null != $xtbl) {
            $xdata['wid_used_id'] = $wuid;
            $queryB = $this->db->insert($xtbl,$xdata);
        }
        
        return ($query ? true:false);
    }
    
    public function update_widget($wuid,$title,$xtbl=null,$data=null) {
        $this->db->where('wid_used_id',$wuid);
        $queryA = $this->db->update('tcp_wid_used',array('title'=>$title));
        
        if(null != $xtbl AND null != $data) {
            $this->db->where('wid_used_id',$wuid);
            $xdata =  $this->xdata_generator($xtbl,$data);
            $queryB = $this->db->update($xtbl,$xdata);
            
            if($queryA AND $queryB) { return true; } else { return false; }
        } else {
            if($queryA) { return true; } else { return false; }
        }
    }
    
    public function switch_widget_pos($parent,$old_pos,$new_pos) {
        $parent = mysql_real_escape_string($parent); $old_pos = mysql_real_escape_string($old_pos); $new_pos = mysql_real_escape_string($new_pos);
        $str = "UPDATE tcp_wid_used SET position = if(position = $old_pos, $new_pos, $old_pos) WHERE parent='$parent' AND position IN ($old_pos, $new_pos)";
        $query = $this->db->query($str);
        return ($query ? true:false);
    }
    
    public function delete_widget($wuid,$tbl=null) {
        $tables = array('tcp_wid_used');
        $this->db->where('wid_used_id',$wuid);
        if(null != $tbl)
            $tables[] = $tbl;
        $query = $this->db->delete($tables);
        return true;
    }
    
    public function sort_widgets($parent) {
        $widgets = get_widgets($parent);
        $count = 1;
        if(1 < count($widgets)) {
            foreach($widgets as $wid) {
                if($count != $wid['position']) {
                    $this->db->where(array('wid_used_id'=>$wid['wuid']));
                    $query = $this->db->update('tcp_wid_used',array('position'=>$count));
                }
                $count++;
            }
        }
        return true;
    }
    
    public function get_wid_used($wuid) {
        $this->db->where('wid_used_id',$wuid);
        $query = $this->db->get('tcp_wid_used');
        return ($query ? $query->result():null);
    }
    
    public function get_wid_used_info($tbl,$wuid) {
        $this->db->where('wid_used_id',$wuid);
        $query = $this->db->get($tbl);
        return ($query ? $query->result():null);
    }
    
    public function xdata_generator($xtbl,$opt) {
        $fields = $this->db->list_fields($xtbl);
        $xdata = array();
        for($x=2,$y=0;$x<count($fields);$x++,$y++) {
            $field =            $fields[$x];
            $xdata[$field] =    $opt[$y];
        }
        return $xdata;
    }
}