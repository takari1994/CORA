<?php

$widgets = get_widgets($id);
$theme   = get_layout();

if(null != $widgets){
    $wid_count = 0;
    foreach($widgets as $widget) {
        $page = $widget['page'];
        require(APP_PATH."/views/widgets/$page.php");
        if(file_exists(APP_PATH."/views/layouts/$theme/$view.php"))
            $view = "layouts/$theme/$view.php";
        $data['wid_count'] = $wid_count;
        $this->load->view($view,$data);
        $wid_count++;
    }
}

?>