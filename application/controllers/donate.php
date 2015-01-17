<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Donate extends TCP_Controller {
    protected $url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';
    protected $crumbs = array(array('desc'=>'Home','uri'=>''));
    
    public function index() {
        $this->check_login();
        $this->load->model('mcurrency');
        
        $cur_settings =           $this->mcurrency->get_set_cur();
        $data['donate_amounts'] = $this->mcurrency->get_donate_amounts();
        $data['cur_settings'] =   $cur_settings;
        $data['crumbs'] =         $this->crumbs;
        $title =                  'Donate';
        $page =                   'currency/donate';
        
        if(1 == $cur_settings[0]->use_sandbox) { $data['pp_domain'] = 'sandbox.paypal'; } else { $data['pp_domain'] = 'paypal'; }
        
        $this->page_build($title,null,$page,$data);        
    }
    
    public function verify() {
        $raw_post_data =  file_get_contents('php://input');
        $raw_post_array = explode('&', $raw_post_data);
        $myPost = array();
        
        foreach($raw_post_array as $keyval) {
            $keyval = explode('=', $keyval);
            if(count($keyval) == 2)
                $myPost[$keyval[0]] = urldecode($keyval[1]);
        }
        
        $req = 'cmd=_notify-validate';
        if(function_exists('get_magic_quotes_gpc')) {
            $get_magic_quotes_exists = true;
        }
        foreach($myPost as $key => $value) {
            if($get_magic_quotes_exists == true && get_magic_quotes_gpc() == 1) { 
                 $value = urlencode(stripslashes($value)); 
            } else {
                 $value = urlencode($value);
            }
            $req .= "&$key=$value";
        }
        
        $ch = curl_init($this->url);
        curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
        
        if( !($res = curl_exec($ch)) ) {
            // error_log("Got " . curl_error($ch) . " when processing IPN data");
            curl_close($ch);
            exit;
        }
        curl_close($ch);
        
        if (strcmp ($res, "VERIFIED") == 0) {
            $payment_status =   $_POST['payment_status'];
            $payment_amount =   intval($_POST['mc_gross']);
            $payment_currency = $_POST['mc_currency'];
            $account_id =       $_POST['custom'];
            $payer_ip =         $_SERVER['REMOTE_ADDR'];
                
            if(null != $account_id) {
                $payer_id = $this->session->userdata('account_id');
                $this->load->model('mcurrency');
                
                $amount_tbl = array();
                $amounts =    $this->mcurrency->get_donate_amounts();
                $reward =     0;
                $date =       date("Y-m-d H:i:s");
                
                foreach($amounts as $amount) {
                    if($amount->amount == $payment_amount)
                        $reward = $amount->value;
                }
                
                $update_log = $this->mcurrency->update_donate_log($account_id,$payment_amount,$payment_currency,$date,$payer_ip,$reward);
            }
            
        } else if (strcmp ($res, "INVALID") == 0) {
            // IPN invalid, log for manual investigation
            $payer_ip =         $_SERVER['REMOTE_ADDR'];
            $date = date('Y-m-d h:i:s');
            $fh = fopen('donate_error_log.txt','a');
            fwrite("\nFROM: $payer_ip\tDATE:$date");
            fclose($fh);
        }
    }
    
    public function thankyou() {
        $data['crumbs'] =    $this->crumbs;
        $title =             'Donation Complete - Thank You!';
        $page =              'currency/thankyou';
        
        $this->page_build($title,null,$page,$data);     
    }
    
    public function add() {
        $this->check_authority();
        
        if($_POST['amount']) {
            $amount = $_POST['amount'];
            if(isset($_POST['value']))
                $value = $_POST['value'];
            else
                $value = 0;
            
            $this->load->model('mcurrency');
            $add = $this->mcurrency->add_donate_amount($amount,$value);
            
            if(true == $add)
                $url = base_url().'dashboard/currency?action=donate&msgcode=113';
            else
                $url = base_url().'dashboard/currency?action=donate&msgcode=402';//Error 402 - Bad request
        } else {
            //Error 401 - missing/invalid data
            $url = base_url().'dashboard/currency?action=donate&msgcode=401';
        }
        
        redirect($url,'refresh');
    }
    
    public function update() {
        $this->check_authority();
        
        if($_POST['id'] AND $_POST['amount'] AND $_POST['value']) {
            $id =       $_POST['id'];
            $amount =   $_POST['amount'];
            $value =    $_POST['value'];
            
            $this->load->model('mcurrency');
            $update = $this->mcurrency->update_donate($id,$amount,$value);
            
            if($update)
                $url = base_url().'dashboard/currency?action=donate&msgcode=114';
            else
                $url = base_url().'dashboard/currency?action=edit_donate&msgcode=402';//Error 402 - Bad request
        } else {
            //Error 401 - Invalid/missing data
            $url = base_url().'dashboard/currency?action=donate&msgcode=401';
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
                    $delete = $this->mcurrency->delete_donate($id);
                    if(!$delete)
                        $errors++;
                }
                
                if(0 == $errors) {
                    //Success deleting post [success 102]
                    $url = base_url().'dashboard/currency?action=donate&msgcode=102';
                } else if(0 < $errors AND $errors < count($ids)) {
                    //Info 201 - Imperfect Execution
                    $url = base_url().'dashboard/currency?action=donate&msgcode=201';
                } else {
                    //Error - Bad request [error 402]
                    $url = base_url().'dashboard/currency?action=donate&msgcode=402';
                }
            } else {
                //Error - Missing/Invalid data [error 401]
                $url = base_url().'dashboard/currency?action=donate&msgcode=401';
            }
        } else {
            //Error - Missing/Invalid data [error 401]
            $url = base_url().'dashboard/currency?action=donate&msgcode=401';
        }
        
        redirect($url,'refresh');
    }
    
    public function update_settings() {
        $this->check_authority();
        
        if($_POST['pp_merch_id'] AND $_POST['pp_org_name'] AND $_POST['pp_currency'] AND $_POST['return_url'] AND $_POST['cancel_url']) {
            $pp_merch_id = $_POST['pp_merch_id'];
            $pp_org_name = $_POST['pp_org_name'];
            $pp_currency = $_POST['pp_currency'];
            $return_url =  $_POST['return_url'];
            $cancel_url =  $_POST['cancel_url'];
            
            if(isset($_POST['use_sandbox'])) { $use_sandbox = 1; } else { $use_sandbox = 0; }
            if(isset($_POST['status'])) { $status = 1; } else { $status = 0; }
            
            $this->load->model('mcurrency');
            $update = $this->mcurrency->update_set_cur($use_sandbox,$pp_merch_id,$pp_org_name,$pp_currency,$return_url,$cancel_url,$status);
            
            if($update)
                $url = base_url().'dashboard/currency?action=settings&msgcode=104';
            else
                $url = base_url().'dashboard/currency?action=settings&msgcode=402';//Error 402 - Bad request
        } else {
            //Error 401 - Invalid/missing data
            $url = base_url().'dashboard/currency?action=settings&msgcode=401';
        }
        
        redirect($url,'refresh');
    }
}