<?php

$active = 'Success';
breadcrumb($crumbs,$active);

?>
<div class="container-fluid">
<div class="row">
    <div class="col-md-12">
        <h1 class="post-title"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
        <div class="spacer"></div>
    </div>
    <div class="col-md-12">
        <p>An email has been sent to <?php echo $email; ?>. Please check your email for confirmation.</p>  
    </div>
</div>
</div>