<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Shop extends TCP_Controller {
    protected $crumbs = array(array('desc'=>'Home','uri'=>''));
    
    public function index() {
        $this->check_login();
            
        if(!isset($_GET['page']))
            $page = 1;
        else 
            $page = $_GET['page'];
            
        $pp = 10;
        $index = $pp*($page-1);
        
        $this->load->model('mshop');
        $this->load->model('maccount');
        
        $profile = $this->maccount->get_profile(array('login.account_id'=>$this->session->userdata('account_id')));
        
        $cond = null;
        
        if(isset($_GET['cat'])) {
            switch($_GET['cat']) {
                case 'consume':
                    $cond = array('index'=>'item_db.type','val'=>array(0,2,11,18)); break;
                case 'head':
                    $cond = array('index'=>'equip_locations','val'=>array(1,256,257,512,513,768,769)); break;
                case 'weapon':
                    $cond = array('index'=>'item_db.type','val'=>array(5)); break;
                case 'shield':
                    $cond = array('index'=>'equip_locations','val'=>array(32)); break;
                case 'armor':
                    $cond = array('index'=>'equip_locations','val'=>array(16)); break;
                case 'robe':
                    $cond = array('index'=>'equip_locations','val'=>array(4)); break;
                case 'shoes':
                    $cond = array('index'=>'equip_locations','val'=>array(64)); break;
                case 'accessories':
                    $cond = array('index'=>'equip_locations','val'=>array(8,128,136)); break;
                case 'pets':
                    $cond = array('index'=>'item_db.type','val'=>array(7,8)); break;
                case 'cards':
                    $cond = array('index'=>'item_db.type','val'=>array(6)); break;
                case 'costumes':
                    $cond = array('index'=>'equip_locations','val'=>array(1024,2048,3072,4096,5120,6144,7168,8192));
                case 'misc':
                    $cond = array('index'=>'item_db.type','val'=>array(3,10)); break;
            }
        }
        
        $data['items']           = $this->mshop->get_shop_items(null,$index,$pp,$cond);
        $data['crumbs']          = $this->crumbs;
        $data['tp']              = count($this->mshop->get_shop_items(null,null,null,$cond));
        $data['vote_points']     = $profile[0]->vote_points;
        $data['donate_points']   = $profile[0]->donate_points;
        $data['cart_item_count'] = count($this->mshop->get_cart_items($this->session->userdata('account_id')));
        
        $page = 'shop/shop';
        $title = "Cash Shop";
            
            
        $this->page_build($title,null,$page,$data);
    }
    
    public function checkout() {
        $this->check_login();
        
        $title = 'Checkout';
        $page  = 'shop/checkout';
        $items = array();
        
        $this->load->model('mshop'); 
        $this->load->model('maccount');
        
        $profile = $this->maccount->get_profile(array('login.account_id'=>$this->session->userdata('account_id')));
        
        if(isset($_GET['transaction_type']) AND ('buy' == $_GET['transaction_type'] OR 'cart' == $_GET['transaction_type'] OR 'gift' == $_GET['transaction_type']))
            $tt = $_GET['transaction_type'];
        else
            redirect(base_url().'shop?msgcode=401','refresh'); // Error 401 - Invalid or missing data
            
        if(isset($_GET['item']) AND isset($_GET['qty'])) {
            for($x=0;$x<count($_GET['item']);$x++) {
                $ii = $this->mshop->get_shop_items($_GET['item'][$x]);
                if(null != $ii) {
                    $items[] = array(
                        'item_id'  => $ii[0]->item_id,
                        'name'     => $ii[0]->name_japanese,
                        'qty'      => $_GET['qty'][$x],
                        'price_dp' => $ii[0]->price_donate,
                        'price_vp' => $ii[0]->price_vote
                    );
                }
            }
        } else {
            // Error 401 - Invalid or missing data
            redirect(base_url().'shop?msgcode=401','refresh');
        }
        
        $this->crumbs[]          = array('desc'=>'Cash Shop','uri'=>'shop');
        $data['tt']              = $tt;
        $data['items']           = $items;
        $data['crumbs']          = $this->crumbs;
        $data['characters']      = $this->maccount->get_characters(array('account_id'=>$this->session->userdata('account_id')));
        $data['vote_points']     = $profile[0]->vote_points;
        $data['donate_points']   = $profile[0]->donate_points;
        $data['cart_item_count'] = count($this->mshop->get_cart_items($this->session->userdata('account_id')));
        
        $this->page_build($title,null,$page,$data);
    }
    
    public function switch_currency() {
        $this->check_login();
        
        $items = array();
        
        $this->load->model('mshop');
        
        if(isset($_POST['item']) AND isset($_POST['qty'])) {
            for($x=0;$x<count($_POST['item']);$x++) {
                $ii = $this->mshop->get_shop_items($_POST['item'][$x]);
                if(null != $ii) {
                    $items[] = array(
                        'item_id'  => $ii[0]->item_id,
                        'name'     => $ii[0]->name_japanese,
                        'qty'      => $_POST['qty'][$x],
                        'price_dp' => $ii[0]->price_donate,
                        'price_vp' => $ii[0]->price_vote
                    );
                }
            }
        } else {
            // Error 401 - Invalid or missing data
        }
        
        if(isset($_POST['paymethod']) AND ('dp' == $_POST['paymethod'] OR 'vp' == $_POST['paymethod'])) {
            $pm = $_POST['paymethod'];
        } else {
            $pm = 'dp';
        }
        
        $data['items'] = $items;
        $data['pm']    = $pm;
        
        $this->load->view('pages/shop/itemlist',$data);
    }
    
    public function process_payment() {
        $this->check_login();
        
        if(isset($_POST['tt']) AND isset($_POST['recipient']) AND isset($_POST['paymethod']) AND isset($_POST['item']) AND isset($_POST['qty'])) {
            $tt        = $_POST['tt'];
            $qtys      = $_POST['qty'];
            $items     = $_POST['item'];
            $recipient = $_POST['recipient'];
            $paymethod = $_POST['paymethod'];
            
            if(is_array($items) AND is_array($qtys)) {
                $item_qty_str = '';
                
                for($x=0;$x<count($items);$x++) {
                    $item_qty_str .= '&item%5B%5D='.$items[$x].'&qty%5B%5D='.$qtys[$x];
                }
                
                if("gift" != $tt)
                    $sender = $recipient;
                else if("gift" == $tt AND isset($_POST['sender']))
                    $sender = $_POST['sender'];
                else if("gift" == $tt AND !isset($_POST['sender']))
                    redirect(base_url().'shop?msgcode=401','refresh'); // Error 401 - Invalid or missing data
                
                $this->load->model('mshop');
                $this->load->model('maccount');
                
                $sender_check    = $this->maccount->get_characters(array('account_id'=>$this->session->userdata('account_id'),'char.name'=>$sender));
                $recipient_check = $this->maccount->get_characters(array('char.name'=>$recipient));
                
                if(null != $sender_check AND null != $recipient_check) {
                    $total_dp = 0;
                    $total_vp = 0;
                    $itemlist = array();
                    
                    for($x=0,$y=0;$x<count($items);$x++) {
                        $ii = $this->mshop->get_shop_items($items[$x]);
                        if(null != $ii) {
                            $itemlist[$y] = array(
                                'item_id'  => $ii[0]->item_id,
                                'qty'      => $qtys[$x]
                            );
                            
                            if('dp' == $paymethod) {
                                if(0 < $ii[0]->price_donate) {
                                    $total_dp += $ii[0]->price_donate*$qtys[$x];
                                    $itemlist[$y]['amount_dp'] = $ii[0]->price_donate*$qtys[$x];
                                    $itemlist[$y]['amount_vp'] = 0;
                                } else {
                                    $total_vp += $ii[0]->price_vote*$qtys[$x];
                                    $itemlist[$y]['amount_dp'] = 0;
                                    $itemlist[$y]['amount_vp'] = $ii[0]->price_vote*$qtys[$x];
                                }
                            } else {
                                if(0 < $ii[0]->price_vote) {
                                    $total_vp += $ii[0]->price_vote*$qtys[$x];
                                    $itemlist[$y]['amount_dp'] = 0;
                                    $itemlist[$y]['amount_vp'] = $ii[0]->price_vote*$qtys[$x];
                                } else {
                                    $total_dp += $ii[0]->price_donate*$qtys[$x];
                                    $itemlist[$y]['amount_dp'] = $ii[0]->price_donate*$qtys[$x];
                                    $itemlist[$y]['amount_vp'] = 0;
                                }
                            }
                            
                            $y++;
                        }
                    }
                    
                    $profile = $this->maccount->get_profile(array('login.account_id'=>$this->session->userdata('account_id')));
                    
                    if($total_dp <= $profile[0]->donate_points AND $total_vp <= $profile[0]->vote_points) {
                        $sender_id    = $sender_check[0]->char_id;
                        $sender_nm    = $sender_check[0]->name;
                        $recipient_id = $recipient_check[0]->char_id;
                        $recipient_nm = $recipient_check[0]->name;
                        
                        $payment = $this->maccount->update_profile_points(array('account_id'=>$this->session->userdata('account_id')),array('donate_points'=>"donate_points-$total_dp",'vote_points'=>"vote_points-$total_vp"));
                        
                        if($payment) {
                            $push = $this->mshop->punch_order($recipient_id,$sender_id,$total_dp,$total_vp,$itemlist,array('rcp_name'=>$recipient_nm,'snd_name'=>$sender_nm));
                            
                            if('cart' == $tt)
                                $clear_cart = $this->mshop->clear_cart($this->session->userdata('account_id'));
                                
                            if($push)
                                $url = 'shop/purchase_successful';
                            else
                                $url = 'shop/checkout?msgcode=402&transaction_type='.$tt.$item_qty_str; // Error 402 - Bad Request
                        } else {
                            $url = 'shop/checkout?msgcode=402&transaction_type='.$tt.$item_qty_str; // Error 402 - Bad Request
                        }
                    } else {
                        $url = 'shop/checkout?msgcode=428&transaction_type='.$tt.$item_qty_str; // Error 428 - Not enough points
                    }
                } else {
                    $url = 'shop/checkout?msgcode=427&transaction_type='.$tt.$item_qty_str; // Error 427 - Recipient/Sender non-existent
                }
            } else {
                $url = 'shop?msgcode=401'; // Error 401 - Invalid or missing data
            }
        } else {
            $url = 'shop?msgcode=401'; // Error 401 - Invalid or missing data
        }
        
        redirect(base_url().$url,'refresh');
    }
    
    public function purchase_successful() {
        $this->check_login();
        
        $title = 'Purchase Successful';
        $page  = 'shop/thankyou';
        
        $this->crumbs[] = array('desc'=>'Shop','uri'=>'shop');
        $data['crumbs'] = $this->crumbs;
        
        $this->page_build($title,null,$page,$data);
    }
    
    public function add() {
        $this->check_authority();
        
        if(!isset($_POST['submit']))
            die();
        
        $id       = $_POST['id'];
        $price_dp = $_POST['price_donate'];
        $price_vp = $_POST['price_vote'];
        
        if(($price_dp < 0 OR $price_vp < 0) OR ($price_dp == 0 AND $price_vp == 0)) {
            $url = 'dashboard/shop/add?msgcode=424'; // Error 424 - Invalid price
            redirect(base_url().$url,'refresh');
        }
        
        $this->load->model('mdatabase');
        $this->load->model('mshop');
        
        $is = $this->mshop->get_shop_items($id);
        $ii = $this->mdatabase->get_item_info($id);
        
        if(null != $is) {
            $url = 'dashboard/shop/add?msgcode=426'; // Error 426 - Duplicate item
            redirect(base_url().$url,'refresh');
        }
        
        if($ii != null) {
            $add = $this->mshop->add($id,$price_dp,$price_vp);
            
            if($add)
                $url = 'dashboard/shop/add?msgcode=115';
            else
                $url = 'dashboard/shop/add?msgcode=402'; // Error 402 - Bad request
        } else {
            $url = 'dashboard/shop/add?msgcode=425'; // Error 425 - Invalid item ID
        }
        
        redirect(base_url().$url,'refresh');
    }
    
    public function update() {
        $this->check_authority();
        
        if(!isset($_POST['submit']))
            die();
        
        $id       = $_POST['id'];
        $price_dp = $_POST['price_donate'];
        $price_vp = $_POST['price_vote'];
        
        if(($price_dp < 0 OR $price_vp < 0) OR ($price_dp == 0 AND $price_vp == 0)) {
            $url = 'dashboard/shop/edit?id='.$id.'&msgcode=424'; // Error 424 - Invalid price
            redirect(base_url().$url,'refresh');
        }
        
        $this->load->model('mdatabase');
        $this->load->model('mshop');
        
        $is = $this->mshop->get_shop_items($id);
        $ii = $this->mdatabase->get_item_info($id);
        
        if(null != $is) {
            if($ii != null) {
                $update = $this->mshop->update($id,array('price_donate'=>$price_dp,'price_vote'=>$price_vp));
                
                if($update)
                    $url = 'dashboard/shop?msgcode=118';
                else
                    $url = 'dashboard/shop/edit?id='.$id.'&msgcode=402'; // Error 402 - Bad request
            } else {
                $url = 'dashboard/shop?msgcode=425'; // Error 425 - Invalid item ID
            }
        } else {
            $url = 'dashboard/shop?msgcode=401'; // Error 401 - Invalid or missing data
        }
        redirect(base_url().$url,'refresh');
    }
    
    public function delete() {
        $this->check_authority();
        
        if(isset($_GET['ids'])) {
            $ids = $_GET['ids'];
            
            if(is_array($ids)) {
                $this->load->model('mshop');
                $errors = 0;
                foreach($ids as $id) {
                    $delete = $this->mshop->delete($id);
                    if(!$delete)
                        $errors++;
                }
                
                if(0 == $errors) {
                    // Success deleting shop item [success 117]
                    $url = 'dashboard/shop?msgcode=117';
                } else if(0 < $errors AND $errors < count($ids)) {
                    // Info 201 - Imperfect execution
                    $url = 'dashboard/shop?msgcode=201';
                } else {
                    //Error - Bad request [error 402]
                    $url = 'dashboard/shop?msgcode=402';
                }
            } else {
                $url = 'dashboard/shop?msgcode=401'; // Error 401 - Invalid or missing data
            }
        } else {
            $url = 'dashboard/shop?msgcode=401'; // Error 401 - Invalid or missing data
        }
        
        redirect(base_url().$url, "refresh");
    }
    
    public function cart() {
        $this->check_login();
        
        $title = 'My Cart';
        $page  = 'shop/cart';
        
        $this->load->model('mshop');
        $this->load->model('maccount');
        
        $cart_items = $this->mshop->get_cart_items($this->session->userdata('account_id'));
        $profile    = $this->maccount->get_profile(array('login.account_id'=>$this->session->userdata('account_id')));
        
        if(null != $cart_items) {
            $items = array();
            for($x=0;$x<count($cart_items);$x++) {
                $ii = $this->mshop->get_shop_items($cart_items[$x]->item_id);
                if(null != $ii) {
                    $items[] = array(
                        'cart_id'  => $cart_items[$x]->cart_id,
                        'item_id'  => $ii[0]->item_id,
                        'name'     => $ii[0]->name_japanese,
                        'qty'      => $cart_items[$x]->qty,
                        'price_dp' => $ii[0]->price_donate,
                        'price_vp' => $ii[0]->price_vote
                    );
                }
            }
        } else {
            $items = null;
        }
        
        $this->crumbs[]          = array('desc'=>'Cash Shop','uri'=>'shop');
        $data['items']           = $items;
        $data['crumbs']          = $this->crumbs;
        $data['vote_points']     = $profile[0]->vote_points;
        $data['donate_points']   = $profile[0]->donate_points;
        $data['cart_item_count'] = count($this->mshop->get_cart_items($this->session->userdata('account_id')));
        
        $this->page_build($title,null,$page,$data);
    }
    
    public function del_cart_item() {
        $this->check_login();
        
        if(isset($_GET['ids'])) {
            $ids = $_GET['ids'];
            
            if(is_array($ids)) {
                $this->load->model('mshop');
                $errors = 0;
                foreach($ids as $id) {
                    $check = $this->mshop->get_cart_items($this->session->userdata('account_id'),null,$id);
                    if(null != $check) {
                        $delete = $this->mshop->del_cart_item($id);
                        if(!$delete)
                            $errors++;
                    } else {
                        $errors++;
                    }
                }
                
                if(0 == $errors) {
                    //Success deleting cart item [success 116]
                    $url = 'shop/cart?msgcode=116';
                } else if(0 < $errors AND $errors < count($ids)) {
                    //Info 201 - Imperfect execution
                    $url = 'shop/cart?msgcode=201';
                } else {
                    //Error - Bad request [error 402]
                    $url = 'shop/cart?msgcode=402';
                }
            } else {
                $url = 'shop/cart?msgcode=401'; // Error 401 - Invalid or missing data
            }
        } else {
            $url = 'shop/cart?msgcode=401'; // Error 401 - Invalid or missing data
        }
        
        redirect(base_url().$url, "refresh");
    }
    
    public function add_cart_item() {
        $this->check_login();
        
        $this->load->model('mshop');
        
        if(isset($_POST['item']) AND isset($_POST['qty'])) {
            $ii = $this->mshop->get_shop_items($_POST['item'][0]);
            
            if(null != $ii) {
                $add = $this->mshop->add_cart_item($this->session->userdata('account_id'), $_POST['item'][0], $_POST['qty'][0]);
                if($add) {
                    $cart_items = $this->mshop->get_cart_items($this->session->userdata('account_id'));
                    $result     = array('success'=>1, 'cart_item_count'=>count($cart_items));
                } else {
                    $result     = array('success'=>0, 'cart_item_count'=>null);
                }
                
                print_r(json_encode($result));
            }
        } else {
            $result     = array('success'=>0, 'cart_item_count'=>null);
            print_r(json_encode($result));
        }
    }    
}