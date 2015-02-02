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
            <div class="action-container pull-right">
            <?php
            
            if($this->session->userdata('admin_userid')) {
                if(strtotime(date("Y-m-d H:i:s",time())) > $profile[0]->unban_time)
                    echo '<a class="btn btn-danger" href="dashboard/users?action=ban&ids%5B%5D='.$profile[0]->account_id.'"><span class="glyphicon glyphicon-ban-circle"></span> Ban User</a>';
                else if(0 < $profile[0]->unban_time)
                    echo '
                    <a class="btn btn-danger" href="dashboard/users?action=ban&ids%5B%5D='.$profile[0]->account_id.'">Update Ban</a>
                    <a class="btn btn-success" href="dashboard/users?action=unban&ids%5B%5D='.$profile[0]->account_id.'">Unban User</a>
                    ';
            }
            
            ?>
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
            <form action="account/update" method="post" enctype="multipart/form-data" id="profile-form">
                <input type="hidden" name="account_id" value="<?php echo $profile[0]->account_id; ?>" />
                <table class="profile-info">
                    <tr>
                        <td>Avatar</td>
                        <td><input type="file" class="form-control-static" name="avatar" accept="image/*" /></td>
                    </tr>
                    <tr>
                        <td>Email&nbsp;</td>
                        <td>
                            <?php if(1 == $set_acc[0]->req_email_ver AND !$this->session->userdata('admin_userid')): ?>
                            <input type="hidden" name="email" value="<?php echo $profile[0]->email; ?>" required />
                            <p class="form-control-static"><?php echo $profile[0]->email; ?></p>
                            <?php else: ?>
                            <input type="text" class="form-control" name="email" value="<?php echo $profile[0]->email; ?>" required />
                            <?php endif; ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Username&nbsp;</td>
                        <td><input type="text" class="form-control" name="username" value="<?php echo $profile[0]->userid; ?>"<?php if(false == $set_acc[0]->un_allow_change AND !$this->session->userdata('admin_userid')){ echo ' readonly';} ?> required /></td>
                    </tr>
                    <tr>
                        <td>Password&nbsp;</td>
                        <td><p class="form-control-static">****** <a href="account/profile?id=<?php echo $profile[0]->account_id; ?>&action=change_pass">Change Password</a></p></td>
                    </tr>
                    <tr>
                        <td>Gender&nbsp;</td>
                        <td>
                            <input type="radio" name="gender" value="M"<?php if("M" == $profile[0]->sex){ echo ' checked'; } else if(false == $set_acc[0]->sex_allow_change AND !$this->session->userdata('admin_userid')) { echo ' disabled';} ?> /> Male&nbsp;&nbsp;
                            <input type="radio" name="gender" value="F"<?php if("F" == $profile[0]->sex){ echo ' checked'; } else if(false == $set_acc[0]->sex_allow_change AND !$this->session->userdata('admin_userid')) { echo ' disabled';} ?> /> Female
                        </td>
                    </tr>
                    <tr>
                        <td>First Name&nbsp;</td>
                        <td><input type="text" class="form-control" name="fname" value="<?php echo $profile[0]->fname; ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Last Name&nbsp;</td>
                        <td><input type="text" class="form-control" name="lname" value="<?php echo $profile[0]->lname; ?>" required /></td>
                    </tr>
                    <tr>
                        <td>Birthday&nbsp;</td>
                        <td>
                            <input type="text" name="birthday" class="<?php if(1 == $set_acc[0]->bday_allow_change OR $this->session->userdata('admin_userid')){ echo 'datepicker-input-normal ';} ?>form-control" placeholder="Birthday" data-date-format="yyyy-mm-dd" value="<?php echo $profile[0]->birthday; ?>" readonly required />
                        </td>
                    </tr>
                </table>
                <div class="spacer"></div>
                <div class="right">
                    <input type="submit" class="btn btn-primary" name="submit" value="Save Changes" />
                    <input type="reset" class="btn btn-default" value="Cancel" />
                </div>
            </form>
        </div>
        <div class="col-md-5">
            <form>
            <table class="profile-info">
                <tr>
                    <td><a href="shop/cart">My Cart</a></td>
                    <td><input type="text" class="form-control" value="<?php echo $cart_item_count; ?>" readonly /></td>
                </tr>
                <tr>
                    <td>Credits</td>
                    <td><input type="text" class="form-control" form="profile-form" name="donate_points" value="<?php echo $donate_points; ?>"<?php if(!$this->session->userdata('admin_userid')){ echo ' readonly'; } ?> /></td>
                </tr>
                <tr>
                    <td>VPOINTS</td>
                    <td><input type="text" class="form-control" form="profile-form" name="vote_points" value="<?php echo $vote_points; ?>"<?php if(!$this->session->userdata('admin_userid')){ echo ' readonly'; } ?> /></td>
                </tr>
            </table>
            </form>
        </div>
    </div>
</div>
<?php $this->load->view('assets/datepicker'); ?>
