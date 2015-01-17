<?php

$active = 'Forgot Password';
breadcrumb($crumbs,$active);

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="post-title"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
            <div class="spacer"></div>
            <p>Please enter your username and email address, and we will send you your account details.</p>
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
            <form action="account/forgot" method="POST" class="form">
                <input type="text" class="form-control" name="userid" placeholder="Username" required />
                <input type="text" class="form-control" name="email" placeholder="Email Address" required />
                <div class="text-center"><button class="btn btn-primary btn-block" role="submit">Recover &raquo;</button></div>
            </form>
        </div>
    </div>
</div>
