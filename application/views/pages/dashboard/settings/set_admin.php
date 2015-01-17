<ul class="nav nav-pills fr">
    <li>
        <a href="dashboard/settings/general">General</a>
    </li>
    <li>
        <a href="dashboard/settings/account">Account</a>
    </li>
    <li>
        <a href="dashboard/settings/mailing">Mailing</a>
    </li>
    <li class="active">
        <a href="dashboard/settings/admin">Admin</a>
    </li>
</ul>
<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
<div class="hr"></div>
<?php

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<form action="admin/update" method="POST">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Admin Username</label>
                <input type="text" class="form-control" name="userid" value="<?php echo $adm_info[0]->ad_userid; ?>" required />
                <span class="help-block justify">Desired username for admin access. Username must not exceed 23 characters.</span>
            </div>
            <div class="form-group">
                <label>Display Name</label>
                <input type="text" class="form-control" name="disp_name" value="<?php echo $adm_info[0]->disp_name; ?>" required />
                <span class="help-block justify">Desired display name for this admin account. Must not exceed 23 characters.</span>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="change_pass" id="change_pass" value=1 /> Change password
                </label>
            </div>
            <div class="form-group">
                <label>Admin Old Password</label>
                <input type="password" class="form-control pass" name="useropw" disabled="true" />
                <span class="help-block justify">The current password being used for admin access.</span>
            </div>
            <div class="form-group">
                <label>Admin New Password</label>
                <input type="password" class="form-control pass" name="usernpw" disabled="true" />
                <span class="help-block justify">The new desired password for admin access.</span>
            </div>
            <div class="form-group">
                <label>Admin Confirm Password</label>
                <input type="password" class="form-control pass" name="usercpw" disabled="true" />
                <span class="help-block justify">Re-enter the new desired password for confirmation.</span>
            </div>
        </div>
    </div>
    <div class="spacer"></div>
    <div class="right">
        <input type="submit" class="btn btn-primary" name="submit" value="Save Changes" />
        <input type="reset" class="btn btn-default" value="Cancel" />
    </div>
</form>
<script type="text/javascript">
    $('#change_pass').change(function() {
        if($(this).is(':checked')) 
            $('.pass').removeAttr('disabled').attr('required','true');
        else
            $('.pass').attr('disabled', 'true');
    });
</script>