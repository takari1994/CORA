<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_widgets')) {
    function get_widgets($parent)
    {
        $return_value = null;
        $parent = mysql_real_escape_string($parent);
        
        $str = "SELECT `wid_used_id`,`tcp_wid`.`wid_id` AS `wid_id`,`tcp_wid`.`desc` AS `desc`,`title`,`parent`,`position`,`child_tbl`,`page` FROM `tcp_wid`,`tcp_wid_used` WHERE `parent`='$parent' AND `tcp_wid`.`wid_id`=`tcp_wid_used`.`wid_id` ORDER BY `position` ASC";
        $query = mysql_query($str);
        
        if(0 < mysql_num_rows($query)) {
            $widgets = array();
            $counter = 0;
            while($read = mysql_fetch_assoc($query)) {
                $widgets[$counter] = array('wuid'=>$read['wid_used_id'],'type'=>$read['wid_id'],'desc'=>$read['desc'],'title'=>$read['title'],'parent'=>$read['parent'],'position'=>$read['position'],'child_tbl'=>$read['child_tbl'],'page'=>$read['page']);
                $counter++;
            }
            
            $return_value = $widgets;
        }
        
        return $return_value;
    }   
}

if ( ! function_exists('get_widget_extra')) {
    function get_widget_extra($type,$wuid) {
        $return_value = null;
        $type = mysql_real_escape_string($type); $wuid = mysql_real_escape_string($wuid);
        $get_xtbl = mysql_query("SELECT `child_tbl` FROM `tcp_wid` WHERE `wid_id`=$type");
        
        if(0 < mysql_num_rows($get_xtbl)) {
            $read = mysql_fetch_assoc($get_xtbl); $xtbl = $read['child_tbl'];
            $str = "SELECT * FROM `$xtbl` WHERE `wid_used_id`=$wuid";
            
            $query = mysql_query($str);
            
            if(0 < mysql_num_rows($query)) { $return_value = mysql_fetch_assoc($query); }
        }
        
        return $return_value;
    }
}

if ( ! function_exists('get_layout_wid_areas')) {
    function get_layout_wid_areas($layout) {
        $return_value = null;
        $dir = APP_PATH.'/views/layouts/'.$layout.'/wid_areas.php';
        if(file_exists($dir)) {
            require($dir);
            $return_value = $wid_areas;
        }
        return $return_value;
    }
}