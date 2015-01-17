<?php

$active = $post[0]->title;
breadcrumb($crumbs,$active);

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="post-title"><a href="<?php echo current_url().'?id='.$post[0]->post_id; ?>"><?php echo $post[0]->title; ?></a></h1>
            <span class="post-details"><?php $date = date_create($post[0]->date); echo $date->format('M. d, Y h:ia'); ?> by <a href="#" class="post-author"><?php echo $post[0]->userid; ?></a></span>
            <div class="ckcontent">
                <div class="post-content">
                <?php echo $post[0]->content; ?>
                </div>
            </div>
        </div>
    </div>
</div>