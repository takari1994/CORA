<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Mshop extends CI_Model {
    
    protected $mail_name  = 'Cash Shop';
    protected $mail_title = array('buy' => 'Cash Shop::Purchase', 'gift' => 'Cash Shop::Gift');
    protected $mail_msg   = array(
        'buy'  => "Thank you for your purchase! Your item has been attached to this mail.",
        'gift' => "You have received a cash shop gift from a friend!"
    );
    
    public function get_shop_items($itemid=null,$index=null,$pp=null,$cond=null,$count=null) {
        $select = "*"; $tbl = "`item_db`"; $where = null; $join = null; $order = null; $limit = null;
        
        if(true == $count AND !$this->db->table_exists('item_db2'))
            $select = "COUNT(*) AS rows";
        if($this->db->table_exists('item_db_re'))
            $tbl = '`item_db_re`';
        
        $join  = " JOIN $tbl ON $tbl.`id`=`tcp_shop`.`item_id`"; $joinB = " JOIN `item_db2` ON `item_db2`.`id`=`tcp_shop`.`item_id`";
        $order = " ORDER BY `name_japanese` asc";
        
        if(null !== $index AND null !== $pp) { $limit = " LIMIT ".$this->db->escape($index).", ".$this->db->escape($pp); }
        
        if(null != $itemid) {
            //$this->db->where(array('tcp_shop.item_id'=>$itemid));
            $where = " WHERE `tcp_shop`.`item_id`=".$this->db->escape($itemid);
        } else if(null != $cond) {
            $x = 0;
            foreach($cond['val'] as $val) {
                if($x == 0)
                    $where = " WHERE `".$cond['index']."`=".$this->db->escape($val);
                else
                    $where .= " OR `".$cond['index']."`=".$this->db->escape($val);
                $x++;
            }
        }
        
        $qstr = "SELECT $select FROM (`tcp_shop`)".$join.$where;
        
        if(null != $count AND true == $count)
            $selectB = "COUNT(*) AS rows";
        else
            $selectB = "*";
        
        $qstrB = "SELECT $select FROM (`tcp_shop`)".$joinB.$where;
        
        if($this->db->table_exists('item_db2')) {
            $qstr = "SELECT $selectB FROM (($qstrB) UNION ($qstr)) a ".$order.$limit;
        } else {
            $qstr .= $order.$limit;
        }
        
        if($count != null AND true == $count) {
            $query = $this->db->query($qstr);
            $query = $query->result();
            $query = $query[0]->rows;
            return (0 < $query ? $query:null);
        } else {
            $query  = $this->db->query($qstr);
            $result = $this->filter_result($query->result()); 
            return ($query ? $result:null);
        }
    }
    
    public function punch_order($recipient,$sender,$total_dp,$total_vp,$items,$xdata=null) {
        $date = date("Y-m-d H:i:s");
        $data = array('recipient_id'=>$recipient,'sender_id'=>$sender,'total_dp'=>$total_dp,'total_vp'=>$total_vp,'date'=>$date);
        $order = $this->db->insert('tcp_order',$data);
        $order_id = $this->db->insert_id();
        // MAIL INFO
        $send_nm = 'Cash Shop';
        
        if($recipient == $sender) {
            $title = $this->mail_title['buy']; $msg = $this->mail_msg['buy'];
        } else {
            $title = $this->mail_title['gift']; $msg = $this->mail_msg['gift'];
        }
        $od   = '';
        if($recipient != $sender) { $od .= "\nFrom: ".$xdata['snd_name']; }
        $od  .= "\nDate: ".$date;
        $od  .= "\nOrder #".$order_id;
        $body = $msg.$od;
        $time = strtotime($date);
        // PUSH EACH ITEMS IN ORDER
        $flag = 0;
        foreach($items as $item) {
            $item['order_id'] = $order_id;
            $query = $this->db->insert('tcp_order_items',$item);
            
            if(!$query)
                $flag++;
            else {
                $mail_data = array('send_name'=>$this->mail_name,'send_id'=>$sender,'dest_name'=>$xdata['rcp_name'],'dest_id'=>$recipient,'title'=>$title,'message'=>$body,'time'=>$time,'nameid'=>$item['item_id'],'amount'=>$item['qty'],'identify'=>1);
                $mail = $this->db->insert('mail',$mail_data);
            }
        }
        
        return ($order AND 0 == $flag ? true:false);
    }
    
    public function add($id,$price_dp,$price_vp) {
        $data  = array('item_id' => $id, 'price_donate' => $price_dp, 'price_vote' => $price_vp);
        $query = $this->db->insert('tcp_shop',$data);
        
        return ($query ? true:false);
    }
    
    public function update($id,$data) {
        $this->db->where('item_id',$id);
        $query = $this->db->update('tcp_shop',$data);
        
        return ($query ? true:false);
    }
    
    public function delete($shop_id) {
        $cond = array('shop_id'=>$shop_id);
        $this->db->where($cond);
        $query = $this->db->delete('tcp_shop');
        
        return ($query ? true:false);
    }
    
    public function get_cart_items($account_id,$item_id=null,$cart_id=null) {
        $cond = array('account_id'=>$account_id);
        if(null != $item_id) { $cond['item_id'] = $item_id; }
        if(null != $cart_id) { $cond['cart_id'] = $cart_id; }
        
        $this->db->where($cond);
        $query = $this->db->get('tcp_cart');
        
        return (0 < $query->num_rows() ? $query->result():null);
    }
    
    public function add_cart_item($account_id, $item_id, $qty) {
        $check = $this->get_cart_items($account_id,$item_id);
        if(null == $check) {
            $data = array('account_id'=>$account_id, 'item_id'=>$item_id, 'qty'=>$qty);
            $query = $this->db->insert('tcp_cart', $data);
        } else {
            $cond = array('account_id'=>$account_id,'item_id'=>$item_id);
            
            $this->db->where($cond);
            $this->db->set('qty','qty+'.$qty, FALSE);
            $query = $this->db->update('tcp_cart');
        }
        return ($query ? true:false);
    }
    
    public function del_cart_item($cart_id) {
        $cond = array('cart_id'=>$cart_id);
        $this->db->where($cond);
        $query = $this->db->delete('tcp_cart');
        
        return($query ? true:false);
    }
    
    public function clear_cart($account_id) {
        $cond = array('account_id'=>$account_id);
        $this->db->where($cond);
        $query = $this->db->delete('tcp_cart');
        
        return($query ? true:false);
    }
    
    public function filter_result($result) {
        if(null != $result) {
            for($x=0;$x<count($result);$x++) {
                $y = 0; $flag = false;
                for($y=0;$y<count($result);$y++) {
                    if($result[$y]->id == $result[$x]->id AND $y < $x)
                        $flag = true;
                }
                if($flag == true) {
                    unset($result[$x]);
                    $result = array_values($result);
                }
            }
        }
        
        return $result;
    }
}