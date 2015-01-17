<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('get_navs')) {
    function get_navs($nav_id=null) {
        $return_value = null;
        $str = "SELECT * FROM `tcp_nav`";
        if(null != $nav_id) {
            $nav_id = mysql_real_escape_string($nav_id);
            $str .=   " WHERE `nav_id`=$nav_id";   
        }
        $str .= " ORDER BY `nav_id` ASC";
        $query = mysql_query($str);
        
        if(0 < mysql_num_rows($query)) {
            $navs = array();
            $counter = 0;
            
            while($read = mysql_fetch_assoc($query)) {
                $navs[$counter] = $read;
                $counter++;
            }
            
            $return_value = $navs;
        }
        
        return $return_value;
    }
}

if ( ! function_exists('get_nav_links')) {
    function get_nav_links($nav_id) {
        $return_value = null;
        $nav_id = mysql_real_escape_string($nav_id);
        $str = "SELECT * FROM `tcp_nav_li` WHERE `nav_id`=$nav_id ORDER BY `position` ASC";
        $query = mysql_query($str);
        
        if(0 < mysql_num_rows($query)) {
            $links = array();
            $counter = 0;
            
            while($read = mysql_fetch_assoc($query)) {
                $links[$counter] = $read;
                $counter++;
            }
            
            $return_value = $links;
        }
        
        return $return_value;
    }
}

if ( ! function_exists('get_wid_nav')) {
    function get_wid_nav($nav_id) {
        $return_value = null;
        $nav_id = mysql_real_escape_string($nav_id);
        $str = "SELECT * FROM `tcp_nav_li` WHERE `nav_id`=$nav_id ORDER BY `position` ASC";
        $query = mysql_query($str);
        
        if(0 < mysql_num_rows($query)) {
            $links = array();
            $counter = 0;
            
            while($read = mysql_fetch_assoc($query)) {
                $links[$counter] = $read;
                $counter++;
            }
            
            $return_value = $links;
        }
        
        return $return_value;
    }
}

if ( ! function_exists('is_nav_wid')) {
    function is_nav_wid($nav_id) {
        $return_value = false;
        $nav_id = mysql_real_escape_string($nav_id);
        $str = "SELECT `wid_nav_id` FROM `tcp_wid_nav` WHERE `nav_id`=$nav_id";
        $query = mysql_query($str);
        
        if(0 < mysql_num_rows($query))
            $return_value = true;
            
        return $return_value;
    }
}