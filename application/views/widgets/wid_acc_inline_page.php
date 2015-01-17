<div id="wid-<?php echo $wuid; ?>" class="panel panel-primary widget wid-account-inline">
    <div class="panel-heading" style="display: none;">
        <span class="panel-title"><?php echo $title; ?></span>
    </div>
    <?php if(!$this->session->userdata('account_id')): ?>
    <form action="<?php echo base_url(); ?>account/authenticate" method="post" class="form-inline">
        <input type="text" class="form-control" name="username" maxlength="23" placeholder="username" required />
        <input type="password" class="form-control" name="userpass" maxlength="32" placeholder="password" required />
        <input type="submit" name="submit" class="btn btn-primary" value="Login" />
    </form>
    <?php else: ?>
    <div id="account-panel">
        <div class="img-container">
            <img alt="avatar" src="<?php if(false == file_exists(UPLOAD_AVATARS_PATH.$this->session->userdata('account_id').'.png')){ echo 'img/def_avatar.gif'; } else { echo UPLOAD_AVATARS_PATH.$this->session->userdata('account_id').'.png'; } ?>" />
        </div>
        <div class="inline action">
            Welcome, <?php echo $this->session->userdata('userid'); ?><br />
            <div class="btn-group">
                <button type="button" class="btn btn-xs btn-success">My Account</button>
                <button type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown">
                  <span class="caret"></span>
                  <span class="sr-only">Toggle Dropdown</span>
                </button>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="account">Profile</a></li>
                  <li><a href="account/characters">Characters</a></li>
                  <li><a href="account/logout">Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>