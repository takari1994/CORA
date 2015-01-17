<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Navigation extends TCP_Controller {
    public function add_nav_li() {
        $this->check_authority();
        $nav_id = $_POST['nav_id'];
        $label = $_POST['label'];
        $url = '#';
        
        $q = "SELECT MAX(position) as maxpos FROM tcp_nav_li WHERE nav_id=$nav_id";        
        $this->load->model('mdashboard');
        $this->load->model('mnavigation');
        $maxpos = $this->mdashboard->query($q);
        
        $pos = $maxpos[0]->maxpos+1;
        
        $save = $this->mnavigation->save_nav_li($nav_id,$label,$url,$pos);
        
        $data['links'] = $this->mnavigation->get_nav_li($nav_id);
        $page = 'pages/dashboard/navs/nav_links';
        $this->load->view($page,$data);
    }
    
    public function delete_nav_li() {
        $this->check_authority();
        
        $nav_id = $_POST['nav_id'];
        $nav_li_id = $_POST['id'];
        
        $this->load->model('mnavigation');
        $delete = $this->mnavigation->delete_nav_li($nav_li_id);
        $sort = $this->mnavigation->sort_nav_li($nav_id);
        $data['links'] = $this->mnavigation->get_nav_li($nav_id);
        
        $page = 'pages/dashboard/navs/nav_links';
        $this->load->view($page,$data);
        
    }
    
    public function switch_nav_li_pos() {
        $this->check_authority();
        
        $nav_id = $_POST['nav_id'];
        $old_pos = $_POST['old_pos'];
        if(1 == $_POST['move'])
            $new_pos = $old_pos + 1;
        else if(0 == $_POST['move'])
            $new_pos = $old_pos - 1;
            
        $this->load->model('mnavigation');
        
        $switch = $this->mnavigation->switch_nav_li_pos($old_pos,$new_pos);
        $data['links'] = $this->mnavigation->get_nav_li($nav_id);
        
        $page = 'pages/dashboard/navs/nav_links';
        $this->load->view($page,$data);
    }
    
    function change_nav_li_label() {
        $this->check_authority();
        
        $nav_id = $_POST['nav_id'];
        $nav_li_id = $_POST['id'];
        $label = $_POST['label'];
        
        $this->load->model('mnavigation');
        
        $changelabel = $this->mnavigation->change_nav_li_label($nav_li_id,$label);
        $data['links'] = $this->mnavigation->get_nav_li($nav_id);
        
        $page = 'pages/dashboard/navs/nav_links';
        $this->load->view($page,$data);
    }
    
    function change_nav_li_url() {
        $this->check_authority();
        
        $nav_id = $_POST['nav_id'];
        $nav_li_id = $_POST['id'];
        $url = $_POST['url'];
        
        $this->load->model('mnavigation');
        
        $changeurl = $this->mnavigation->change_nav_li_url($nav_li_id,$url);
        $data['links'] = $this->mnavigation->get_nav_li($nav_id);
        
        $page = 'pages/dashboard/navs/nav_links';
        $this->load->view($page,$data);
    }
    
    function delete() {
        $this->check_authority();
        
        if(isset($_GET['ids'])) {
            $ids = $_GET['ids'];
            if(is_array($ids)) {
                $this->load->model('mnavigation');
                $errors = 0;
                $in_use = 0;
                foreach($ids as $id) {
                    $delete = $this->mnavigation->delete_nav($id);
                    if(0 == $delete)
                        $errors++;
                    elseif(2 == $delete)
                        $in_use++;
                }
                
                if(0 == $errors AND 0 == $in_use) {
                    $url = base_url().'dashboard/navigation?msgcode=103';
                } else if(0 < $in_use OR (0 < $errors AND $errors < count($ids))) {
                    //Info 201 - Imperfect execution
                    $url = base_url().'dashboard/navigation?msgcode=201';
                } else {
                    //Error 402 - Bad request
                    $url = base_url().'dashboard/navigation?msgcode=402';
                }
            } else {
                //Error 401 - Invalid/Missing data
                $url = base_url().'dashboard/navigation?msgcode=401';                
            }
        } else {
            //Error 401 - Invalid/Missing data
            $url = base_url().'dashboard/navigation?msgcode=401';
        }
        redirect($url,'refresh');
    }
}