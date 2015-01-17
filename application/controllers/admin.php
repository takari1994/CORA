<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Admin extends TCP_Controller {
    
    public function index() {
        if($this->session->userdata('admin_userid'))
            redirect(base_url().'dashboard/posts','refresh');
        else
            redirect(base_url().'admin/login','refresh');
    }
    
    public function login() {
        if($this->session->userdata('admin_userid'))
            redirect(base_url().'dashboard/posts','refresh');
        else
            $this->load->view("pages/admin_login.php");
    }
    
    public function authenticate() {
        if($_POST['submit']) {
            $userid = $_POST['userid'];
            $userpw = $_POST['userpw'];
            
            $this->load->model('madmin');
            
            $auth = $this->madmin->authenticate(array('ad_userid'=>$userid,'ad_userpw'=>md5($userpw)));
            
            if($auth) {
                $data   = array('last_login'=>date('Y-m-d H:i:s'),'last_ip'=>$_SERVER['REMOTE_ADDR']);
                $update = $this->madmin->update($data);
                $admin_data = $this->madmin->get_admin_info(array('ad_userid'=>$userid));
                $admin_session_data = array(
                    'admin_id' => $admin_data[0]->admin_id,
                    'admin_userid' => $admin_data[0]->ad_userid
                );
                $this->session->set_userdata($admin_session_data);
                
                $admin_id = $admin_data[0]->admin_id;
                $this->load->model('mlogs');
                $log_data = array('type'=>'Login','user1'=>$admin_id,'date'=>date("Y-m-d H:i:s"),'ip'=>$_SERVER['REMOTE_ADDR'],'note'=>'Admin Login');
                $this->mlogs->add_log_tcp($log_data);
                
                $url    = 'dashboard/posts';
            } else {
                $url = 'admin/login?msgcode=404';
            }
        } else {
            $url = 'admin/login?msgcode=401';
        }
        
        redirect(base_url().$url,'refresh');
    }
    
    public function update() {
        $this->check_authority();
        
        $this->load->model('madmin');
        
        if($_POST['submit']) {
            $userid   = $_POST['userid'];
            $dispname = $_POST['disp_name'];
            
            $data   = array('ad_userid'=>$userid,'disp_name'=>$dispname);
            
            if(isset($_POST['change_pass']) AND 1 == $_POST['change_pass']) {
                if($_POST['useropw'] AND $_POST['usernpw'] AND $_POST['usercpw']){
                    $useropw = $_POST['useropw'];
                    $usernpw = $_POST['usernpw'];
                    $usercpw = $_POST['usercpw'];
                    $ad_info = $this->madmin->get_admin_info(array('ad_userid'=>$this->session->userdata('ad_userid')));
                    
                    if($ad_info[0]->ad_userpw == md5($useropw)) {
                        if($usernpw == $usercpw) 
                            $data['ad_userpw'] = md5($usernpw);
                        else
                            redirect(base_url().'dashboard/settings/admin?msgcode=409','refresh');
                    } else {
                        redirect(base_url().'dashboard/settings/admin?msgcode=417','refresh');
                    }
                } else {
                    redirect(base_url().'dashboard/settings/admin?msgcode=401','refresh');
                }
            }
            
            $update = $this->madmin->update($data);
            
            if($update) {
                $this->session->set_userdata('admin_userid',$userid);
                $url = 'dashboard/settings/admin?msgcode=107';
            } else {
                $url = 'dashboard/settings/admin?msgcode=401';
            }
            
            redirect(base_url().$url,'refresh');    
        }
    }
    
    public function logout() {
        $this->session->unset_userdata('admin_id');
        $this->session->unset_userdata('admin_userid');
        redirect(base_url(),'refresh');
    }
}
