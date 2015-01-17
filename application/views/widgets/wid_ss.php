<?php

$we = get_widget_extra($widget['type'],$widget['wuid']);
$data = array('wuid'=>$widget['wuid'],'title'=>$widget['title']);
$data['map'] = ping_server($we['ip'],$we['port_map']);
$data['char'] = ping_server($we['ip'],$we['port_char']);
$data['login'] = ping_server($we['ip'],$we['port_login']);
$data['player_online'] = $we['player_online'];
$data['player_peak'] = $we['player_peak'];
$view = 'widgets/wid_ss_page';

?>