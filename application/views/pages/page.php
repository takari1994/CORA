<?php

if(null != uri_string()) {
    $active = $page[0]->title;
} else {
    $active = "Home";    
}
breadcrumb($crumbs,$active);

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="post-title"><?php echo $page[0]->title; ?></h1>
            <div class="spacer"></div>
            <div class="ckcontent">
                <div class="post-content">
                <?php echo $page[0]->content; ?>
                </div>
            </div>
        </div>
    </div>
</div>