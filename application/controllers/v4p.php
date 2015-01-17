<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class V4p extends TCP_Controller {
    protected $crumbs = array(array('desc'=>'Home','uri'=>''));
    
    public function index() {
        $this->check_login();
        
        $this->load->model('mcurrency');
        
        $data['v4p_links'] = $this->mcurrency->get_v4p_links();
        $data['crumbs'] =    $this->crumbs;
        $title =             'Vote 4 Points';
        $page =              'currency/vote';
        
        $this->page_build($title,null,$page,$data);
    }
    
    public function vote() {
        $this->check_login();
        
        if(isset($_GET['id'])) {
            $id = $_GET['id'];
            
            $this->load->model('mcurrency');
            $v4p_link = $this->mcurrency->get_v4p_links($id);
            
            if(null != $v4p_link) {
                $account_id = $this->session->userdata('account_id');
                if(null != $account_id) {
                    $link_avail = vote_avail_check($id,$account_id,$v4p_link[0]->cooldown);
                    if(true == $link_avail['is_avail']) {
                        //Add Points, set last vote
                        $vote = $this->mcurrency->update_log($id,$account_id,$v4p_link[0]->value);
                        
                        if($vote) {
                            $url = $v4p_link[0]->url;
                            $this->load->model('mlogs');
                            $log_data = array('type'=>'Vote','user1'=>$account_id,'date'=>date("Y-m-d H:i:s"),'ip'=>$_SERVER['REMOTE_ADDR'],'note'=>$url);
                            $log = $this->mlogs->add_log_tcp($log_data);
                        }
                        else
                            $url = base_url().'v4p?msgcode=402';//Error 402 - bad request
                    } else {
                        //Error 423 - Wait for cooldown
                        $url = base_url().'v4p?msgcode=423';
                    }
                } else {
                    $url = $v4p_link[0]->url;
                }
            } else {
                //Error 401 - Invalid/missing data
                $url = base_url().'v4p?msgcode=401';
            }
        } else {
            //Error 401 - Invalid/missing data
            $url = base_url().'v4p?msgcode=401';
        }
        redirect($url,'refresh');
    }
    
    public function add() {
        $this->check_authority();
        
        if($_POST['label'] AND $_POST['url'] AND $_POST['value']) {
            $label = $_POST['label'];
            $url =   $_POST['url'];
            $value = $_POST['value'];
            
            $this->load->model('mcurrency');
            $add = $this->mcurrency->add_v4p_link($label,$url,$value);
            
            if(true == $add)
                $url = base_url().'dashboard/currency?action=v4p&msgcode=113';
            else
                $url = base_url().'dashboard/currency?action=v4p&msgcode=402';//Error 402 - Bad request
        } else {
            //Error 401 - missing/invalid data
            $url = base_url().'dashboard/currency?action=v4p&msgcode=401';
        }
        
        redirect($url,'refresh');
    }
    
    public function update() {
        $this->check_authority();
        
        if($_POST['id'] AND $_POST['label'] AND $_POST['url'] AND $_POST['value'] AND $_POST['cooldown']) {
            $id =       $_POST['id'];
            $label =    $_POST['label'];
            $url =      $_POST['url'];
            $value =    $_POST['value'];
            $cooldown = $_POST['cooldown'];
            
            if(isset($_POST['image']))
                $image = $_POST['image'];
            else
                $image = null;
            
            $this->load->model('mcurrency');
            $update = $this->mcurrency->update_v4p($id,$label,$url,$value,$cooldown,$image);
            
            if($update)
                $url = base_url().'dashboard/currency?action=v4p&msgcode=114';
            else
                $url = base_url().'dashboard/currency?action=edit_v4p&msgcode=402';//Error 402 - Bad request
        } else {
            //Error 401 - Invalid/missing data
            $url = base_url().'dashboard/currency?action=v4p&msgcode=401';
        }
        
        redirect($url,'refresh');
    }
    
    public function delete() {
        $this->check_authority();
        
        if(isset($_GET['ids'])) {
            $ids = $_GET['ids'];
            
            if(is_array($ids)) {
                $this->load->model('mcurrency');
                $errors = 0;
                foreach($ids as $id) {
                    $delete = $this->mcurrency->delete_v4p($id);
                    if(!$delete)
                        $errors++;
                }
                
                if(0 == $errors) {
                    //Success deleting post [success 102]
                    $url = base_url().'dashboard/currency?action=v4p&msgcode=102';
                } else if(0 < $errors AND $errors < count($ids)) {
                    //Info 201 - Imperfect Execution
                    $url = base_url().'dashboard/currency?action=v4p&msgcode=201';
                } else {
                    //Error - Bad request [error 402]
                    $url = base_url().'dashboard/currency?action=v4p&msgcode=402';
                }
            } else {
                //Error - Missing/Invalid data [error 401]
                $url = base_url().'dashboard/currency?action=v4p&msgcode=401';
            }
        } else {
            //Error - Missing/Invalid data [error 401]
            $url = base_url().'dashboard/currency?action=v4p&msgcode=401';
        }
        
        redirect($url,'refresh');
    }
}
