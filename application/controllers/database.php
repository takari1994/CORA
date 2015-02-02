<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed!');

class Database extends TCP_Controller {
    protected $crumbs = array(array('desc'=>'Home','uri'=>''));
    
    public function index() {
        if(isset($_POST['submit']) AND isset($_POST['tbl']) AND isset($_POST['query'])) {
            $query = $_POST['query'];
            $tbl =   $_POST['tbl'];
            
            if('item' == $tbl) { $url = 'database/items/'; } else { $url = 'database/monsters/'; }
            
            redirect($url.$query,'refresh');
        } else {
            $title =           'Database';
            $page =            'database/default';
            $data['crumbs'] =  $this->crumbs;
            $this->page_build($title,null,$page,$data);
        }
    }
    
    public function items($query) {
        if(!isset($_GET['page']))
            $page = 1;
        else 
            $page = $_GET['page'];
        
        $pp = 5;
        $index = $pp*($page-1);
        
        $this->crumbs[] =  array('desc'=>'Database','uri'=>'database');
        $title =           'Database';
        $page =            'database/items';
        $data['crumbs'] =  $this->crumbs;
        $data['items'] =   $this->search('item','name_japanese',rawurldecode($query),$index,$pp);
        $data['tp'] =      $this->search('item','name_japanese',rawurldecode($query),null,null,true);
        $this->page_build($title,null,$page,$data);
    }
    
    public function monsters($query) {
        if(!isset($_GET['page']))
            $page = 1;
        else 
            $page = $_GET['page'];
        
        $pp = PAGINATION_RPP;
        $index = $pp*($page-1);
        
        $this->crumbs[] =  array('desc'=>'Database','uri'=>'database');
        $title =           'Database';
        $page =            'database/mobs';
        $data['crumbs'] =  $this->crumbs;
        $data['mobs'] =    $this->search('mob','kName',rawurldecode($query),$index,$pp);
        $data['tp'] =      $this->search('mob','kName',rawurldecode($query),null,null,true);
        $this->page_build($title,null,$page,$data);
    }
    
    public function get_item_info($id) {
        if(null == $id)
            die();
        
        $this->load->model('mdatabase');
        $ii = $this->mdatabase->get_item_info($id);
        
        if(null != $ii)
            print_r(json_encode($ii[0]));
        else
            die();
    }
}