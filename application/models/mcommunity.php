<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Mcommunity extends CI_Model{
    public function player_ladder($order,$index=null,$pp=null) {
        $this->db->select('char.char_id,char.name,kills,deaths,base_level,job_level,base_exp,job_exp,class,guild.guild_id,guild.name AS guild_name,emblem_data AS emblem,zeny');
        $this->db->from('char');
        $this->db->join('pvpladder','pvpladder.name = char.name','left');
        $this->db->join('guild','guild.guild_id = char.guild_id','left');
        $this->db->join('login','login.account_id = char.account_id');
        $this->db->where('group_id',0);
        $this->db->order_by($order);
        if(null != $index AND null != $pp){ $this->db->limit($pp,$index); } else { $this->db->limit(10); }
        $query = $this->db->get();
        
        return (0 < $query->num_rows() ? $query->result():null);
    }
    
    public function guild_ladder($order,$index=null,$pp=null) {
        $this->db->select('guild.guild_id as gid,guild.name,guild_lv,exp,emblem_data AS emblem,master,(SELECT COUNT(*) FROM guild_castle WHERE guild_castle.guild_id=gid) AS castles');
        $this->db->from('guild');
        $this->db->join('char','char.char_id = guild.char_id');
        $this->db->join('login','login.account_id = char.account_id');
        $this->db->where('group_id',0);
        $this->db->order_by($order);
        if(null != $index AND null != $pp){ $this->db->limit($pp,$index); } else { $this->db->limit(10); }
        $query = $this->db->get();
        
        return (0 < $query->num_rows() ? $query->result():null);
    }
    
    public function castle_status($cond=null) {
        if(null != $cond)
            $this->db->where($cond);
        
        $this->db->select('castle_id,guild.guild_id,guild.name');
        $this->db->from('guild_castle');
        $this->db->join('guild','guild.guild_id = guild_castle.guild_id');
        $query = $this->db->get();
        return (0 < $query->num_rows()?$query->result():null);
    }
    
    public function woe_schedule() {
        $this->db->where('varname','$WOE_CONTROl');
        $this->db->order_by('index','asc');
        $query = $this->db->get('mapreg');
        return (0 < $query->num_rows()?$query->result():null);
    }
    
    public function guild_info($cond) {
        $this->db->where($cond);
        $query = $this->db->get('guild');
        return (0 < $query->num_rows() ? $query->result() : null);
    }
}