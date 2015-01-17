<?php

$active = 'Account Verification';
breadcrumb($crumbs,$active);

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="post-title"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
            <div class="spacer"></div>
            <p>Validate your account by filling up the form below with the information sent to your email.</p>
            <?php
            
            if(isset($_GET['msgcode'])) {
                echo '<div class="spacer"></div>';
                echo parse_msgcode($_GET['msgcode']);
            }
            
            ?>
            <div class="spacer"></div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-md-offset-3">
            <form action="account/verify" method="GET" class="form">
                <input type="text" class="form-control" name="id" placeholder="ID" />
                <input type="text" class="form-control" name="code" placeholder="Code" />
                <button class="btn btn-primary pull-right" role="submit">Verify Account &raquo;</button>
            </form>
        </div>
    </div>
</div>
