<?php

$we = get_widget_extra($widget['type'],$widget['wuid']);
$data = array('wuid'=>$widget['wuid'],'title'=>$widget['title']);
$data['links'] = get_wid_nav($we['nav_id']);
$view = 'widgets/wid_nav_page';

?>