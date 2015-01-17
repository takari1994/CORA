<?php

$active = 'Home';
breadcrumb($crumbs,$active);

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="post-title"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
            <p>Change the content of this file by accessing /application/views/pages/index.php</p>
        </div>
    </div>
</div>