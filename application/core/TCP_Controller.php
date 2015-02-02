<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class TCP_Controller extends CI_Controller{
    protected $reqlvl = 99;
    protected $global_title = '';
    
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set(DATE_DEFAULT_TIMEZONE);
    }
       
    public function page_build($title,$layout=null,$page=null,$data=null) {
        $this->load->model('msettings');
        $gen_settings = $this->msettings->get_set_gen();
        
        if(!$this->session->userdata('account_id')) {
            if($this->input->cookie('userid')) {
                if('true' == $this->input->cookie('login')) {
                    $userid = $this->input->cookie('userid');
                    $this->load->model('maccount');
                    $profile = $this->maccount->get_profile(array('userid'=>$userid));
                    if(null != $profile) {
                        $this->session->set_userdata('account_id',$profile[0]->account_id);
                        $this->session->set_userdata('userid',$profile[0]->userid);
                        $this->session->set_userdata('group_id',$profile[0]->group_id);
                        $this->session->set_userdata('sex',$profile[0]->sex);
                    }
                }
            }
        }
        
        if(null == $layout)
            $layout = $gen_settings[0]->theme;
        
        if(file_exists(APP_PATH.'/views/layouts/'.$layout.'/pages/'.$page.'.php')) {
            $page = 'layouts/'.$layout.'/pages/'.$page;
        } else {
            $page = 'pages/'.$page;
        }
        
        $this->global_title = $gen_settings[0]->serv_name;
        $data['serv_name'] = $gen_settings[0]->serv_name;
        
        $files = $this->get_partials($layout);
        $this->set_partials($files,$layout);
        $this->template->title($title,$this->global_title);
        $this->template->set_layout($layout.'/index');
        
        if(true == $gen_settings[0]->const_mode) {
            if(!$this->session->userdata('admin_userid'))
                $this->load->view('pages/construction',$data);
            else
                $this->template->build($page,$data);
        } else {
            $this->template->build($page,$data);
        }
    }
    
    public function get_partials($layout) {
        $map = get_filenames(APP_PATH.'/views/layouts/'.$layout.'/partials/');
        return $map;
    }
    
    public function set_partials($files,$layout) {
        foreach($files as $file) {
            $rawfile = substr($file,0,-4);
            $this->template->set_partial($rawfile,'layouts/'.$layout.'/partials/'.$rawfile.'.php');
        }
    }
    
    public function check_authority() {
        if(!$this->session->userdata('admin_userid')) {
            $url = base_url().'admin/login';
            redirect($url,'refresh');
        }
    }
    
    public function check_login() {
        if(!$this->session->userdata('account_id')) {
            if($this->input->cookie('userid')) {
                if('true' == $this->input->cookie('login')) {
                    $userid = $this->input->cookie('userid');
                    $this->load->model('maccount');
                    $profile = $this->maccount->get_profile(array('userid'=>$userid));
                    if(null != $profile) {
                        $this->session->set_userdata('account_id',$profile[0]->account_id);
                        $this->session->set_userdata('userid',$profile[0]->userid);
                        $this->session->set_userdata('group_id',$profile[0]->group_id);
                        $this->session->set_userdata('sex',$profile[0]->sex);
                    } else {
                        $url = 'account/login';
                        redirect(base_url().$url,'refresh'); 
                    }
                } else {
                    $url = 'account/login';
                    redirect(base_url().$url,'refresh');
                }
            } else {
                $url = 'account/login';
                redirect(base_url().$url,'refresh');  
            }
        }
    }
    
    public function validate_captcha($privatekey,$capt_ch_field,$capt_res_field) {
        $response = $this->recaptcha_check_answer($privatekey, $_SERVER["REMOTE_ADDR"], $capt_ch_field, $capt_res_field);
        
        $result = explode("\n",$response);
        
        if ($result[0] == 'false') {
          return false;
        } else {
          return true;
        }
    }
    
    public function search($tbl,$col,$query,$index=null,$pp=null,$count=null) {
        $this->load->model('mdatabase');
        
        switch($tbl) {
            case 'user':
                break;
            case 'item':
                $search = $this->mdatabase->search('item_db',$col,$query,$index,$pp,'AND',$count);
                break;
            case 'mob':
                $search = $this->mdatabase->search('mob_db',$col,$query,$index,$pp,'AND',$count);
        }
        
        return $search;
    }
    
    public function recaptcha_check_answer($privkey,$remoteip,$challenge,$response) {
        $recaptcha_verify_server = "http://www.google.com/recaptcha/api/verify";
        $recaptcha_data = array(
            'privatekey' => $privkey,
            'remoteip' => $remoteip,
            'challenge' => $challenge,
            'response' => $response
        );
        
        $options = array(
            'http' => array(
                'header' => "Content-type: application/x-www-form-urlencoded\r\n",
                'method' => 'POST',
                'content' => http_build_query($recaptcha_data)
            )
        );
        
        $context = stream_context_create($options);
        $result = file_get_contents($recaptcha_verify_server, false, $context);
        
        return $result;
    }
    
    public function send_mail_smtp($smtp_host,$smtp_port,$email,$password,$to,$subject,$msg) {
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => $smtp_host,
            'smtp_port' => $smtp_port,
            'smtp_user' => $email,
            'smtp_pass' => $password,
            'mailtype' =>  'html',
            'charset' =>   'iso-8859-1'
        );
        
        $this->load->library('email',$config);
        $this->email->set_newline("\r\n");
        
        $this->email->from($email);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($msg);
        
        $result = $this->email->send();
        
        if($result)
            $return = true;
        else
            $return = false;
        
        return $return;
    }
    
    public function send_php_mail($name,$email,$to,$subject,$msg) {
        $config = array(
            'protocol' => 'mail',
            'mailtype' => 'html',
            'charset'  => 'iso-8859-1'
        );
        
        $this->load->library('email',$config);
        
        $this->email->from($email, $name);
        $this->email->to($to);
        $this->email->subject($subject);
        $this->email->message($msg);
        
        $result = $this->email->send();
        
        if($result)
            $return = true;
        else
            $return = false;
        
        return $return;
    }
    
    public function image_upload($field,$name) {
        $filename = $name.'.png';
        
        switch($field) {
            case 'avatar': $config['upload_path'] = 'img/uploads/avatars/'; break;
            default:       $config['upload_path'] = 'img/uploads/';
        }
        
        $config['file_name'] = $filename;
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']	= '100';
        $config['max_width']  = '1024';
        $config['max_height']  = '1024';
        
        if(file_exists($config['upload_path'].$filename)) {
            unlink($config['upload_path'].$filename);
        }
        
        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload($field)) {
            $error = array('error' => $this->upload->display_errors());
            $result = $error;
        } else {
            $data = array('upload_data' => $this->upload->data());
            $this->create_image_thumb($data['upload_data']['file_path'].$data['upload_data']['file_name']);
            $result = null;
        }
        return $result;
    }
    
    public function create_image_thumb($path) {
        $config['image_library'] = 'gd2';
        $config['source_image']	= $path;
        $config['maintain_ratio'] = TRUE;
        $config['width']	= 88;
        $config['height']	= 88;
        
        $this->load->library('image_lib', $config); 
        
        $this->image_lib->resize();
    }
    
    public function get_age($birthday) {
        $date = new DateTime($birthday);
        $now = new DateTime();
        $interval = $now->diff($date);
        
        return $interval->y;
    }
}
