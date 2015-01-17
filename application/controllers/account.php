<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Account extends TCP_Controller {
    protected $crumbs = array(array('desc'=>'Home','uri'=>''),array('desc'=>'Account','uri'=>'account'));
    
    public function index() {
        $this->check_login();
        
        $url = base_url().'account/profile?id='.$this->session->userdata('account_id');
        redirect($url,'refresh');
    }
    
    public function login() {
        $title = 'Account Login';
        $page = 'account/login';
        $data['crumbs'] = $this->crumbs;
        $this->page_build($title,null,$page,$data);
    }
    
    public function authenticate() {
        $this->load->model('msettings');
        $acc_settings = $this->msettings->get_set_acc();
        
        $username = $_POST['username'];
        $userpass = (!$acc_settings[0]->use_md5 ? $_POST['userpass']:md5($_POST['userpass']));
        
        $this->load->model('maccount');
        $account = $this->maccount->authenticate($username,$userpass);
        
        if(null != $account) {
            $this->session->set_userdata('account_id',$account[0]->account_id);
            $this->session->set_userdata('userid',$account[0]->userid);
            $this->session->set_userdata('group_id',$account[0]->group_id);
            $this->session->set_userdata('sex',$account[0]->sex);
            
            if(isset($_POST['remember']) AND 1 == $_POST['remember']) {
                $cookie_user = array('name' => 'userid', 'value' => $account[0]->userid, 'expire' => '2592000', 'path' => '/');
                $cookie_log  = array('name' => 'login', 'value' => 'true', 'expire' => '2592000', 'path' => '/');
                $this->input->set_cookie($cookie_user);
                $this->input->set_cookie($cookie_log);
            } else {
                delete_cookie('userid');
                delete_cookie('login');
            }
            
            $this->load->model('mlogs');
            $log_data = array('type' => 'Login', 'user1' => $account[0]->account_id, 'date' => date("Y-m-d H:i:s"), 'ip' => $_SERVER['REMOTE_ADDR'], 'note' => 'Account Login');
            $log_insert = $this->mlogs->add_log_tcp($log_data);
            
            $return_value = base_url();
        } else { $return_value = base_url().'account/login?msgcode=404'; }
        
        redirect($return_value,'refresh');
    }
    
    public function profile() {
        $this->check_login();
        
        if(!isset($_GET['id']))
            redirect(current_url().'?id='.$this->session->userdata('account_id'),'refresh');
            
        $account_id = $_GET['id'];
        if(!isset($_GET['action'])) { $action = 'profile'; } else { $action = $_GET['action']; }
        
        $this->load->model('mshop');
        $this->load->model('maccount');
        $this->load->model('msettings');
        
        $profile = $this->maccount->get_profile(array('login.account_id'=>$account_id));
        $set_acc = $this->msettings->get_set_acc();
        
        if(null != $profile) {
            if($this->session->userdata('account_id') == $profile[0]->account_id OR $this->session->userdata('admin_userid')) {
                $title = $profile[0]->fname.' '.$profile[0]->lname;
                $data['crumbs'] = $this->crumbs;
                $data['profile'] = $profile;
                
                switch($action) {
                    case 'profile':
                        $page = 'account/profile';
                        $data['set_acc']         = $set_acc;
                        $data['vote_points']     = $profile[0]->vote_points;
                        $data['donate_points']   = $profile[0]->donate_points;
                        $data['cart_item_count'] = count($this->mshop->get_cart_items($account_id));
                        break;
                    case 'change_pass':
                        $page = 'account/change_pass';
                        break;
                    default:
                        //Error 401 - Invalid/missing data
                }
                
                $this->page_build($title,null,$page,$data);
            } else {
                redirect(base_url().'error/restricted','refresh');
            }
        } else {
            redirect(base_url().'error/not_found','refresh');
        }
    }
    
    public function update() {
        $this->check_login();
        
        if(isset($_POST['account_id']) AND isset($_POST['username']) AND isset($_POST['email']) AND isset($_POST['gender']) AND isset($_POST['fname']) AND isset($_POST['lname']) AND isset($_POST['birthday'])) {
            $account_id = $_POST['account_id']; $username = $_POST['username']; $email = $_POST['email']; $gender = $_POST['gender'];
            $fname = $_POST['fname']; $lname = $_POST['lname']; $birthday = $_POST['birthday'];
            
            if($this->session->userdata('account_id') == $account_id OR $this->session->userdata('admin_userid')) {
                if($_FILES['avatar']['name'] != null) {
                    $avatar = $_FILES['avatar'];
                    $upload = $this->image_upload('avatar',$account_id);
                    if(null != $upload) {
                        //Error 413 - File upload failed
                        redirect(base_url().'account/profile?id='.$account_id.'&msgcode=413','refresh');
                    }
                }
                
                $this->load->model('maccount');
                $this->load->model('msettings');
                
                $acc_set = $this->msettings->get_set_acc();
                
                $old = $this->maccount->get_profile(array('login.account_id'=>$account_id));
                
                if(null == $old)
                    redirect(base_url().'error/restricted','refresh');
                
                $old_username = $old[0]->userid; $old_email = $old[0]->email; $old_fname = $old[0]->fname; $old_lname = $old[0]->lname; $old_gender = $old[0]->sex; $old_birthday = $old[0]->birthday; $old_group = $old[0]->group_id;
                
                $note = null;
                
                if($username != $old_username) {
                    $note .= ' username';
                    $username_avail = $this->maccount->check_detail_avail(array('username',$username));
                    if(0 == $username_avail) {
                        $url = base_url().'account/profile?id='.$account_id.'&msgcode=407'; //Error 407 - Username already taken
                        redirect($url,'refresh');
                    }
                    
                    if(!preg_match($acc_set[0]->un_allow_char,$username)) {
                        $url = base_url().'account/profile?id='.$account_id.'&msgcode=406'; //Error 406 - Invalid username
                        redirect($url,'refresh');
                    }
                }
                
                if(1 == $acc_set[0]->req_email_ver) {
                    if($email != $old_email AND !$this->session->userdata('admin_userid')) {
                        $url = base_url().'account/profile?id='.$account_id.'&msgcode=414'; //Error 414 - Email change not allowed
                        redirect($url,'refresh');
                    }
                }
                
                if($fname != $old_fname){ $note .= ' first_name'; }
                if($lname != $old_lname){ $note .= ' last_name'; }
                
                if(0 == $acc_set[0]->email_allow_dupe) {
                    if($email != $old_email) {
                        $email_avail = $this->maccount->check_detail_avail(array('email',$email));
                        if(0 == $email_avail) {
                            $url = base_url().'account/profile?id='.$account_id.'&msgcode=410'; //Error 410 - Email already taken
                            redirect($url,'refresh');
                        }
                    }
                }
                
                if($email != $old_email){ $note .= ' email'; }
                
                if(0 == $acc_set[0]->sex_allow_change) {
                    if($gender != $old_gender AND !$this->session->userdata('admin_userid')) {
                        $url = base_url().'account/profile?id='.$account_id.'&msgcode=415'; //Error 415 - Gender change not allowed
                        redirect($url,'refresh');
                    }
                }
                
                if($gender != $old_gender) { $note .= ' gender'; }
                
                if($birthday != $old_birthday) {
                    $url = base_url().'account/profile?id='.$account_id.'&msgcode=416'; //Error 416 - Birthday change not allowed
                    redirect($url,'refresh');
                }
                
                if($birthday != $old_birthday){ $note .= ' birthday'; }
                
                $update = $this->maccount->update_profile($account_id,$username,$email,$gender,$fname,$lname,$birthday);
                
                if(true == $update) {
                    if($account_id == $this->session->userdata('account_id')) {
                        $this->session->set_userdata('userid',$username);
                        $this->session->set_userdata('sex',$gender);
                        $this->session->set_userdata('birthdate',$birthday);
                    }
                    
                    $admin_id = (null != $this->session->userdata('admin_id')?$this->session->userdata('admin_id'):null);
                    $this->load->model('mlogs');
                    $log_data = array('type'=>'Account Update','user1'=>$account_id,'user2'=>$admin_id,'date'=>date("Y-m-d H:i:s"),'ip'=>$_SERVER['REMOTE_ADDR'],'note'=>'Updated:'.$note);
                    $log = $this->mlogs->add_log_tcp($log_data);
                    
                    $url = base_url().'account/profile?id='.$account_id.'&msgcode=107';
                } else {
                    $url = base_url().'account/profile?id='.$account_id.'&msgcode=402'; //Error 402 - Bad request
                }
            } else {
                $url = base_url().'error/restricted';
            }
        } else {
            //Error 401 - Invalid/missing data
            $url = base_url().'account/profile?id='.$account_id.'&msgcode=401';
        }
        
        redirect($url,'refresh');
    }
    
    public function change_pass() {
        $this->check_login();
        
        if(isset($_POST['account_id']) AND isset($_POST['new_password']) AND isset($_POST['con_password']) AND (isset($_POST['old_password']) OR $this->session->userdata('admin_userid'))) {
            $account_id = $_POST['account_id']; $new_password = $_POST['new_password']; $con_password = $_POST['con_password'];
            if(isset($_POST['old_password'])){ $old_password = $_POST['old_password']; }
            
            if($this->session->userdata('account_id') == $account_id OR $this->session->userdata('admin_userid')) {
                if($new_password == $con_password) {
                    $this->load->model('maccount');
                    $this->load->model('msettings');
                    $acc_set = $this->msettings->get_set_acc();
                    if(preg_match($acc_set[0]->pw_allow_char,$new_password)) {
                        $correct_password = $this->maccount->get_password($account_id);
                        
                        if(1 == $acc_set[0]->use_md5){ $old_password = md5($old_password); $new_password = md5($new_password); }
                        
                        if($this->session->userdata('admin_userid') OR $old_password == $correct_password[0]->user_pass) {
                            $update_pass = $this->maccount->update_password($account_id,$new_password);
                            if(true == $update_pass) {
                                $admin_id = (null != $this->session->userdata('admin_id')?$this->session->userdata('admin_id'):null);
                                $this->load->model('mlogs');
                                $log_data = array('type'=>'Account Update','user1'=>$account_id,'user2'=>$admin_id,'date'=>date("Y-m-d H:i:s"),'ip'=>$_SERVER['REMOTE_ADDR'],'note'=>'Updated: password');
                                $this->mlogs->add_log_tcp($log_data);
                                $url = base_url().'account/profile?id='.$_POST['account_id'].'&action=change_pass&msgcode=108';
                            } else {
                                //Error 402 - Bad request
                                $url = base_url().'account/profile?id='.$_POST['account_id'].'&action=change_pass&msgcode=402';
                            }
                        } else {
                            //Error 417 - Incorrect password
                            $url = base_url().'account/profile?id='.$_POST['account_id'].'&action=change_pass&msgcode=417';
                        }
                    } else {
                        //Error 408 - Invalid password
                        $url = base_url().'account/profile?id='.$_POST['account_id'].'&action=change_pass&msgcode=408';
                    }
                } else {
                    //Error 409 - Password mismatch
                    $url = base_url().'account/profile?id='.$_POST['account_id'].'&action=change_pass&msgcode=409';
                }
            } else {
                $url = base_url().'error/restricted';
            }
        } else {
            //Error 401 - Invalid/missing data
            $url = base_url().'account/profile?id='.$_POST['account_id'].'&action=change_pass&msgcode=401';
        }
        
        redirect($url,'refresh');
    }
    
    public function characters() {
        $this->check_login();
        
        if(!isset($_GET['id']))
            redirect(current_url().'?id='.$this->session->userdata('account_id'));
        
        $account_id = $_GET['id'];
        
        if($this->session->userdata('account_id') == $account_id OR $this->session->userdata('admin_userid')) {
            $this->load->model('maccount');
            $this->load->model('msettings');
            $acc_set = $this->msettings->get_set_acc();
            $profile = $this->maccount->get_profile(array('login.account_id'=>$account_id));
            $charaters = $this->maccount->get_characters(array('account_id'=>$account_id));
            $title = $profile[0]->fname.' '.$profile[0]->lname;
            $page = 'account/characters';
            
            if(isset($_GET['index'])) {
                $index = $_GET['index'];
                if(0 > $index OR count($charaters) <= $index) 
                    redirect(current_url().'?id='.$account_id.'&msgcode=401','refresh'); //Error 401 - Invalid/missing data
            }
            $data['acc_set'] = $acc_set;
            $data['crumbs'] = $this->crumbs;
            $data['profile'] = $profile;
            $data['chars'] = $charaters;
        } else {
            $url = base_url().'error/restricted';
            redirect($url,'refresh');
        }
        
        $this->page_build($title,null,$page,$data);
    }
    
    public function reset_position() {
        $this->check_login();
        
        if(!isset($_GET['id']) OR !isset($_GET['charid']) OR !isset($_GET['index']))
            redirect(base_url().'account/characters?id='.$this->session->userdata('account_id').'&msgcode=401','refresh');
            
        $account_id = $_GET['id'];
        $char_id = $_GET['charid'];
        $index = $_GET['index'];
        
        if($this->session->userdata('account_id') == $account_id OR $this->session->userdata('admin_userid')) {
            $this->load->model('maccount');
            $this->load->model('msettings');
            
            $acc_set = $this->msettings->get_set_acc();
            //Check if reset position is enabled
            if(null != $acc_set[0]->char_res_pos) {
                $res_post = explode(',',$acc_set[0]->char_res_pos);
                $x_pos = $res_post[1];
                $y_pos = $res_post[2];
                $map = $res_post[0];
                
                $ban_maps = explode(',',$acc_set[0]->char_no_res);
                
                $cond = array('char.char_id'=>$char_id,'account_id'=>$account_id);
                $char = $this->maccount->get_characters($cond);
                //Check if char exist
                if(null != $char) {
                    $last_map = $char[0]->last_map;
                    if(!in_array($last_map,$ban_maps)) {
                        $cond = array('account_id'=>$account_id,'char_id'=>$char_id);
                        $data = array('last_map'=>$map,'last_x'=>$x_pos,'last_y'=>$y_pos);
                        
                        $update_char = $this->maccount->update_character($cond,$data);
                        
                        if(true == $update_char)
                            $url = base_url().'account/characters?id='.$account_id.'&index='.$index.'&msgcode=109';
                    } else {
                        //Error 420 - No reset from current map
                        $url = base_url().'account/characters?id='.$account_id.'&index='.$index.'&msgcode=420';
                    }
                } else {
                    //Error 401 - Invalid/missing data
                    $url = base_url().'account/characters?id='.$account_id.'&index='.$index.'&msgcode=401';
                }
            } else {
                //Error 419 - Position reset disabled
                $url = base_url().'account/characters?id='.$account_id.'&index='.$index.'&msgcode=419';
            }
        } else {
            $url = base_url().'error/restricted';
        }
        
        redirect($url,'refresh');
    }
    
    public function register() {
        if($this->session->userdata('account_id'))
            redirect(base_url().'account','refresh');
        
        if(isset($_GET['success']) AND 1 == $_GET['success'] AND isset($_GET['email']) AND $_GET['email']) {
            $title         = 'Success';
            $page          = 'account/success';
            $data['email'] = $_GET['email']; 
        } else {
            $this->load->model('msettings');
            $data['set_gen'] = $this->msettings->get_set_gen(); 
            $data['set_acc'] = $this->msettings->get_set_acc(); 
            
            $title = 'Register';
            $page = 'account/register';
        }
        
        $data['crumbs'] = $this->crumbs;
        $this->page_build($title,null,$page,$data);
    }
    
    public function create() {
        if($this->session->userdata('account_id'))
            redirect(base_url().'account','refresh');
            
        $username =     $_POST['username'];
        $userpass =     $_POST['userpass'];
        $con_userpass = $_POST['con-userpass'];
        $email =        $_POST['email'];
        $fname =        $_POST['fname'];
        $lname =        $_POST['lname'];
        $birthday =     $_POST['birthday'];
        $gender =       $_POST['gender'];
        
        if($username AND $userpass AND $con_userpass AND $email AND $fname AND $lname AND $birthday AND $gender) {
            if(isset($_POST['agreetos']) AND $_POST['agreetos'] == TRUE) {
                $this->load->model('maccount');
                $this->load->model('msettings');
                
                $acc_settings = $this->msettings->get_set_acc();
                $gen_settings = $this->msettings->get_set_gen();
                //Check username validity
                if(preg_match($acc_settings[0]->un_allow_char,$username)) {
                    $user_avail = $this->maccount->check_detail_avail(array('username',$username));
                    if(1 == $user_avail) {
                        if(preg_match($acc_settings[0]->pw_allow_char,$userpass)) {
                            if($userpass == $con_userpass) {
                                //Check for email availability
                                if($acc_settings[0]->email_allow_dupe == 0) {
                                    $email_avail = $this->maccount->check_detail_avail(array('email',$email));
                                    if(0 == $email_avail)
                                        redirect(base_url().'account/register?msgcode=410','refresh'); //Error 410 - Email unavailable
                                }
                                
                                //Check for age requirement
                                if($acc_settings[0]->min_age > 0) {
                                    $age = $this->get_age($birthday);
                                    if($age < $acc_settings[0]->min_age)
                                        redirect(base_url().'account/register?msgcode=411','refresh');
                                }
                                
                                //Validate recaptcha
                                if(0 != $acc_settings[0]->req_capt_reg) {
                                    $privatekey = $gen_settings[0]->capt_pvt_key;
                                    $capt_ch_field = $_POST['recaptcha_challenge_field'];
                                    $capt_res_field = $_POST['recaptcha_response_field'];
                                    $is_capt_valid = $this->validate_captcha($privatekey,$capt_ch_field,$capt_res_field);
                                    
                                    if($is_capt_valid == false) {
                                        redirect(base_url().'account/register?msgcode=412','refresh');
                                    }
                                }
                                
                                if(1 == $acc_settings[0]->use_md5) { $userpass = md5($userpass); }
                                
                                if(1 == $acc_settings[0]->req_email_ver) {
                                    //If email verification is required -- email verification
                                    $create_temp = $this->maccount->create_temp($username,$userpass,$email,$gender,$fname,$lname,$birthday);
                                    if(null != $create_temp) {
                                        $mail_settings = $this->msettings->get_set_mail();
                                        $to            = $email;
                                        $subject       = mail_values('reg_subject');
                                        $data          = array($gen_settings[0]->serv_name,base_url(),$create_temp[0],$create_temp[1],$fname);
                                        $msg           = mail_values('reg_msg',$data);
                                        
                                        if('SMTP' == $mail_settings[0]->active_service)
                                            $send = $this->send_mail_smtp($mail_settings[0]->smtp_host,$mail_settings[0]->smtp_port,$mail_settings[0]->email_smtp,$mail_settings[0]->userpass,$to,$subject,$msg);
                                        else
                                            $send = $this->send_php_mail($gen_settings[0]->serv_name,$mail_settings[0]->email,$to,$subject,$msg);
                                            
                                        $url = base_url().'account/register?success=1&email='.$email;
                                    } else {
                                        //Error 402 - Bad request
                                        $url = base_url().'account/register?msgcode=402';
                                    }
                                } else {
                                    //If email verification is not required -- user creation
                                    $create_profile = $this->maccount->create_profile($username,$userpass,$email,$gender,$fname,$lname,$birthday);
                                    if(true == $create_profile)
                                        $url = base_url().'account/login?msgcode=106';
                                    else
                                        $url = base_url().'account/register?msgcode=402'; //Error 402 - Bad request
                                }
                            } else {
                                //Error 409 - Password mismatch
                                $url = base_url().'account/register?msgcode=409';
                            }
                        } else {
                            //Error 408 - Invalid password
                            $url = base_url().'account/register?msgcode=408';
                        }
                    } else {
                        //Error 407 - Username taken
                        $url = base_url().'account/register?msgcode=407';
                    }
                } else {
                    //Error 406 - Invalid username
                    $url = base_url().'account/register?msgcode=406';
                }
            } else {
                //Error 405 - Disagreement with TOS
                $url = base_url().'account/register?msgcode=405';
            }
        } else {
            //Error 401 - Missing/Invalid Data
            $url = base_url().'account/register?msgcode=401';
        }
        
        redirect($url,'refresh');
    }
    
    public function verify() {
        if(isset($_GET['id']) AND isset($_GET['code'])) {
            $id = $_GET['id']; $code = $_GET['code'];
            $this->load->model('maccount');
            $temp_data = $this->maccount->get_temp(array('register_id'=>$id, 'code'=>$code));
            if(null != $temp_data) {
                $username = $temp_data[0]->userid; $userpass = $temp_data[0]->userpass; $email = $temp_data[0]->email; $sex = $temp_data[0]->sex;
                $fname = $temp_data[0]->fname; $lname = $temp_data[0]->lname; $birthday = $temp_data[0]->birthday;
                
                $create_profile = $this->maccount->create_profile($username,$userpass,$email,$sex,$fname,$lname,$birthday);
                if(true == $create_profile) {
                    $del_temp = $this->maccount->del_temp($id);
                    $url = base_url().'account/login?msgcode=106';
                } else {
                    //Error 402 - Bad request
                    $url = current_url.'?msgcode=402';
                }
            } else {
                //Error 401 - Invalid/missing data
                $url = current_url().'?msgcode=401';
            }
            
            redirect($url,'refresh');
        } else {
            $title = 'Account Verification';
            $page = 'account/verify';
            $data['crumbs'] = $this->crumbs;
            $this->page_build($title,null,$page,$data);
        }
    }
    
    public function resend() {
        if(isset($_POST['email']) AND $_POST['email'] AND isset($_POST['userid']) AND $_POST['userid']) {
            $email  = $_POST['email'];
            $userid = $_POST['userid'];
            
            $this->load->model('maccount');
            $this->load->model('msettings');
            $temp_data = $this->maccount->get_temp(array('email'=>$email, 'userid'=>$userid));
            
            if(null != $temp_data) {
                $gen_settings  = $this->msettings->get_set_gen();
                $mail_settings = $this->msettings->get_set_mail();
                
                $to      = $email;
                $subject = mail_values('reg_subject');
                $data    = array($gen_settings[0]->serv_name,base_url(),$temp_data[0]->register_id,$temp_data[0]->code,$temp_data[0]->fname);
                $msg     = mail_values('reg_msg',$data);
                
                if('SMTP' == $mail_settings[0]->active_service)
                    $send = $this->send_mail_smtp($mail_settings[0]->smtp_host,$mail_settings[0]->smtp_port,$mail_settings[0]->email_smtp,$mail_settings[0]->userpass,$to,$subject,$msg);
                else
                    $send = $this->send_php_mail($gen_settings[0]->serv_name,$mail_settings[0]->email,$to,$subject,$msg);
                
                if($send)
                    $url = 'account/resend?success=1&email='.$email;
                else
                    $url = 'account/resend?msgcode=402'; // Error 402 - Bad request
            } else {
                $url = 'account/resend?msgcode=401'; // Error 401 - Invalid or missing data
            }
            
            redirect(base_url().$url,'refresh');
        } else if(isset($_GET['success']) AND 1 == $_GET['success'] AND isset($_GET['email']) AND $_GET['email']) {
            $title         = 'Success';
            $page          = 'account/success';
            $data['email'] = $_GET['email'];
        } else {
            $title = 'Resend Verification';
            $page  = 'account/resend';
        }
        
        $data['crumbs'] = $this->crumbs;
        $this->page_build($title,null,$page,$data);
    }
    
    public function forgot() {
        if(isset($_POST['email']) AND $_POST['email'] AND isset($_POST['userid']) AND $_POST['userid']) {
            $email  = $_POST['email'];
            $userid = $_POST['userid'];
            
            $this->load->model('maccount');
            $this->load->model('msettings');
            
            $profile = $this->maccount->get_profile(array('userid'=>$userid, 'email'=>$email));
            
            if(null != $profile) {
                $password      = $this->maccount->get_password($profile[0]->account_id);
                $acc_settings  = $this->msettings->get_set_acc();
                $gen_settings  = $this->msettings->get_set_gen();
                $mail_settings = $this->msettings->get_set_mail();
                
                if(0 == $acc_settings[0]->use_md5) {
                    $subject = mail_values('forgot_subject');
                    $data    = array($password[0]->user_pass,$gen_settings[0]->serv_name,base_url());
                    $msg     = mail_values('forgot_msg',$data);
                } else {
                    $account_id = $profile[0]->account_id;
                    $pass_res   = $this->maccount->get_pass_res(array('account_id'=>$account_id));
                    
                    if(null == $pass_res) {
                        $code = random_string('alnum',20);
                        $add_pass_res = $this->maccount->add_pass_res(array('account_id'=>$account_id,'code'=>$code,'date'=>date("Y-m-d H:i:s"),'ip'=>$_SERVER['REMOTE_ADDR']));
                    } else {
                        $code = $pass_res[0]->code;
                    }
                    
                    $subject = mail_values('recovery_subject');
                    $data    = array($account_id,$code,$gen_settings[0]->serv_name,base_url());
                    $msg     = mail_values('recovery_msg',$data);
                }
                
                if('SMTP' == $mail_settings[0]->active_service)
                    $send = $this->send_mail_smtp($mail_settings[0]->smtp_host,$mail_settings[0]->smtp_port,$mail_settings[0]->email_smtp,$mail_settings[0]->userpass,$email,$subject,$msg);
                else
                    $send = $this->send_php_mail($gen_settings[0]->serv_name,$mail_settings[0]->email,$email,$subject,$msg);
                    
                $url = 'account/forgot?success=1&email='.$email;
            } else {
                $url = 'account/forgot?msgcode=401'; // Error 401 - Invalid or missing data
            }
            
            redirect(base_url().$url,'refresh');
        } else if(isset($_GET['success']) AND 1 == $_GET['success'] AND isset($_GET['email']) AND $_GET['email']) {
            $title         = 'Success';
            $page          = 'account/success';
            $data['email'] = $_GET['email'];
        } else {
            $title = 'Forgot Password';
            $page  = 'account/forgot';
        }
        
        $data['crumbs'] = $this->crumbs;
        $this->page_build($title,null,$page,$data);
    }
    
    public function password_recovery() {
        $data['crumbs'] = $this->crumbs;
        $title = 'Reset Password';
        if(isset($_GET['id']) AND $_GET['id'] AND isset($_GET['code']) AND $_GET['code']) {
            $id = $_GET['id']; $code = $_GET['code'];
            $this->load->model('maccount');
            $pass_res = $this->maccount->get_pass_res(array('account_id'=>$id,'code'=>$code));
            
            if(null != $pass_res)
                $page = 'account/reset_pass2';
            else
                redirect(base_url().'account/password_recovery?msgcode=401','refresh');
        } else if(isset($_POST['reset']) AND isset($_POST['new_pass']) AND isset($_POST['con_pass']) AND isset($_POST['id']) AND isset($_POST['code'])) {
            $id       = $_POST['id'];
            $code     = $_POST['code'];
            $new_pass = $_POST['new_pass'];
            $con_pass = $_POST['con_pass'];
            
            $this->load->model('maccount');
            $this->load->model('msettings');
            
            $acc_settings = $this->msettings->get_set_acc();
            
            if($new_pass != $con_pass) {
                redirect(base_url().'account/password_recovery?id='.$id.'&code='.$code.'&msgcode=409','refresh'); // Error 409 - Password does not match
            }
            
            if(preg_match($acc_settings[0]->pw_allow_char,$new_pass)) {
                if(1 == $acc_settings[0]->use_md5){ $new_pass = md5($new_pass); }
                $update_pass = $this->maccount->update_password($id,$new_pass);
                
                if($update_pass) {
                    $delete_code = $this->maccount->del_pass_res(array('account_id'=>$id,'code'=>$code));
                    redirect(base_url().'account/login?msgcode=106','refresh');
                } else {
                    redirect(base_url().'account/password_recovery?id='.$id.'&code='.$code.'&msgcode=402','refresh'); // Error 402 - Bad request
                }
            } else {
                redirect(base_url().'account/password_recovery?id='.$id.'&code='.$code.'&msgcode=408','refresh'); // Error 408 - Password does not follow format
            }
        } else {
            $page = 'account/reset_pass';
        }
        
        $this->page_build($title,null,$page,$data);
    }
    
    public function logout() {
        $return_value = base_url();
        $unset_session = array('account_id'=>'','user_id'=>'','group_id'=>'','sex'=>'');
        $this->session->unset_userdata($unset_session);
        $cookie_log  = array('name' => 'login', 'value' => 'false', 'expire' => '2592000', 'path' => '/');
        $this->input->set_cookie($cookie_log);
        redirect($return_value,'refresh');
    }
    
    public function ban() {
        $this->check_authority();
        
        $mode = $_POST['mode'];
        
        if('user' == $mode)
            $module = 'users';
        else
            $module = 'users/characters';
        
        if(isset($_POST['ban_id']) AND isset($_POST['ban_date']) AND isset($_POST['ban_time'])) {
            $ids      = $_POST['ban_id'];
            $ban_date = $_POST['ban_date'];
            $ban_time = $_POST['ban_time'];
            $ban_datetime = strtotime($ban_date.' '.$ban_time);
            $now_datetime = strtotime(date("Y-m-d H:i:s",time()));
            
            $ids_string = "";
            foreach($ids as $id) {
                $ids_string.="&ids%5B%5D=".$id;
            }
            
            if($now_datetime < $ban_datetime) {
                if(is_array($ids) AND !empty($ids)) {
                    $this->load->model('maccount');
                    $errors = 0;
                    $this->load->model('mlogs');
                    $admin_id = $this->session->userdata('admin_id');
                    foreach($ids as $id) {
                        if('user' == $mode)
                            $exist = $this->maccount->get_profile(array('login.account_id'=>$id));
                        else
                            $exist = $this->maccount->get_characters(array('char.char_id'=>$id));
                            
                        if(null != $exist) {
                                
                            if('user' == $mode) {
                                $ban = $this->maccount->ban_user($id,$ban_datetime);
                                $log_data = array('type'=>'Account Ban','user1'=>$id,'user2'=>$admin_id,'date'=>date("Y-m-d H:i:s"),'ip'=>$_SERVER['REMOTE_ADDR'],'note'=>'DURATION: '.$ban_date.' '.$ban_time);
                            } else {
                                $ban = $this->maccount->ban_char($id,$ban_datetime);
                                $log_data = array('type'=>'Char Ban','user1'=>$id,'user2'=>$admin_id,'date'=>date("Y-m-d H:i:s"),'ip'=>$_SERVER['REMOTE_ADDR'],'note'=>'DURATION: '.$ban_date.' '.$ban_time);
                            }
                            
                            if(false == $ban)
                                $errors++;
                            else
                                $log = $this->mlogs->add_log_tcp($log_data);
                        } else {
                            continue;
                        }
                    }
                    if(0 == $errors)
                        $url = base_url().'dashboard/'.$module.'?msgcode=110';
                    else if(0 < $errors AND $errors < count($ids))
                        $url = base_url().'dashboard/'.$module.'?action=ban'.$ids_string.'&msgcode=201'; //Info 201 - Imperfect execution
                    else if($errors == count($ids))
                        $url = base_url().'dashboard/'.$module.'?action=ban'.$ids_string.'&msgcode=402'; //Error 402 - Bad reqiest
                } else {
                    //Error 401 - Invalid/missing data
                    $url = base_url().'dashboard/'.$module.'?action=ban'.$ids_string.'&msgcode=401';
                }
            } else {
                //Error 422 - Invalid ban time
                $url = base_url().'dashboard/'.$module.'?action=ban'.$ids_string.'&msgcode=422';
            }
        } else {
            //Error 401 - Invalid/missing data
            $url = base_url().'dashboard/'.$module.'?action=ban'.$ids_string.'&msgcode=401';
        }
        redirect($url,'refresh');
    }
    
    public function unban() {
        $this->check_authority();
        
        $mode = $_POST['mode'];
        
        if('user' == $mode)
            $module = 'users';
        else
            $module = 'users/characters';
        
        if(isset($_POST['unban_id'])) {
            $ids = $_POST['unban_id'];
            
            $ids_string = "";
            foreach($ids as $id) {
                $ids_string.="&ids%5B%5D=".$id;
            }
            
            if(is_array($ids) AND !empty($ids)) {
                $this->load->model('maccount');
                $errors = 0;
                foreach($ids as $id) {
                    if('user' == $mode)
                        $exist = $this->maccount->get_profile(array('login.account_id'=>$id));
                    else
                        $exist = $this->maccount->get_characters(array('char.char_id'=>$id));
                    if(null != $exist) {
                        if('user' == $mode)
                            $unban = $this->maccount->unban_user($id);
                        else
                            $unban = $this->maccount->unban_char($id);
                            
                        if(false == $unban)
                            $errors++;
                    } else {
                        continue;
                    }
                }
                if(0 == $errors)
                    $url = base_url().'dashboard/'.$module.'?msgcode=111';
                else if(0 < $errors AND $errors < count($ids))
                    $url = base_url().'dashboard/'.$module.'?action=unban'.$ids_string.'&msgcode=201'; //Info 201 - Imperfect execution
                else if($errors == count($ids))
                    $url = base_url().'dashboard/'.$module.'?action=unban'.$ids_string.'&msgcode=402'; //Error 402 - Bad request
            } else {
                //Error 401 - Invalid/missing data
                $url = base_url().'dashboard/'.$module.'?action=unban'.$ids_string.'&msgcode=401';
            }
        } else {
            //Error 401 - Invalid/missing data
            $url = base_url().'dashboard/'.$module.'?action=unban'.$ids_string.'&msgcode=401';
        }
        redirect($url,'refresh');
    }
    
    public function delete() {
        $this->check_authority();
        
        $mode = $_GET['mode'];
        
        if('user' == $mode)
            $module = 'users';
        else if('char' == $mode)
            $module = 'users/characters';
        else if('ipban' == $mode)
            $module = 'users/ip_ban_list';
            
        if(isset($_GET['ids'])) {
            $ids = $_GET['ids'];
            
            if(is_array($ids) AND !empty($ids)) {
                $this->load->model('maccount');
                $errors = 0;
                foreach($ids as $id) {
                    if('user' == $mode)
                        $delete = $this->maccount->delete_user($id);
                    else if('char' == $mode)
                        $delete = $this->maccount->delete_char($id);
                    else if('ipban' == $mode)
                        $delete = $this->maccount->delete_ipban($id);
                        
                    if(false == $delete)
                        $errors++;
                }
                if(0 == $errors)
                    $url = base_url().'dashboard/'.$module.'?msgcode=112';
                else if(0 < $errors AND $errors < count($ids))
                    $url = base_url().'dashboard/'.$module.'?msgcode=201'; //Info 201 - Imperfect execution
                else if($errors == count($ids))
                    $url = base_url().'dashboard/'.$module.'?msgcode=402'; //Error 402 - Bad request
            } else {
                //Error 401 - Invalid/missing data
                $url = base_url().'dashboard/'.$module.'?msgcode=401';
            }
        }
        redirect($url,'refresh');
    }
    
    public function ip_ban_add() {
        $this->check_authority();
        
        if(isset($_GET['ip']) AND isset($_GET['ban_date']) AND isset($_GET['ban_time'])) {
            $ip   = $_GET['ip'];
            $date = $_GET['ban_date'].' '.$_GET['ban_time'];
            
            if(isset($_GET['reason'])){ $reason = $_GET['reason']; } else { $reason = null; }
            
            $cur_date = date("Y-m-d H:i:s");
            
            if($date > $cur_date) {
                $this->load->model('maccount');
                $cond = array('list'=>$ip);
                $is_ip_banned = $this->maccount->get_ipbanlist($cond);
                if(null == $is_ip_banned) {
                    $ban = $this->maccount->add_ipbanlist($ip,$date,$reason);
                    if($ban) {
                        $url  = 'dashboard/users/ip_ban_list?msgcode=119';
                        $note = 'DURATION: '.$date.'<br />'.'REASON: '.$reason;
                        $admin_id = $this->session->userdata('admin_id');
                        $this->load->model('mlogs');
                        $log_data = array('type'=>'IP Ban','user1_str'=>$ip,'user2'=>$admin_id,'date'=>date("Y-m-d H:i:s"),'ip'=>$_SERVER['REMOTE_ADDR'],'note'=>$note);
                        $log = $this->mlogs->add_log_tcp($log_data);
                    } else {
                        $url = 'dashboard/users/ip_ban_list?action=new&msgcode=402';
                    }
                } else {
                    $url = 'dashboard/users/ip_ban_list?action=new&msgcode=429';
                }
            } else {
                $url = 'dashboard/users/ip_ban_list?action=new&msgcode=422';
            }
        }
        
        redirect(base_url().$url,'refresh');
    }
}