<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Home extends TCP_Controller {
    protected $crumbs = array();
    
    public function index() {
        $this->load->model('msettings');
        $settings = $this->msettings->get_set_gen();
        
        if(0 == $settings[0]->homepage) {
            $title = "Home";
            $page = 'posts';
            
            if(!isset($_GET['page']))
                $curpage = 1;
            else 
                $curpage = $_GET['page'];
            
            $pp = PAGINATION_RPP;
            $index = $pp*($curpage-1);
            
            $this->load->model('mpost');
            $data['posts'] = $this->mpost->get_posts(null,null,$index,$pp);
            $data['tp'] =    count($this->mpost->get_posts(null,null));
        } else if (0 < $settings[0]->homepage) {
            $this->load->model('mpage');
            $home = $this->mpage->get_pages($settings[0]->homepage);
            if(0 < count($home)) {
                $page         = 'page';
                $title        = $home[0]->title;
                $data['page'] = $home;
            } else {
                $page         = 'error/notfound';
                $title        = 'Home';
            }
        } else {
            $title = "Home";
            $page = 'index';
        }
        
        $data['crumbs'] = $this->crumbs;
        
        $this->page_build($title,null,$page,$data);
    }
}