<div id="wid-<?php echo $wuid; ?>" class="panel panel-primary widget wid-account"<?php if(0 == $wid_count){echo ' style="margin-top: 0 !important;"';} ?>>
    <div class="panel-heading">
        <img class="account-img" src="img/jungle/account-img.png">
        <span class="panel-title"><?php echo $title; ?></span>
    </div>
    <?php if(!$this->session->userdata('account_id')): ?>
    <form action="<?php echo base_url(); ?>account/authenticate" method="post">
        <input type="submit" name="submit" class="btn btn-primary btn-login fr" value="Login" />
        <input type="text" class="form-control" name="username" maxlength="23" placeholder="username"<?php if($this->input->cookie('userid')){ echo ' value="'.$this->input->cookie('userid').'"'; } ?> required />
        <input type="password" class="form-control" name="userpass" maxlength="32" placeholder="password" required />
        <div class="text-center">
            <a href="account/register" class="btn btn-primary btn-register"><img class="register-img" src="img/jungle/register-img.png">REGISTER</a>
        </div>
    </form>
    <?php else: ?>
    <div id="account-panel">
        <div class="img-container pull-left">
            <img alt="avatar" src="<?php if(false == file_exists(UPLOAD_AVATARS_PATH.$this->session->userdata('account_id').'.png')){ echo 'img/def_avatar.gif'; } else { echo UPLOAD_AVATARS_PATH.$this->session->userdata('account_id').'.png'; } ?>" />
        </div>
        <strong><?php echo $this->session->userdata('userid'); ?></strong>
        <div class="list-group action">
            <a href="<?php echo base_url(); ?>account" class="list-group-item"><span class="glyphicon glyphicon-list-alt"></span> Profile</a>
            <a href="<?php echo base_url(); ?>account/characters" class="list-group-item"><span class="glyphicon glyphicon-user"></span> Characters</a>
            <a href="<?php echo base_url(); ?>account/logout" class="list-group-item"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
        </div>
    </div>
    <?php endif; ?>
</div>