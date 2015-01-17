<?php if ( ! defined('BASEPATH')) exit('No direct script access!');

require_once(APP_PATH."/controllers/bmp.php");

class Community extends TCP_Controller {
    protected $crumbs = array(array('desc'=>'Home','uri'=>''),array('desc'=>'Community','uri'=>'Account'));
    
    public function index() {
        redirect(base_url().'community/player_ladder','refresh');
    }
    
    public function player_statistics() {
        $this->load->model('mdashboard');
        $player_count_qStr = "SELECT `value` FROM `mapreg` WHERE varname=?";
        $player_peak_qStr  = "SELECT `value` FROM `mapreg` WHERE varname=?";
        
        $player_count = $this->mdashboard->query($player_count_qStr,array('userOnline'));
        $player_peak  = $this->mdashboard->query($player_peak_qStr,array('userPeak'));
        
        $pc = (null != $player_count ? $player_count[0]->value:0);
        $pp = (null != $player_peak ? $player_peak[0]->value:0);
        
        $ps = array('player_count'=>$pc,'player_peak'=>$pp);
        
        echo json_encode($ps);
    }
    
    public function player_ladder() {
        if(!isset($_GET['sort']))
            redirect(base_url().'community/player_ladder?sort=kills','refresh');
        
        if(!isset($_GET['page']))
            $page = 1;
        else 
            $page = $_GET['page'];
        
        $pp = 10;
        $index = $pp*($page-1);
        
        $sort = $_GET['sort'];
        
        switch($sort) {
            case 'kills':
                $order = 'kills desc, (kills/deaths) desc, base_exp desc'; break;
            case 'base_level':
                $order = 'base_level desc, base_exp desc'; break;
            case 'job_level':
                $order = 'job_level desc, job_exp desc'; break;
            case 'zeny':
                $order = 'zeny desc';
        }
        
        $this->load->model('mcommunity');
        $ladder = $this->mcommunity->player_ladder($order,$index,$pp);
        
        if(isset($_GET['json']) AND 'true' == $_GET['json']) {
            echo json_encode($ladder);
        } else {
            $title = 'Player Ladder';
            $page  = 'community/player_ladder';
            $data['crumbs'] = $this->crumbs;
            $data['ladder'] = $ladder;
            $data['tp']     = count($this->mcommunity->player_ladder($order));
            $this->page_build($title,null,$page,$data);
        }
    }
    
    public function guild_ladder() {
        if(!isset($_GET['sort']))
            redirect(base_url().'community/guild_ladder?sort=guild_lv','refresh');
        
        if(!isset($_GET['page']))
            $page = 1;
        else 
            $page = $_GET['page'];
        
        $pp = 10;
        $index = $pp*($page-1);
        
        $sort = $_GET['sort'];
        
        switch($sort) {
            case 'guild_lv':
                $order = 'guild_lv DESC, exp DESC'; break;
            case 'castles':
                $order = 'castles DESC, guild_lv DESC';
        }
        
        $this->load->model('mcommunity');
        $ladder = $this->mcommunity->guild_ladder($order,$index,$pp);
        
        if(isset($_GET['json']) AND 'true' == $_GET['json']) {
            echo json_encode($ladder);
        } else {
            $title = 'Guild Ladder';
            $page  = 'community/guild_ladder';
            $data['crumbs'] = $this->crumbs;
            $data['ladder'] = $ladder;
            $data['tp']     = count($this->mcommunity->guild_ladder($order));
            $this->page_build($title,null,$page,$data);
        }
    }
    
    public function castle_status() {
        $this->load->model('mcommunity');
        $castles = $this->mcommunity->castle_status();
        
        $status = array();
        
        if(null != $castles) {
        foreach($castles as $c) {
            $status[$c->castle_id] = array('id'=>$c->guild_id,'name'=>$c->name);
        }
        }
        
        if(isset($_GET['json']) AND 'true' == $_GET['json']) {
            echo json_encode($status);
        } else {
            $title = 'Castle Status';
            $page  = 'community/castle_status';
            $data['castles'] = $status;
            $data['crumbs']  = $this->crumbs;
            $this->page_build($title,null,$page,$data);
        }
    }
    
    public function woe_schedule() {        
        $this->load->model('mcommunity');
        $sched = $this->mcommunity->woe_schedule();
        
        if(null != $sched){
            $day = null; $start = null; $end = null; $mask = null;
            $sunday = array(); $monday = array(); $tuesday = array(); $wednesday = array(); $thursday = array(); $friday = array(); $saturday = array();
            $last_index = $sched[count($sched)-1]->index;
            for($x=0,$y=0;$x<=$last_index;$x++) {
                $value = 0;
                foreach($sched as $s) { if($x <= intval($s->index)) { if($x == intval($s->index)){ $value = intval($s->value); break; } } else { $break; } }
                switch($y) { case 0: $day=$value;break; case 1: $start=$value;break; case 2: $end=$value;break; case 3: $mask=$value; }
                if(null !== $day AND null !== $start AND null !== $end AND null !== $mask) {
                    switch($day) {
                        case 0: $sunday[count($sunday)]       = array('start'=>$start,'end'=>$end,'mask'=>$mask); break;
                        case 1: $monday[count($monday)]       = array('start'=>$start,'end'=>$end,'mask'=>$mask); break;
                        case 2: $tuesday[count($tuesday)]     = array('start'=>$start,'end'=>$end,'mask'=>$mask); break;
                        case 3: $wednesday[count($wednesday)] = array('start'=>$start,'end'=>$end,'mask'=>$mask); break;
                        case 4: $thursday[count($thursday)]   = array('start'=>$start,'end'=>$end,'mask'=>$mask); break;
                        case 5: $friday[count($friday)]       = array('start'=>$start,'end'=>$end,'mask'=>$mask); break;
                        case 6: $saturday[count($saturday)]   = array('start'=>$start,'end'=>$end,'mask'=>$mask);
                    }
                    $day = null; $start = null; $end = null; $mask = null;
                }
                if(3 > $y){ $y++; } else { $y = 0; }
            }
        } else {
            $sunday = null; $monday = null; $tuesday = null; $wednesday = null; $thursday = null; $friday = null; $saturday = null; 
        }
        
        $title          = 'WoE Schedule';
        $page           = 'community/woe_sched';
        $data['crumbs'] = $this->crumbs;
        $data['sun']    = $sunday; $data['mon'] = $monday; $data['tue'] = $tuesday; $data['wed'] = $wednesday; $data['thu'] = $thursday; $data['fri'] = $friday; $data['sat'] = $saturday;
        $this->page_build($title,null,$page,$data);
    }
    
    public function guild_emblem($gid) {
        $this->load->model('mcommunity');
        $ginfo = $this->mcommunity->guild_info(array('guild_id'=>$gid));
        $emblem = $ginfo[0]->emblem_data;
        $emblem = @gzuncompress(pack('H*',$emblem));
        file_put_contents('emblem.bmp',$emblem);
        header('Content-type: image/png');
        $im = imagecreatefrombmp('emblem.bmp');
        $purple = imagecolorallocate($im, 255, 0, 255);
        imagecolortransparent($im,$purple);
        imagepng($im);
    }
}
