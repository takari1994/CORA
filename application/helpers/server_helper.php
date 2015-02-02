<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

if( ! function_exists('get_layout')) {
    function get_layout() {
        $return_value = null;
        
        $str   = "SELECT `theme` FROM `tcp_set_gen`";
        $query = mysql_query($str);
        $read  = mysql_fetch_assoc($query);
        
        return $read['theme'];
    }
}

if ( ! function_exists('ping_server')) {
    function ping_server($ip,$port) {
        $ping = @fsockopen($ip,$port,$errno,$errstr,0.4);
        if($ping)
            return 1;
        else
            return 0;
    }
}

if ( ! function_exists('parse_msgcode')) {
    function parse_msgcode($code,$specmsg=null) {
        require(APP_PATH."/views/etc/msgcode.php");   
        
        if($code >= 100 AND $code <= 199) {
            $msg = '<div class="alert alert-success alert-dismissable" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$msg.'</div>';
        } else if($code >= 200 AND $code <= 299) {
            $msg = '<div class="alert alert-info alert-dismissable" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$msg.'</div>';
        } else if($code >= 300 AND $code <= 399) {
            $msg = '<div class="alert alert-warning alert-dismissable" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$msg.'</div>';
        } else if($code >= 400 AND $code <= 499) {
            $msg = '<div class="alert alert-danger alert-dismissable" role="alert"><button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>'.$msg.'</div>';
        }
        
        return $msg;
    }
}

if ( ! function_exists('class_name')) {
    function class_name($class_id=-1) {
        require(APP_PATH."/views/etc/joblist.php");        
        return $class_name;
    }
}

if ( ! function_exists('breadcrumb')) {
    function breadcrumb($crumbs,$active) {
        echo '<ol class="breadcrumb">';
        $prevurl = base_url();
        foreach($crumbs as $crumb):
        if(0 < strlen($crumb['uri'])) { $prevurl .= $crumb['uri'].'/'; }
        echo '<li><a href="'.$prevurl.'">'.$crumb['desc'].'</a></li>';
        endforeach;
        echo '<li class="active">'.$active.'</li>';
        echo '</ol>';
    }
}

if ( ! function_exists('mail_values')) {
    function mail_values($attr,$data=null) {
        require(APP_PATH."/views/etc/mailvalues.php");
        
        return $value;
    }
}

if ( ! function_exists('in_array_r')) {
    function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
                return true;
            }
        }
        
        return false;
    }
}

if ( ! function_exists('vote_avail_check')) {
    function vote_avail_check($id,$user,$cooldown) {
        $id =           mysql_real_escape_string($id);
        $user =         mysql_real_escape_string($user);
        $return_value = array('is_avail'=>true,'next_vote'=>'-');
        
        $str = "SELECT * FROM `tcp_vote_log` WHERE `account_id`=$user AND `v4p_id`=$id";
        $query = mysql_query($str);
        
        if(0 < mysql_num_rows($query)) {
            $read =         mysql_fetch_assoc($query);
            $last_vote =    $read['last_vote'];
            $next_vote =    $last_vote+($cooldown*60);
            $current_time = strtotime(date("Y-m-d H:i:s"));
            
            if($next_vote < $current_time)
                $return_value['is_avail'] = true;
            else
                $return_value['is_avail'] = false;
                
            $return_value['next_vote'] = $next_vote;
        }
        
        return $return_value;
    }
}

if ( ! function_exists('get_vote_links')) {
    function get_vote_links($id=null) {
        $return_value = null;
        $str =          "SELECT * FROM `tcp_v4p`";
        if(null != $id) {
            $id = mysql_real_escape_string($id);
            $str .= " WHERE `v4p_id`=$id";
        }
        $query = mysql_query($str);
        
        if(0 < mysql_num_rows($query)) {
            $links = array();
            $count = 0;
            while($read = mysql_fetch_assoc($query)) {
                $links[$count] = $read;
                $count++;
            }
            $return_value = $links;
        }
        
        return $return_value;
    }
}

