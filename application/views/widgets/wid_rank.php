<?php

$we = get_widget_extra($widget['type'],$widget['wuid']);
$disp = $we['display']; $pl_sort = $we['pl_rank_sort']; $gl_sort = $we['gl_rank_sort'];
$pl = null; $gl = null;

if($disp == 'p' OR $disp == 'b') {
    $url = base_url().'community/player_ladder?json=true&sort=';
    switch($pl_sort){ case 'k': $url.='kills';break; case 'l': $url.='base_level';break; case'z': $url.='zeny'; }
    $pl = json_decode(file_get_contents($url));
}

if($disp == 'g' OR $disp == 'b') {
    $url = base_url().'community/guild_ladder?json=true&sort=';
    switch($gl_sort){ case 'l': $url.='guild_lv';break; case'c': $url.='castles'; }
    $gl = json_decode(file_get_contents($url));
}

$data = array('wuid'=>$widget['wuid'],'title'=>$widget['title'],'pl'=>$pl,'gl'=>$gl,'plsort'=>$pl_sort,'glsort'=>$gl_sort);

$view = 'widgets/wid_rank_page';

?>