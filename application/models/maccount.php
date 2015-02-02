<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Maccount extends CI_Model {
    public function authenticate($username,$userpass) {
        $return_value = null;
        
        $username = mysql_real_escape_string($username);
        $userpass = mysql_real_escape_string($userpass);
        
        $query = $this->get_profile(array('userid'=>$username,'user_pass'=>$userpass));
        
        if(null != $query) { $return_value = $query; }
        
        return $return_value;
    }
    
    public function create_profile($userid,$userpass,$email,$sex,$fname,$lname,$birthday) {
        $data_a =     array('userid'=>$userid,'user_pass'=>$userpass,'email'=>$email,'sex'=>$sex,'birthdate'=>$birthday);
        $query_a =    $this->db->insert('login',$data_a);
        $account_id = $this->db->insert_id();
        
        $data_b =  array('account_id'=>$account_id,'fname'=>$fname,'lname'=>$lname,'birthday'=>$birthday);
        $query_b = $this->db->insert('tcp_profile',$data_b);
        
        return ($query_a AND $query_b ? true:false);
    }
    
    public function get_profile($cond=null,$index=null,$pp=null,$search=null,$sort=null,$count=null) {
        $this->load->model('msettings');
        $gen_settings = $this->msettings->get_set_gen();
        if('e' == $gen_settings[0]->emulator){ $group_id = 'level AS group_id'; } else { $group_id = 'group_id'; }
        
        $this->db->select('login.account_id,userid,sex,email,'.$group_id.',state,unban_time,profile_id,fname,lname,birthday,donate_points,vote_points,lastlogin,last_ip');
        $this->db->from('login');
        
        if(null != $cond) { $this->db->where($cond);}
        if(null != $search) { $this->db->like($search); }   
        if(null !== $index AND null !== $pp) { $this->db->limit($pp,$index); }
        if(null == $sort) { $sort = array('login.account_id','asc'); }
        
        $this->db->order_by($sort[0],$sort[1]);
        $this->db->join('tcp_profile','tcp_profile.account_id = login.account_id');
        
        if(null != $count AND true == $count) {
            $query = $this->db->count_all_results();
            return (0 < $query ? $query:null);
        } else {
            $query = $this->db->get();
            return (0 < $query->num_rows() ? $query->result():null);
        }
    }
    
    public function update_profile($account_id,$userid,$email,$sex,$fname,$lname,$birthday,$dp,$vp) {
        $this->db->where(array('account_id'=>$account_id));
        $data_a =  array('userid'=>$userid,'email'=>$email,'sex'=>$sex,'birthdate'=>$birthday);
        $query_a = $this->db->update('login',$data_a);
        
        $this->db->where(array('account_id'=>$account_id));
        $data_b =  array('fname'=>$fname,'lname'=>$lname,'birthday'=>$birthday,'donate_points'=>$dp,'vote_points'=>$vp);
        $query_b = $this->db->update('tcp_profile',$data_b);
        
        return ($query_a AND $query_b ? true:false);
    }
    
    public function update_profile_points($cond,$data) {
        $this->db->where($cond);
        foreach($data as $d => $dv) {
            $this->db->set($d, $dv, FALSE);
        }
        $query = $this->db->update('tcp_profile');
        
        return ($query ? true:false);
    }
    
    public function get_characters($cond=null,$index=null,$pp=null,$sort=null,$search=null,$count=null) {
        if(null == $sort)
            $sort = array('char.char_id','asc');
        
        $this->load->model('msettings');
        $gen_settings = $this->msettings->get_set_gen();
        if('e' == $gen_settings[0]->emulator){ $unban_time = ''; } else { $unban_time = ',char.unban_time'; }
        
        $this->db->select('char.char_id,char.name,account_id,last_map,last_x,last_y,char_num,class,base_level,job_level,zeny,char.guild_id,str,agi,vit,int,dex,luk,guild.name AS guild_name, emblem_data AS emblem'.$unban_time);
        $this->db->from('char');
        if(null != $cond) { $this->db->where($cond); }
        if(null != $search) { $this->db->like($search); }
        $this->db->join('guild','guild.guild_id = char.guild_id','left');
        $this->db->order_by($sort[0],$sort[1]);
        if(null !== $index AND null !== $pp) { $this->db->limit($pp,$index); }
        if(null != $count AND true == $count) {
            $query = $this->db->count_all_results();
            return (0 < $query ? $query:null);
        } else {
            $query = $this->db->get();
            return ($query ? $query->result():null);
        }
    }
    
    public function update_character($cond,$data) {
        $this->db->where($cond);
        $query = $this->db->update('char',$data);
        return ($query ? true:false);
    }
    
    public function check_detail_avail($detail) {
        switch($detail[0]) {
            case 'username':
                $this->db->select('userid'); $this->db->where('userid',$detail[1]); $query =  $this->db->get('login');
                $this->db->select('userid'); $this->db->where('userid',$detail[1]); $queryB =  $this->db->get('tcp_register');
                
                if(0 == $query->num_rows() AND 0 == $queryB->num_rows())
                    $return = 1;//Username available
                else
                    $return = 0;//Username unavailable
                break;
            case 'email':
                $this->db->select('email'); $this->db->where('email',$detail[1]); $query =  $this->db->get('login');
                $this->db->select('email'); $this->db->where('email',$detail[1]); $queryB = $this->db->get('tcp_register');
                if(0 == $query->num_rows() AND 0 == $queryB->num_rows())
                    $return = 1;//Email available
                else
                    $return = 0;//Email unavailable
                break;
            default:
                $return = 3;//Error 401 - Missing/Invalid data
        }
        
        return $return;
    }
    
    public function get_password($account_id) {
        $this->db->select('user_pass');
        $this->db->where('account_id',$account_id);
        $query = $this->db->get('login');
        return ($query ? $query->result():null);
    }
    
    public function update_password($account_id,$user_pass) {
        $this->db->where('account_id',$account_id);
        $query = $this->db->update('login',array('user_pass'=>$user_pass));
        return ($query ? true:false);
    }
    
    public function add_pass_res($data) {
        $query = $this->db->insert('tcp_pass_res',$data);
        return ($query ? true:false);
    }
    
    public function get_pass_res($cond) {
        $this->db->where($cond);
        $query = $this->db->get('tcp_pass_res');
        return (0 < $query->num_rows() ? $query->result():null);
    }
    
    public function del_pass_res($cond) {
        $this->db->where($cond);
        $query = $this->db->delete('tcp_pass_res');
        return ($query ? true:false);
    }
    
    public function create_temp($userid,$userpass,$email,$sex,$fname,$lname,$birthday) {
        $code = random_string('alnum',20);
        $date = date('Y-m-d H:i:s');
        $data = array('userid'=>$userid,'userpass'=>$userpass,'email'=>$email,'sex'=>$sex,'fname'=>$fname,'lname'=>$lname,'birthday'=>$birthday,'code'=>$code,'save_date'=>$date);
        $query = $this->db->insert('tcp_register',$data);
        $reg_id = $this->db->insert_id();
        $result = array($reg_id,$code);
        return ($query ? $result : null);
    }
    
    public function get_temp($cond) {
        $this->db->where($cond);
        $query = $this->db->get('tcp_register');
        return (0 < $query->num_rows() ? $query->result() : null);
    }
    
    public function del_temp($id) {
        $query = $this->db->delete('tcp_register',array('register_id'=>$id));
        return ($query ? true : false);
    }
    
    public function ban_user($id,$time) {
        $data = array('unban_time'=>$time);
        $this->db->where('account_id',$id);
        $query = $this->db->update('login',$data);
        return ($query ? true:false);
    }
    
    public function ban_char($id,$time) {
        $data = array('unban_time'=>$time);
        $this->db->where('char_id',$id);
        $query = $this->db->update('char',$data);
        return ($query ? true:false);
    }
    
    public function unban_user($id) {
        $data = array('unban_time'=>'0');
        $this->db->where('account_id',$id);
        $query = $this->db->update('login',$data);
        return ($query ? true:false);
    }
    
    public function unban_char($id) {
        $data = array('unban_time'=>'0');
        $this->db->where('char_id',$id);
        $query = $this->db->update('char',$data);
        return ($query ? true:false);
    }
    
    public function delete_user($id) {
        $tbls = array('login','tcp_profile','char');
        $query = $this->db->delete($tbls,array('account_id'=>$id));
        return true;
    }
    
    public function delete_char($id) {
        $query = $this->db->delete('char',array('char_id'=>$id));
        return true;
    }
    
    public function get_ipbanlist($cond=null,$index=null,$pp=null,$sort=null,$search=null,$count=null) {
        if(null != $cond){ $this->db->where($cond); }
        if(null == $sort){ $sort = array('btime','asc'); }
        if(null != $cond) { $this->db->where($cond);}
        if(null != $search) { $this->db->like($search); }   
        if(null !== $index AND null !== $pp) { $this->db->limit($pp,$index); }
        $this->db->order_by($sort[0],$sort[1]);
        if(null != $count AND true == $count) {
            $query = $this->db->count_all_results('ipbanlist');
            return (0 < $query ? $query:null);
        } else {
            $query = $this->db->get('ipbanlist');
            return (0 < $query->num_rows()?$query->result():null);
        }
    }
    
    public function add_ipbanlist($ip,$date,$reason=null) {
        $data  = array('list'=>$ip,'btime'=>date('Y-m-d H:i:s'),'rtime'=>$date,'reason'=>$reason);
        $query = $this->db->insert('ipbanlist',$data);
        return ($query ? true:false);
    }
    
    public function delete_ipban($ip) {
        $query = $this->db->delete('ipbanlist',array('list'=>$ip));
        return true;
    }
}