if ( ! function_exists('pagination')) {
    function pagination($url,$total,$rpp,$lpp,$curpage,$align) {
        
        $url .= '?';
        
        if(isset($_GET)){
            foreach($_GET as $i => $v) {
                if("page" != $i AND "msgcode" != $i)
                    $url .= $i.'='.$v.'&';
            }
        }
        
        if(0 == $total%$rpp)
            $tp = $total/$rpp;
        else
            $tp = intval($total/$rpp)+1;
            
        $test_sp = (0 == $lpp%2 ? $curpage-($lpp/2):$curpage-(intval($lpp/2)));
        
        if(0 >= $test_sp)
            $sp = 1;
        else if($lpp <= $tp-$test_sp)
            $sp = $test_sp;
        else 
            $sp = ($tp-($lpp-1)>0 ? $tp-($lpp-1):1);
        
        echo '<div class="'.$align.'">';
        echo '<ul class="pagination">';
        
        if($curpage == 1)
            echo '<li class="disabled"><span>&laquo;</span></li>';
        else 
            echo '<li><a href="'.$url.'page=1">&laquo;</a></li>';
        
        for($x=1,$y=$sp;$x<=$lpp;$x++,$y++) {
            if($y <= $tp) {
                if($y == $curpage)
                    echo '<li class="active"><span>'.$y.'</span></li>';
                else
                    echo '<li><a href="'.$url.'page='.$y.'">'.$y.'</a></li>';
            } else {
                break;
            }
        }
        
        if($curpage == $tp)
            echo '<li class="disabled"><span>&raquo;</span></li>';
        else 
            echo '<li><a href="'.$url.'page='.$tp.'">&raquo;</a></li>';
        
        echo '</ul></div>';
    }
}

if ( ! function_exists('castle_name')) {
    function castle_name($id) {
        switch($id) {
            case 0:  $castle = 'Neuschwanstein'; break;
            case 1:  $castle = 'Hohenschwangau'; break;
            case 2:  $castle = 'Nuenberg'; break;
            case 3:  $castle = 'Wuerzburg'; break;
            case 4:  $castle = 'Rothenburg'; break;
            case 5:  $castle = 'Repherion'; break;
            case 6:  $castle = 'Eeyolbriggar'; break;
            case 7:  $castle = 'Yesnelph'; break;
            case 8:  $castle = 'Bergel'; break;
            case 9:  $castle = 'Mersetzdeitz'; break;
            case 10: $castle = 'Bright Arbor'; break;
            case 11: $castle = 'Scarlet Palace'; break;
            case 12: $castle = 'Holy Shadow'; break;
            case 13: $castle = 'Sacred Altar'; break;
            case 14: $castle = 'Bamboo Grove Hill'; break;
            case 15: $castle = 'Kriemhild'; break;
            case 16: $castle = 'Swanhild'; break;
            case 17: $castle = 'Fadhgridh'; break;
            case 18: $castle = 'Skoegul'; break;
            case 19: $castle = 'Gondul'; break;
            case 20: $castle = 'Earth'; break;
            case 21: $castle = 'Air'; break;
            case 22: $castle = 'Water'; break;
            case 23: $castle = 'Fire'; break;
            case 24: $castle = 'Himinn'; break;
            case 25: $castle = 'Andlangr'; break;
            case 26: $castle = 'Viblainn'; break;
            case 27: $castle = 'Hljod'; break;
            case 28: $castle = 'Skidbladnir'; break;
            case 29: $castle = 'Mardol'; break;
            case 30: $castle = 'Cyr'; break;
            case 31: $castle = 'Horn'; break;
            case 32: $castle = 'Gefn'; break;
            case 33: $castle = 'Bandis'; break;
            default: $castle = 'Undefined';
        }
        
        return $castle;
    }
}

if ( ! function_exists('mask2castles')) {
    function mask2castles($mask) {
        $castles = array(
            'Kriemhild'=>1, 'Swanhild'=>2, 'Fadhgridh'=>4, 'Skoegul'=>8, 'Gondul'=>16,
            'Bright Arbor'=>32, 'Scarlet Palace'=>64, 'Holy Shadow'=>128, 'Sacred Altar'=>256, 'Bamboo Grove Hill'=>512,
            'Repherion'=>1024, 'Eeyolbriggar'=>2048, 'Yesnelph'=>4096, 'Bergel'=>8192, 'Mersetzdeitz'=>16384,
            'Neuschwanstein'=>32768, 'Hohenschwangau'=>65536, 'Nuernberg'=>131072, 'Wuerzburg'=>262144, 'Rothenburg'=>524288,
            'Mardol'=>1048576, 'Cyr'=>2097152, 'Horn'=>4194304, 'Gefn'=>8388608, 'Bandis'=>16777216,
            'Himinn'=>33554432, 'Andlangr'=>67108864, 'Viblainn'=>134217728, 'Hljod'=>268435456, 'Skidbladnir'=>536870912
        );
        $result = array();
        foreach($castles as $ci=>$cv) {
            if($mask & $cv)
                $result[] = $ci;
        }
        return (0 < count($result)?$result:null);
    }
}