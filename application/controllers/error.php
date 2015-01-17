<?php if ( ! defined ('BASEPATH')) exit('No direct script access allowed!');

class Error extends TCP_Controller {
    public function restricted() {
        $title = 'Error 401 - Unauthorized';
        $page = 'error/restricted';
        $this->page_build($title,null,$page,null);
    }
    
    public function not_found() {
        $title = 'Error 404 - Page Not Found';
        $page = 'error/not_found';
        $this->page_build($title,null,$page,null);        
    }
}