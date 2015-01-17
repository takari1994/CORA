<ul class="nav nav-tabs">
    <li class="active"><a href="account/profile?id=<?php echo $profile[0]->account_id; ?>"><span class="glyphicon glyphicon-list-alt"></span> Profile</a></li>
    <li><a href="account/characters?id=<?php echo $profile[0]->account_id; ?>"><span class="glyphicon glyphicon-user"></span> Characters</a></li>
    <li><a href="account/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
</ul>
<?php

$active = 'Profile';
breadcrumb($crumbs,$active);

?>
<div class="container-fluid profile">
    <div class="row profile-header">
        <div class="col-md-12">
            <div class="img-container pull-left">
                <img alt="avatar" src="<?php if(false == file_exists(UPLOAD_AVATARS_PATH.$profile[0]->account_id.'.png')){ echo 'img/def_avatar.gif'; } else { echo UPLOAD_AVATARS_PATH.$profile[0]->account_id.'.png'; } ?>" />
            </div>
            <h1 class="post-title"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
        </div>
    </div>
    <div class="spacer"></div>
    <div class="row profile-body">
        <div class="col-md-12">
            <?php
                
            if(isset($_GET['msgcode'])) {
                echo '<div class="spacer"></div>';
                echo parse_msgcode($_GET['msgcode']);
            }
            
            ?>
        </div>
        <div class="col-md-7">
            <form class="form" action="account/change_pass" method="post">
                <span><strong>Change Password:</strong></span>
                <div class="spacer"></div>
                <input type="hidden" name="account_id" value="<?php echo $profile[0]->account_id; ?>" />
                <table class="profile-info">
                    <?php if(99 < $this->session->userdata('group_id') OR $profile[0]->account_id == $this->session->userdata('account_id')): ?>
                    <tr>
                        <td>Old Password</td>
                        <td><input type="password" class="form-control" name="old_password" required /></td>
                    </tr>
                    <?php endif; ?>
                    <tr>
                        <td>New Password</td>
                        <td><input type="password" class="form-control" name="new_password" required /></td>
                    </tr>
                    <tr>
                        <td>Confirm Password</td>
                        <td><input type="password" class="form-control" name="con_password" required /></td>
                    </tr>
                </table>
                <div class="spacer"></div>
                <div class="right">
                    <input type="submit" class="btn btn-primary" name="submit" value="Change Password" />
                    <a href="account/profile?id=<?php echo $profile[0]->account_id; ?>" alt="Cancel" class="btn btn-default">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('assets/datepicker'); ?>
