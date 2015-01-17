<?php

$active = 'Reset Password';
breadcrumb($crumbs,$active);

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="post-title"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
            <div class="spacer"></div>
            <p>Please enter your desired new password in the form below.</p>
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
            <form action="account/password_recovery" method="post" class="form">
                <input type="hidden" name="id" value="<?php echo $_GET['id']; ?>" required />
                <input type="hidden" name="code" value="<?php echo $_GET['code']; ?>" required />
                <input type="password" class="form-control" name="new_pass" placeholder="New Password" required />
                <input type="password" class="form-control" name="con_pass" placeholder="Confirm Password" required />
                <div class="text-center"><button class="btn btn-primary btn-block" role="submit" name="reset" value="1">Reset Password &raquo;</button></div>
            </form>
        </div>
    </div>
</div>
