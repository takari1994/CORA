<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Post extends TCP_Controller {
    protected $crumbs = array(array('desc'=>'Home','uri'=>''));
    
    public function index() {
        $title = "News and Events";
        
        if(!isset($_GET['page']))
            $page = 1;
        else 
            $page = $_GET['page'];
        
        $pp = PAGINATION_RPP;
        $index = $pp*($page-1);
        
        $this->load->model('mpost');
        $data['crumbs'] = $this->crumbs;
        $data['posts']  = $this->mpost->get_posts(null,null,$index,$pp);
        $data['tp']     = $this->mpost->get_posts(null,null,null,null,null,true);
        $this->page_build($title,null,'posts',$data);
    }
    
    public function news() {
        $title = "News";
        
        if(!isset($_GET['page']))
            $page = 1;
        else 
            $page = $_GET['page'];
        
        $pp = PAGINATION_RPP;
        $index = $pp*($page-1);
        
        $this->load->model('mpost');
        
        $cond =           array('tcp_post.type'=>1);
        $this->crumbs[] = array('desc'=>'Post','uri'=>'post');
        $data['crumbs'] = $this->crumbs;
        $data['posts']  = $this->mpost->get_posts(null,null,$index,$pp,$cond);
        $data['tp']     = $this->mpost->get_posts(null,null,null,null,$cond,true);
        $this->page_build($title,null,'posts',$data);
    }
    
    public function events() {
        $title = "Events";
        
        if(!isset($_GET['page']))
            $page = 1;
        else 
            $page = $_GET['page'];
        
        $pp = PAGINATION_RPP;
        $index = $pp*($page-1);
        
        $this->load->model('mpost');
        
        $cond =           array('tcp_post.type'=>2);
        $this->crumbs[] = array('desc'=>'Post','uri'=>'post');
        $data['crumbs'] = $this->crumbs;
        $data['posts']  = $this->mpost->get_posts(null,null,$index,$pp,$cond);
        $data['tp']     = $this->mpost->get_posts(null,null,null,null,$cond,true);
        $this->page_build($title,null,'posts',$data);
    }
    
    public function view() {
        if(isset($_GET['id'])) {
            $postid = $_GET['id'];
            $this->load->model('mpost');
            $post = $this->mpost->get_posts($postid);
            
            if(null != $post) {
                $title          = $post[0]->title;
                $page           = 'post';
                $this->crumbs[] = array('desc'=>'Post','uri'=>'post');
                $data['post']   = $post;
                $data['crumbs'] = $this->crumbs;
                $this->page_build($title,null,$page,$data);
            } else {
                //Missing/Invalid data [error 401]
            }
        } else {
            //Missing/Invalid data [error 401]
        }
    }
    
    public function save($type=null) {
        $this->check_authority();
        
        if(null != $type) {
            if(isset($_POST['id'])) { $id = $_POST['id']; } else { $id = null; }
            if($type == 'news'):
                if(isset($_POST['title']) AND isset($_POST['postcontent'])) {
                    $title = $_POST['title'];
                    $content = $_POST['postcontent'];
                    $author = $this->session->userdata('admin_id');
                    $date = date('Y-m-d H:i:s');
                    $type= 1;
                    
                    $this->load->model('mpost');
                    $save = $this->mpost->save_post($id,$title,$content,$author,$date,$type);
                    
                    if(null != $save) {
                        //Success saving post [success 101]
                        $url = base_url().'dashboard/posts?action=edit&type=news&id='.$save.'&msgcode=101';
                    } else {
                        //Error - Bad request [error 402]
                        $url = base_url().'dashboard/posts?action=new&type=news&msgcode=402';
                    }
                } else {
                    //Error - Missing/Invalid data [error 401]
                    $url = base_url().'dashboard/posts?action=new&type=news&msgcode=401';
                }
            elseif($type == 'event'):
                //else if type is event
                if(isset($_POST['title']) AND isset($_POST['postcontent']) AND isset($_POST['eventStart']) AND isset($_POST['eventEnd'])) {
                    $title = $_POST['title'];
                    $content = $_POST['postcontent'];
                    $eventstart = $_POST['eventStart'];
                    $eventend = $_POST['eventEnd'];
                    $author = $this->session->userdata('admin_id');
                    $date = date('Y-m-d H:i:s');
                    $type = 2;
                    
                    $this->load->model('mpost');
                    $save = $this->mpost->save_post($id,$title,$content,$author,$date,$type,array('start'=>$eventstart,'end'=>$eventend));
                    
                    if(null != $save) {
                        //Success saving post [success 101]
                        $url = base_url().'dashboard/posts?action=edit&type=event&id='.$save.'&msgcode=101';
                    } else {
                        //Error - Bad request [error 402]
                        $url = base_url().'dashboard/posts?action=new&type=event&msgcode=402';
                    }                    
                } else {
                    //Error - Missing/Invalid data [error 401]
                    $url = base_url().'dashboard/posts?action=new&type=event&msgcode=401';
                }
            endif;
        } else {
            $url = base_url().'dashboard/posts?msgcode=401';
        }
        
        redirect($url,'refresh');
    }
    
    function delete() {
        $this->check_authority();
        
        if(isset($_GET['ids'])) {
            $ids = $_GET['ids'];
            
            if(is_array($ids)) {
                $this->load->model('mpost');
                $errors = 0;
                foreach($ids as $id) {
                    $delete = $this->mpost->delete_post($id);
                    if(!$delete)
                        $errors++;
                }
                
                if(0 == $errors) {
                    //Success deleting post [success 102]
                    $url = base_url().'dashboard/posts?msgcode=102';
                } else if(0 < $errors AND $errors < count($ids)) {
                    //Info 201 - Imperfect execution
                    $url = base_url().'dashboard/posts?msgcode=201';
                } else {
                    //Error - Bad request [error 402]
                    $url = base_url().'dashboard/posts?msgcode=402';
                }
            } else {
                //Error - Missing/Invalid data [error 401]
                $url = base_url().'dashboard/posts?msgcode=401';
            }
        } else {
            //Error - Missing/Invalid data [error 401]
            $url = base_url().'dashboard/posts?msgcode=401';
        }
        
        redirect($url,'refresh');
    }
}