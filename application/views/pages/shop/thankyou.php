<?php

$active = 'Purchase Successful';
breadcrumb($crumbs,$active);

?>
<div class="container-fluid">
<div class="row">
    <div class="col-md-12">
        <h1 class="post-title"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
        <div class="spacer"></div>
    </div>
    <div class="col-md-12">
        <p>Thank you for your purchase! Claim your items from the <em>Mail NPC</em> in-game.</p>  
    </div>
</div>
</div>