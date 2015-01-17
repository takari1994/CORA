<?php

$active = 'Login';
breadcrumb($crumbs,$active);

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <h1 class="post-title"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
            <div class="spacer"></div>
            <p>Please enter your account credentials below to access your account.</p>
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
        <div class="col-md-6" style="border-right: solid 1px #eee;">
            <form action="<?php echo base_url(); ?>account/authenticate" method="POST">
                <input type="text" class="form-control" name="username" placeholder="Username"<?php if($this->input->cookie('userid')){ echo ' value="'.$this->input->cookie('userid').'"'; } ?> required />
                <input type="password" class="form-control" name="userpass" placeholder="Password" required />
                <input type="submit" class="btn btn-primary pull-right" name="submit" value="Login" />
                <div class="checkbox fl">
                    <label>
                        <input type="checkbox" name="remember" value="1"<?php if($this->input->cookie('userid')){ echo ' checked'; } ?>> Remember me
                    </label>
                </div>
            </form>
        </div>
        <div class="col-md-6">
            <strong>Account Help:</strong><br />
            <a href="account/register">Create New Account</a><br />
            <a href="account/forgot">Forgot Password</a><br />
            <a href="account/resend">Resend E-mail Verification</a><br />
        </div>
    </div>
</div>