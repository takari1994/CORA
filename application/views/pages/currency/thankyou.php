<?php

$active = "Donate";
breadcrumb($crumbs,$active);

?>
<div class="container-fluid v4p-container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
            <div class="spacer"></div>
            <?php
            if(isset($_GET['msgcode'])) {
                echo parse_msgcode($_GET['msgcode']);
            }
            ?>
            <p>Your donation will greatly help our community, and so we express our most sincere gratitude!</p>
        </div>
    </div>
</div>