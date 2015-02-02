<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Dashboard extends TCP_Controller {
    protected $reqlvl = 99;
    protected $crumbs = array(array('desc'=>'Dashboard','uri'=>'dashboard'));
    
    public function index() {
        $this->check_authority();
        redirect(base_url().'dashboard/posts','refresh');
    }
    
    public function posts() {
        $this->check_authority();
        
        if(!isset($_GET['page']))
            $page = 1;
        else 
            $page = $_GET['page'];
        
        $pp = 10;
        $index = $pp*($page-1);
        
        $this->crumbs[] = array('desc'=>'Posts','uri'=>'posts');
        $data['crumbs'] = $this->crumbs;
        $data['links'] = $this->get_dash_nav();
        
        if(!isset($_GET['action'])) {
            $this->load->model('mpost');
            $title = "View All Posts";
            $data['posts'] = $this->mpost->get_posts(null,null,$index,$pp);
            $data['tp'] =    $this->mpost->get_posts(null,null,null,null,null,true);
            $page = 'dashboard/posts/posts';
        } else {
            $action = $_GET['action'];
            switch($action) {
                case 'new':
                    if(isset($_GET['type'])) {
                        $type = $_GET['type'];
                        switch($type) {
                            case 'news':
                                $title = "Create a News Post";
                                $page = 'dashboard/posts/newnews'; break;
                            case 'event':
                                $title = "Create an Event Post";
                                $page = 'dashboard/posts/newevent'; break;
                            default:
                                //Default action for invalid type data
                                redirect(current_url().'?msgcode=401','refresh');
                        }
                    } else {
                        //Error missing data
                        redirect(current_url().'?msgcode=401','refresh');
                    } break;
                case 'edit':
                    if(isset($_GET['type']) AND isset($_GET['id'])) {
                        $type = $_GET['type']; $id = $_GET['id'];
                        switch($type) {
                            case 'news':
                                $title = "Edit a News";
                                $page = 'dashboard/posts/newnews';
                                $this->load->model('mpost');
                                $data['news'] = $this->mpost->get_posts($id);
                                break;
                            case 'event':
                                $title = "Edit an Event";
                                $page = 'dashboard/posts/newevent';
                                $this->load->model('mpost');
                                $data['event'] = $this->mpost->get_posts($id,true);
                                break;
                            default:
                                //Error - Missing/Invalid data [error 401]
                                redirect(current_url().'?msgcode=401','refresh');
                        }
                        
                    } else {
                        //Error - Missing/Invalid data [error 401]
                        redirect(current_url().'?msgcode=401','refresh');
                    } break;
            }
        }
            
        $this->page_build($title,'dashboard',$page,$data);
    }
    
    public function pages() {
        $this->check_authority();
        
        if(!isset($_GET['page']))
            $page = 1;
        else 
            $page = $_GET['page'];
        
        $pp = 10;
        $index = $pp*($page-1);
        
        $this->crumbs[] = array('desc'=>'Pages','uri'=>'pages');
        $data['crumbs'] = $this->crumbs;
        $data['links'] = $this->get_dash_nav();      
        $page = 'dashboard/pages/pages';
        
        if(!isset($_GET['action'])) {
            $this->load->model('mpage');
            $title = "View Pages";
            $data['pages'] = $this->mpage->get_pages(null,$index,$pp);
            $data['tp'] =    $this->mpage->get_pages(null,null,null,true);
            $page = 'dashboard/pages/pages';
        } else {
            switch($_GET['action']) {
                case 'new':
                    $title = "Create a New Page";
                    $page = 'dashboard/pages/newpage';
                    break;
                case 'edit':
                    if(isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $title = "Edit a Page";
                        $page = 'dashboard/pages/newpage';
                        $this->load->model('mpage');
                        $data['page'] = $this->mpage->get_pages($id);
                    } else {
                        //Error - Missing/Invalid data [error 401]
                        redirect(current_url().'?msgcode=401','refresh');
                    }
                    break;
                default:
                    //Error - Missing/Invalid data [error 401]
                    redirect(current_url().'?msgcode=401','refresh');
            }
        }
        
        $this->page_build($title,'dashboard',$page,$data);
    }
    
    public function users($sub=null) {
        $this->check_authority();
        $this->crumbs[] = array('desc'=>'Users','uri'=>'users');
        
        if(null == $sub) {
            if(!isset($_GET['action'])) {
                $this->load->model('maccount');
                
                $title  = "Manage Users";
                $page   = "dashboard/users/users";
                $cond   = null;
                $sort   = null;
                $search = null;
                
                if(!isset($_GET['page']))
                    $curpage = 1;
                else 
                    $curpage = $_GET['page'];
                
                $pp = PAGINATION_RPP;
                $index = $pp*($curpage-1);
                
                if(isset($_GET['search']) AND isset($_GET['query']) AND isset($_GET['field']) AND isset($_GET['state']) AND isset($_GET['sort']) AND isset($_GET['order'])) {
                    $query = $_GET['query'];
                    
                    if(null != $query) {
                        switch($_GET['field']) {
                            case 'userid':     $search['userid'] = $query; break;
                            case 'accountid':  $cond['login.account_id'] = $query; break;
                            case 'fname':      $search['fname'] = $query; break;
                            case 'lname':      $search['lname'] = $query; break;
                            case 'lastip':     $search['login.last_ip'] = $query; break;
                            default: redirect(base_url().'dashboard/users?msgcode=401','refresh');
                        }
                    }
                    
                    if("all" != $_GET['state']) {
                        switch($_GET['state']) {
                            case 'active': $fieldB = 'unban_time <'; break;
                            case 'banned': $fieldB = 'unban_time >'; break;
                            default: redirect(base_url().'dashboard/users?msgcode=401','refresh');
                        }
                        $cond[$fieldB] = strtotime(date("Y-m-d H:i:s"));
                    }
                    
                    $sort = array($_GET['sort'],$_GET['order']);
                }
                
                $data['tp']    = $this->maccount->get_profile($cond,null,null,$search,null,true);
                $data['users'] = $this->maccount->get_profile($cond,$index,$pp,$search,$sort);
            } else {
                $data['mode'] = 'user';
                $this->load->model('maccount');
                switch($_GET['action']) {
                    case 'ban':
                        if(isset($_GET['ids']) AND is_array($_GET['ids'])) {
                            $ids = $_GET['ids'];
                            $ban_users = array();
                            $ban_users_fail = array();
                            foreach($ids as $id) {
                                $user = $this->maccount->get_profile(array('login.account_id'=>$id));
                                if(null != $user) {
                                    $ban_users[] = array(
                                        'account_id' => $user[0]->account_id,
                                        'name' =>       $user[0]->fname.' '.$user[0]->lname
                                    );
                                } else {
                                    continue;
                                }
                            }
                            $title = "Ban Users";
                            $page = "dashboard/users/ban";
                            $data['ban_users_fail'] = $ban_users_fail;
                            $data['ban_users'] = $ban_users;
                        } else {
                            //Error 401 - Invalid/missing data
                            redirect(current_url().'?msgcode=401','refresh');
                        }
                        break;
                    case 'unban':
                        if(isset($_GET['ids']) AND is_array($_GET['ids'])) {
                            $ids = $_GET['ids'];
                            $unban_users = array();
                            $unban_users_fail = array();
                            foreach($ids as $id) {
                                $user = $this->maccount->get_profile(array('login.account_id'=>$id));
                                if(null != $user) {
                                    $unban_users[] = array(
                                        'account_id' => $user[0]->account_id,
                                        'name' =>       $user[0]->fname.' '.$user[0]->lname
                                    );
                                } else {
                                    continue;
                                }
                            }
                            $title = "Unban Users";
                            $page = "dashboard/users/unban";
                            $data['unban_users_fail'] = $unban_users_fail;
                            $data['unban_users'] = $unban_users;
                        } else {
                            //Error 401 - Invalid/missing data
                            redirect(current_url().'?msgcode=401','refresh');
                        }
                }
            }
        } else if('characters' == $sub) {
            $this->crumbs[] = array('desc'=>'Characters','uri'=>'characters');
            if(!isset($_GET['action'])) {
                $this->load->model('maccount');
                $title  = "Manage Characters";
                $page   = "dashboard/users/characters";
                $cond   = null;
                $sort   = null;
                $search = null;
                
                if(!isset($_GET['page']))
                    $curpage = 1;
                else 
                    $curpage = $_GET['page'];
                
                $pp = PAGINATION_RPP;
                $index = $pp*($curpage-1);
                
                if(isset($_GET['search']) AND isset($_GET['query']) AND isset($_GET['field']) AND isset($_GET['state']) AND isset($_GET['sort']) AND isset($_GET['order'])) {
                    $query = $_GET['query'];
                    
                    if(null != $query) {
                        switch($_GET['field']) {
                            case 'name':      $search['char.name'] = $query; break;
                            case 'classid':   $cond['char.class'] = $query; break;
                            case 'accountid': $cond['char.account_id'] = $query; break;
                            case 'charid':    $cond['char.char_id'] = $query; break;
                            default: redirect(base_url().'dashboard/users?msgcode=401','refresh');
                        }
                    }
                    
                    if("all" != $_GET['state']) {
                        switch($_GET['state']) {
                            case 'active': $fieldB = 'unban_time <'; break;
                            case 'banned': $fieldB = 'unban_time >'; break;
                            default: redirect(base_url().'dashboard/users?msgcode=401','refresh');
                        }
                        $cond[$fieldB] = strtotime(date("Y-m-d H:i:s"));
                    }
                    
                    $sort = array($_GET['sort'],$_GET['order']);
                }
                
                $this->load->model('msettings');
                $data['gen_settings'] = $this->msettings->get_set_gen();
                $data['tp']           = $this->maccount->get_characters($cond,null,null,null,$search,true);
                $data['chars']        = $this->maccount->get_characters($cond,$index,$pp,$sort,$search);
            } else {
                $data['mode'] = 'character';
                $this->load->model('maccount');
                switch($_GET['action']) {
                    case 'ban':
                        if(isset($_GET['ids']) AND is_array($_GET['ids'])) {
                            $ids = $_GET['ids'];
                            $ban_users = array();
                            $ban_users_fail = array();
                            foreach($ids as $id) {
                                $char = $this->maccount->get_characters(array('char.char_id'=>$id));
                                if(null != $char) {
                                    $ban_users[] = array(
                                        'account_id' => $char[0]->account_id,
                                        'char_id' =>    $char[0]->char_id,
                                        'name'    =>    $char[0]->name
                                    );
                                } else {
                                    continue;
                                }
                            }
                            $title = "Ban Characters";
                            $page = "dashboard/users/ban";
                            $data['ban_users_fail'] = $ban_users_fail;
                            $data['ban_users'] = $ban_users;
                        } else {
                            //Error 401 - Invalid/missing data
                            redirect(current_url().'?msgcode=401','refresh');
                        }
                        break;
                    case 'unban':
                        if(isset($_GET['ids']) AND is_array($_GET['ids'])) {
                            $ids = $_GET['ids'];
                            $unban_users = array();
                            $unban_users_fail = array();
                            foreach($ids as $id) {
                                $char = $this->maccount->get_characters(array('char.char_id'=>$id));
                                if(null != $char) {
                                    $unban_users[] = array(
                                        'account_id' => $char[0]->account_id,
                                        'char_id' =>    $char[0]->char_id,
                                        'name'    =>    $char[0]->name
                                    );
                                } else {
                                    continue;
                                }
                            }
                            $title = "Unban Users";
                            $page = "dashboard/users/unban";
                            $data['unban_users_fail'] = $unban_users_fail;
                            $data['unban_users'] = $unban_users;
                        } else {
                            //Error 401 - Invalid/missing data
                            redirect(current_url().'?msgcode=401','refresh');
                        }
                }
            }
        } else if('ip_ban_list' == $sub) {
            $this->crumbs[] = array('desc'=>'IP Ban List','uri'=>'ip_ban_list');
            $this->load->model('maccount');
            if(!isset($_GET['action'])) {
                $title = "Manage IP Ban List";
                $page  = 'dashboard/users/ipbanlist';
                $cond   = null;
                $sort   = null;
                $search = null;
                
                if(!isset($_GET['page']))
                    $curpage = 1;
                else 
                    $curpage = $_GET['page'];
                
                $pp = PAGINATION_RPP;
                $index = $pp*($curpage-1);
                
                
                if(isset($_GET['search']) AND isset($_GET['query']) AND isset($_GET['state']) AND isset($_GET['sort']) AND isset($_GET['order'])) {
                    $query = $_GET['query'];
                    
                    $search['list'] = $query;
                    
                    if("all" != $_GET['state']) {
                        switch($_GET['state']) {
                            case 'active': $fieldB = 'rtime >'; break;
                            case 'expired': $fieldB = 'rtime <'; break;
                            default: redirect(base_url().'dashboard/users?msgcode=401','refresh');
                        }
                        $cond[$fieldB] = date("Y-m-d H:i:s");
                    }
                    
                    $sort = array($_GET['sort'],$_GET['order']);
                }
                
                $data['tp'] = $this->maccount->get_ipbanlist($cond,null,null,null,$search,true);
                $data['ip_ban_list'] = $this->maccount->get_ipbanlist($cond,$index,$pp,$sort,$search);
            } else {
                $title = "Add New IP";
                $page  = 'dashboard/users/ipbanadd';
            }
        }
        
        $data['crumbs'] = $this->crumbs;
        $data['links']  = $this->get_dash_nav();
        $this->page_build($title,'dashboard',$page,$data);
    }
    
    public function navigation() {
        $this->check_authority();
        $data['links'] = $this->get_dash_nav();
        
        if(!isset($_GET['action'])) {
            $title = "Navigation";
            $page = "dashboard/navs/navs";
            $this->load->model('mnavigation');
            $data['navs'] = $this->mnavigation->get_navs();
        } else {
            switch($_GET['action']) {
                case 'new':
                    if(isset($_POST['desc'])) {
                        $desc = $_POST['desc'];
                        $this->load->model('mnavigation');
                        $newnav = $this->mnavigation->save_nav($desc);
                        if(null != $newnav) {
                            redirect(current_url().'?action=edit&id='.$newnav,'refresh');
                        } else {
                            //Error - Bad Request [error 402]
                            redirect(current_url().'?msgcode=402','refresh');
                        }
                    } else {
                        //Error - Missing/Invalid data [error 401]
                        redirect(current_url().'?msgcode=401','refresh');
                    }
                    break;
                case 'edit':
                    if(isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $this->load->model('mnavigation');
                        $nav = $this->mnavigation->get_navs($id);
                        $nav_li = $this->mnavigation->get_nav_li($id);
                        $title = $nav[0]->description;
                        $page = 'dashboard/navs/editnav';
                        $data['nav'] = $nav;
                        $data['nav_li'] = $nav_li;
                    } else {
                        //Error - Missing/Invalid data [error 401]
                        redirect(current_url().'?msgcode=401','refresh');
                    }
                    break;
                case 'delete':
                    if(isset($_GET['id'])) {
                        $id = $_GET['id'];
                        $this->load->model('mnavigation');
                        $delnav = $this->mnavigation->delete_nav($id);
                        switch($delnav) {
                            case 0:
                                //Error - Bad Request [Error 402]
                                $url = current_url().'?msgcode=402';
                                break;
                            case 1:
                                //Success - Nav Deleted [Success 103]
                                $url = current_url().'?msgcode=103';
                                break;
                            case 2:
                                //Error - Object is in use [Error 403]
                                $url = current_url().'?msgcode=403';
                        }
                        redirect($url,'refresh');
                    }
                default:
                    //Error - Missing/Invalid data [error 401]
            }
        }
        $this->page_build($title,'dashboard',$page,$data);
    }
    
    public function widgets() {
        $this->check_authority();
        
        $this->load->model('mwidget');
        $this->load->model('msettings');
        $gen_settings = $this->msettings->get_set_gen();
        $wid_areas = get_layout_wid_areas($gen_settings[0]->theme);
        
        if(isset($_GET['area'])) {
            $area = $_GET['area'];
            if(in_array_r($area,$wid_areas,FALSE)) {
                $data['links'] = $this->get_dash_nav();
                $data['wid_list'] = $this->mwidget->get_widget_list();
                $data['wid_areas'] = $wid_areas;
                $data['wid_area_wids'] = get_widgets($area);
                
                $title = "Manage Widgets";
                $page = 'dashboard/widgets/widgets';
                $this->page_build($title,'dashboard',$page,$data);
            } else {
                //Error 401 - Invalid/missing data
                $url = current_url().'?area='.$wid_areas[0]['id'].'&msgcode=401';
                redirect($url,'refresh');
            }
        } else {
            $url = current_url().'?area='.$wid_areas[0]['id'];
            redirect($url,'refresh');
        }
    }
    
    public function shop($submod=null) {
        $this->check_authority();
        $data['links'] = $this->get_dash_nav();
        $data['crumbs'] = $this->crumbs;
        
        if(null == $submod) {
            
            if(!isset($_GET['page']))
                $page = 1;
            else 
                $page = $_GET['page'];
                
            $pp = PAGINATION_RPP;
            $index = $pp*($page-1);
            
            $cond = null;
            
            $this->load->model('mshop');
            $this->load->model('msettings');
            
            $gen_settings = $this->msettings->get_set_gen();
            
            if('r' == $gen_settings[0]->emulator){ $weapon_id = 5; } else { $weapon_id = 4; }
            
            if(isset($_GET['cat'])) {
                switch($_GET['cat']) {
                    case 'consume':
                        $cond = array('index'=>'type','val'=>array(0,2,11,18)); break;
                    case 'head':
                        $cond = array('index'=>'equip_locations','val'=>array(1,256,257,512,513,768,769)); break;
                    case 'weapon':
                        $cond = array('index'=>'type','val'=>array($weapon_id)); break;
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
                        $cond = array('index'=>'type','val'=>array(7,8)); break;
                    case 'cards':
                        $cond = array('index'=>'type','val'=>array(6)); break;
                    case 'costumes':
                        $cond = array('index'=>'equip_locations','val'=>array(1024,2048,3072,4096,5120,6144,7168,8192));
                    case 'misc':
                        $cond = array('index'=>'type','val'=>array(3,10)); break;
                }
            }
            
            $data['items'] = $this->mshop->get_shop_items(null,$index,$pp,$cond);
            $data['tp']    = count($this->mshop->get_shop_items(null,null,null,$cond));
            
            $page = 'dashboard/shop/shop';
            $title = "Cash Shop";
            
        } else if(null != $submod && 'add' == $submod) {
            $page = 'dashboard/shop/add';
            $title = "Cash Shop - Add Item";
        } else if (null != $submod && 'edit' == $submod) {
            if(isset($_GET['id'])) {
                $this->load->model('mshop');
                $item         = $this->mshop->get_shop_items($_GET['id']);
                $page         = 'dashboard/shop/edit';
                $title        = 'Cash Shop - Edit Item';
                $data['item'] = $item;
            } else {
                redirect(base_url().'dashboard/shop?msgcode=401','refresh'); // Error 401 - Invalid or missing data
            }
        }
        
        $this->page_build($title,'dashboard',$page,$data);
    }
    
    public function currency() {
        $this->check_authority();
        $data['links'] = $this->get_dash_nav();
        
        if(!isset($_GET['action']))
            redirect(current_url().'?action=v4p','refresh');
        
        switch($_GET['action']) {
            case 'v4p':
                $this->load->model('mcurrency');
                $title = "Vote 4 Points";
                $page = 'dashboard/v4p/v4p';
                $data['v4p_links'] = $this->mcurrency->get_v4p_links();
                break;
            case 'edit_v4p':
                if(isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $this->load->model('mcurrency');
                    $page = 'dashboard/v4p/edit_v4p';
                    $v4p_link = $this->mcurrency->get_v4p_links($id);
                    $title = 'Vote 4 Points - '.$v4p_link[0]->label;
                    $data['v4p_link'] = $v4p_link;
                } else {
                    //Error 401 - invalid/missing data
                    redirect(current_url().'?action=v4p&msgcode=401','refresh');
                }
                break;
            case 'donate':
                $this->load->model('mcurrency');
                $title = "Donate";
                $page = 'dashboard/donate/donate';
                $data['donate_amounts'] = $this->mcurrency->get_donate_amounts();
                break;     
            case 'edit_donate':
                if(isset($_GET['id'])) {
                    $id = $_GET['id'];
                    $this->load->model('mcurrency');
                    $page = 'dashboard/donate/edit_donate';
                    $donate_amount = $this->mcurrency->get_donate_amounts($id);
                    $title = 'Donate - #'.$donate_amount[0]->donate_id;
                    $data['donate_amount'] = $donate_amount;
                } else {
                    //Error 401 - invalid/missing data
                    redirect(current_url().'?action=donate&msgcode=401','refresh');
                }
                break;
            case 'settings':
                $this->load->model('mcurrency');
                $title = "Donate Settings";
                $page = "dashboard/donate/donate_settings";
                $data['cur_settings'] = $this->mcurrency->get_set_cur();
                break;
            default:
                //default action
        }
        $this->page_build($title,'dashboard',$page,$data);
    }
    
    public function settings($submod='general') {
        $this->check_authority();
        $data['links'] = $this->get_dash_nav();
        
        if(null != $submod) {
            switch($submod) {
                case 'general':
                    if(!isset($_GET['action'])) {
                        $this->load->model('mpage');
                        $this->load->model('msettings');
                        $data['pages']    = $this->mpage->mpage->get_pages();
                        $data['settings'] = $this->msettings->get_set_gen();
                        $title = "General Settings";
                        $page = "dashboard/settings/set_general";
                    } else if($_GET['action'] == 'update') {
                        if(isset($_POST['serv_name']) AND isset($_POST['theme'])) {
                            $serv_name = $_POST['serv_name'];
                            $theme =     $_POST['theme'];
                            $emulator =  $_POST['emulator'];
                            
                            if(isset($_POST['capt_pub_key'])){ $capt_pub_key = $_POST['capt_pub_key']; } else { $capt_pub_key = null; }
                            if(isset($_POST['capt_pvt_key'])){ $capt_pvt_key = $_POST['capt_pvt_key']; } else { $capt_pvt_key = null; }
                            if(isset($_POST['const_mode'])) { $const_mode = 1; } else { $const_mode = 0; }
                            
                            $this->load->model('mpage');
                            $this->load->model('msettings');
                            
                            $home = $_POST['homepage'];
                            $tos  = $_POST['tospage'];
                            
                            $up_data = array('serv_name'=>$serv_name,'theme'=>$theme,'homepage'=>$home,'tospage'=>$tos,'emulator'=>$emulator,'capt_pvt_key'=>$capt_pvt_key,'capt_pub_key'=>$capt_pub_key,'const_mode'=>$const_mode);
                            
                            $update = $this->msettings->update_set_gen($up_data);
                            
                            if(true == $update) {
                                $url = current_url().'?msgcode=104';
                            } else {
                                //Error 402 - Bad request
                                $url = current_url().'?msgcode=402';
                            }
                        } else {
                            //Error 401 - Invalid/missing data
                            $url = current_url().'?msgcode=401';
                        }
                        redirect($url,'refresh');
                    } else {
                        //Error 401 - Invalid/missing data
                        redirect(current_url().'?msgcode=401','refresh');
                    }
                    break;
                case 'account':
                    if(!isset($_GET['action'])) {
                        $this->load->model('msettings');
                        $data['settings'] = $this->msettings->get_set_acc();
                        $title = "Account Settings";
                        $page = "dashboard/settings/set_account";
                    } else if($_GET['action'] == 'update') {
                        if(isset($_POST['un_allow_char']) AND isset($_POST['pw_allow_char']) AND isset($_POST['un_format_error']) AND isset($_POST['pw_format_error']) AND isset($_POST['min_age']) AND is_numeric($_POST['min_age'])) {
                            $un_allow_char   = $_POST['un_allow_char'];
                            $pw_allow_char   = $_POST['pw_allow_char'];
                            $un_format_error = $_POST['un_format_error'];
                            $pw_format_error = $_POST['pw_format_error'];
                            $min_age         = $_POST['min_age'];
                            if(isset($_POST['char_res_pos'])) { $char_res_pos = $_POST['char_res_pos']; } else { $char_res_pos = null; }
                            if(isset($_POST['char_no_res'])) { $char_no_res = $_POST['char_no_res']; } else { $char_no_res = null; }
                            if(isset($_POST['req_email_ver'])) { $req_email_ver = 1; } else { $req_email_ver = 0; }
                            if(isset($_POST['sex_allow_change'])) { $sex_allow_change = 1; } else { $sex_allow_change = 0; }
                            if(isset($_POST['bday_allow_change'])) { $bday_allow_change = 1; } else { $bday_allow_change = 0; }
                            if(isset($_POST['email_allow_dupe'])) { $email_allow_dupe = 1; } else { $email_allow_dupe = 0; }
                            if(isset($_POST['un_allow_change'])) { $un_allow_change = 1; } else { $un_allow_change = 0; }
                            if(isset($_POST['req_capt_reg'])) { $req_capt_reg = 1; } else { $req_capt_reg = 0; }
                            if(isset($_POST['use_md5'])) { $use_md5 = 1; } else { $use_md5 = 0; }
                            
                            $this->load->model('msettings');
                            
                            if($req_capt_reg) {
                                $gen_settings = $this->msettings->get_set_gen();
                                if(null == $gen_settings[0]->capt_pvt_key OR null == $gen_settings[0]->capt_pub_key)
                                    redirect(current_url().'?msgcode=418','refresh');
                            }
                            
                            $up_data = array(
                                'un_allow_char' => $un_allow_char, 'pw_allow_char' => $pw_allow_char, 'un_format_error' => $un_format_error, 'pw_format_error' => $pw_format_error,
                                'char_res_pos' => $char_res_pos, 'char_no_res' => $char_no_res, 'min_age' => $min_age, 'req_email_ver' => $req_email_ver, 'sex_allow_change' => $sex_allow_change,
                                'email_allow_dupe' => $email_allow_dupe, 'un_allow_change' => $un_allow_change, 'req_capt_reg' => $req_capt_reg, 'use_md5' => $use_md5, 'bday_allow_change' => $bday_allow_change
                            );
                            
                            $update = $this->msettings->update_set_acc($up_data);
                            
                            if(true == $update) {
                                $url = current_url().'?msgcode=104';
                            } else {
                                //Error 402 - Bad request
                                $url = current_url().'?msgcode=402';
                            }
                        } else {
                            //Error 401 - Missing/invalid data
                            $url = current_url().'?msgcode=401';
                        }
                        redirect($url,'refresh');
                    } else {
                        //Error 401 - Missing/invalid data
                        redirect(current_url().'?msgcode=401','refresh');
                    }
                    break;
                case 'mailing':
                    if(!isset($_GET['action'])) {
                        $this->load->model('msettings');
                        $data['settings'] = $this->msettings->get_set_mail();
                        $title = "Mailing Settings";
                        $page = "dashboard/settings/set_mail";
                    } else if($_GET['action'] == 'update') {
                        if(isset($_POST['active_service'])) {
                            $active_service = $_POST['active_service'];
                            if('SMTP' == $active_service) {
                                if($_POST['smtp_host'] AND $_POST['smtp_port'] AND $_POST['email_smtp'] AND $_POST['userpass']) {
                                    $smtp_host = $_POST['smtp_host']; $smtp_port = $_POST['smtp_port']; $email_smtp = $_POST['email_smtp']; $userpass = $_POST['userpass'];
                                    if(is_numeric($smtp_port)) {
                                        $this->load->model('msettings');
                                        $data = array('active_service'=>$active_service,'smtp_host'=>$smtp_host,'smtp_port'=>$smtp_port,'email_smtp'=>$email_smtp,'userpass'=>$userpass);
                                        $update = $this->msettings->update_set_mail($data);
                                        if(true == $update) {
                                            $url = current_url().'?msgcode=104';
                                        } else {
                                            //Error 402 - Bad request
                                            $url = current_url().'?msgcode=402';
                                        }
                                    } else {
                                        //Error 401 - Missing/invalid data
                                        $url = current_url().'?msgcode=401';
                                    }
                                } else {
                                    //Error 401 - Missing/invalid data
                                    $url = current_url().'?msgcode=401';
                                }
                            } else if('MAIL' == $active_service) {
                                if($_POST['email']) {
                                    $email = $_POST['email'];
                                    $this->load->model('msettings');
                                    $data = array('active_service'=>$active_service,'email'=>$email);
                                    $update = $this->msettings->update_set_mail($data);
                                    if(true == $update) {
                                        $url = current_url().'?msgcode=104';
                                    } else {
                                        //Error 402 - Bad request
                                        $url = current_url().'?msgcode=402';
                                    }
                                } else {
                                    //Error 401 - Missing/invalid data
                                    $url = current_url().'?msgcode=401';
                                }
                            } else {
                                //Error 401 - Missing/invalid data
                                $url = current_url().'?msgcode=401';
                            }
                        } else {
                            //Error 401 - Missing/invalid data
                            $url = current_url().'?msgcode=401';
                        }
                        redirect($url,'refresh');
                    } else {
                        //Error 401 - Missing/invalid data
                        redirect(current_url().'?msgcode=401','refresh');
                    }
                    break;
                case 'admin':
                    $title = 'Admin Profile Settings';
                    $page  = "dashboard/settings/set_admin";
                    
                    $this->load->model('madmin');
                    
                    $data['adm_info'] = $this->madmin->get_admin_info(array('admin_id'=>$this->session->userdata('admin_id')));
                    break;
                default:
                    //Page not found
                    redirect(base_url().'error/not_found','refresh');
            }
        } else {
            redirect(current_url().'/account','refresh');
        }
        
        $this->page_build($title,'dashboard',$page,$data);
    }
    
    public function get_dash_nav() {
        $this->load->model('mdashboard');
        return $this->mdashboard->get_dash_nav();
    }
    
    public function logs($sub=null) {
        $this->check_authority();
        
        $cond   = null;
        $sort   = null;
        $search = null;
        
        if(isset($_GET['search']) AND isset($_GET['query']) AND isset($_GET['field']) AND isset($_GET['sort']) AND isset($_GET['order'])) {
            $query = $_GET['query']; $field = $_GET['field']; $sortB = $_GET['sort']; $order = $_GET['order'];
            
            if(null != $query)
                $cond = array($field=>$query);
            
            $sort = array($sortB,$order);
            
            if(isset($_GET['type']) AND 'all' != $_GET['type']) {
                $cond['type'] = $_GET['type'];
            }
        }
        
        if(!isset($_GET['page']))
            $page = 1;
        else 
            $page = $_GET['page'];
        
        $pp = PAGINATION_RPP;
        $index = $pp*($page-1);
        
        $data          = null;
        $data['links'] = $this->get_dash_nav();
        
        if(null == $sub)
            redirect(base_url().'dashboard/logs/ingame-login','refresh');
        
        $this->load->model('mlogs');
        
        switch($sub) {
            case "ingame-login":
                $title = 'In-Game Login Log';
                $page  = 'dashboard/logs/ingame/login';
                $data['tp']   = $this->mlogs->get_log_login($cond,null,null,null,$search,true);
                $data['logs'] = $this->mlogs->get_log_login($cond,$index,$pp,$sort,$search);
                break;
            case "chat":
                $title = 'Chat Log';
                $page  = 'dashboard/logs/ingame/chat';
                $data['tp']   = $this->mlogs->get_log_chat($cond,null,null,null,$search,true);
                $data['logs'] = $this->mlogs->get_log_chat($cond,$index,$pp,$sort,$search);
                break;
            case "pick":
                $title = 'Pick Log';
                $page  = 'dashboard/logs/ingame/pick';
                $data['tp']   = $this->mlogs->get_log_pick($cond,null,null,null,$search,true);
                $data['logs'] = $this->mlogs->get_log_pick($cond,$index,$pp,$sort,$search);
                break;
            case "zeny":
                $title = 'Zeny Log';
                $page  = 'dashboard/logs/ingame/zeny';
                $data['tp']   = $this->mlogs->get_log_zeny($cond,null,null,null,$search,true);
                $data['logs'] = $this->mlogs->get_log_zeny($cond,$index,$pp,$sort,$search);
                break;
            case "mvp":
                $title = 'MVP Log';
                $page  = 'dashboard/logs/ingame/mvp';
                $data['tp']   = $this->mlogs->get_log_mvp($cond,null,null,null,$search,true);
                $data['logs'] = $this->mlogs->get_log_mvp($cond,$index,$pp,$sort,$search);
                break;
            case "atcommand":
                if(isset($field) AND ('command' == $field OR 'char_name' == $field)) {
                    $cond = null; $search[$field] = $query;
                }
                $title = 'Atcommand Log';
                $page  = 'dashboard/logs/ingame/atcommand';
                $data['tp']   = $this->mlogs->get_log_atcommand($cond,null,null,null,$search,true);
                $data['logs'] = $this->mlogs->get_log_atcommand($cond,$index,$pp,$sort,$search);
                break;
            case "web-login":
                $title = 'Web Login Log';
                $page  = 'dashboard/logs/web/login';
                $data['tp']   = $this->mlogs->get_log_tcp(array('Login'),$cond,null,null,null,$search,true);
                $data['logs'] = $this->mlogs->get_log_tcp(array('Login'),$cond,$index,$pp,$sort,$search);
                break;
            case "ban":
                if(isset($query) AND null != $query AND isset($field) AND 'user1' == $field) {
                    unset($cond['user1']);
                    $search["CONCAT(user1,user1_str)"] = $query;
                }
                $title = 'Ban Log';
                $page  = 'dashboard/logs/web/ban';
                $data['tp']   = $this->mlogs->get_log_tcp(array('Account Ban','Char Ban','IP Ban'),$cond,null,null,null,$search,true);
                $data['logs'] = $this->mlogs->get_log_tcp(array('Account Ban','Char Ban','IP Ban'),$cond,$index,$pp,$sort,$search);
                break;
            case "vote":
                $title = 'Vote Log';
                $page  = 'dashboard/logs/web/vote';
                $data['tp']   = $this->mlogs->get_log_tcp(array('Vote'),$cond,null,null,null,$search,true);
                $data['logs'] = $this->mlogs->get_log_tcp(array('Vote'),$cond,$index,$pp,$sort,$search);
                break;
            case "donate":
                $title = 'Donate Log';
                $page  = 'dashboard/logs/web/donate';
                $data['tp']   = $this->mlogs->get_log_donate($cond,null,null,null,$search,true);
                $data['logs'] = $this->mlogs->get_log_donate($cond,$index,$pp,$sort,$search);
                break;
            case "shop":
                $title = 'Shop Log';
                $page  = 'dashboard/logs/web/shop';
                $data['tp']   = $this->mlogs->get_log_shop($cond,null,null,null,$search,true);
                $data['logs'] = $this->mlogs->get_log_shop($cond,$index,$pp,$sort,$search);
                break;
            case "acc-update":
                $title = 'Account Update Log';
                $page  = 'dashboard/logs/web/account_update';
                $data['tp']   = $this->mlogs->get_log_tcp(array('Account Update'),$cond,null,null,null,$search,true);
                $data['logs'] = $this->mlogs->get_log_tcp(array('Account Update'),$cond,$index,$pp,$sort,$search);
        }
        
        $this->page_build($title,'dashboard',$page,$data);
    }
    
    public function addons($name=null) {
        $this->check_authority();
        
        if(null == $name OR !file_exists(APP_PATH.'/controllers/addons/'.$name.'.php'))
            redirect(base_url().'dashboard','refresh');
        
        $data['links'] = $this->get_dash_nav();
        require_once(APP_PATH.'/controllers/addons/'.$name.'.php');    
    }
}