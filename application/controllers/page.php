<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Page extends TCP_Controller {
    protected $crumbs = array(array('desc'=>'Home','uri'=>''));
    
    public function view() {
        if(isset($_GET['id'])) {
            $pageid = $_GET['id'];
            $this->load->model('mpage');
            $pages = $this->mpage->get_pages($pageid);
            
            if(null != $pages) {
                $title = $pages[0]->title;
                $page = 'page';
                $data['page'] = $pages;
                $data['crumbs'] = $this->crumbs;
                $this->page_build($title,null,$page,$data);
            } else {
                //Missing/Invalid data [error 401]
            }
        } else {
            //Missing/Invalid data [error 401]
        }
    }
    
    function save() {
        $this->check_authority();
        
        if(isset($_POST['id'])) { $id = $_POST['id']; } else { $id = null; }
        if(isset($_POST['title']) AND isset($_POST['pagecontent'])) {
            $title = $_POST['title'];
            $content = $_POST['pagecontent'];
            $author = $this->session->userdata('admin_id');
            $date = date('Y-m-d H:i:s');
            
            $this->load->model('mpage');
            $save = $this->mpage->save_page($id,$title,$content,$author,$date);
            if($save) {
                //Success saving post [success 101]
                $url = base_url().'dashboard/pages?action=edit&id='.$id.'&msgcode=101';
            } else {
                //Error - Bad request [error 402]
                if(null == $id)
                    $url = base_url().'dashboard/pages?action=new&msgcode=402';
                else
                    $url = base_url().'dashboard/pages?action=edit&id='.$id.'&msgcode=402';
            }
        } else {
            //Error - Missing/Invalid data [error 401]
            if(null != $id)
                $url = base_url().'dashboard/pages?action=new&msgcode=401';
            else
                $url = base_url().'dashboard/pages?action=edit&id='.$id.'&msgcode=401';
        }
        redirect($url,'refresh');
    }
    
    function delete() {
        $this->check_authority();
        
        if(isset($_GET['ids'])) {
            $ids = $_GET['ids'];
            
            if(is_array($ids)) {
                $this->load->model('mpage');
                $errors = 0;
                foreach($ids as $id) {
                    $delete = $this->mpage->delete_page($id);
                    if(!$delete)
                        $errors++;
                }
                
                if(0 == $errors) {
                    //Success deleting post [success 102]
                    $url = base_url().'dashboard/pages?msgcode=102';
                } else if(0 < $errors AND $errors < count($ids)) {
                    //Info 201 - Imperfect Execution
                    $url = base_url().'dashboard/pages?msgcode=201';
                } else {
                    //Error - Bad request [error 402]
                    $url = base_url().'dashboard/pages?msgcode=402';
                }
            } else {
                //Error - Missing/Invalid data [error 401]
                $url = base_url().'dashboard/pages?msgcode=401';
            }
        } else {
            //Error - Missing/Invalid data [error 401]
            $url = base_url().'dashboard/pages?msgcode=401';
        }
        
        redirect($url,'refresh');
    }
}