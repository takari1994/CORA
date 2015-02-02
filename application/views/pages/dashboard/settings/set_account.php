<ul class="nav nav-pills fr">
    <li>
        <a href="dashboard/settings/general">General</a>
    </li>
    <li class="active">
        <a href="dashboard/settings/account">Account</a>
    </li>
    <li>
        <a href="dashboard/settings/mailing">Mailing</a>
    </li>
    <li>
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
<form action="dashboard/settings/account?action=update" method="POST">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Allowed username characters</label>
                <input type="text" class="form-control" name="un_allow_char" value="<?php echo $settings[0]->un_allow_char; ?>" required />
                <span class="help-block justify">Specify using regex the format of proper <strong>username</strong>. Click <a href="http://youtu.be/3o0i1b5TOLA?t=1s">here</a> for regex tutorial.</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Username format error</label>
                <input type="text" class="form-control" name="un_format_error" value="<?php echo $settings[0]->un_format_error; ?>" maxlength=255 required />
                <span class="help-block justify">Error to be shown when the <strong>username</strong> does not follow the specified format.</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Allowed password characters</label>
                <input type="text" class="form-control" name="pw_allow_char" value="<?php echo $settings[0]->pw_allow_char; ?>" required />
                <span class="help-block justify">Specify using regex the format of proper <strong>password</strong>. Click <a href="http://youtu.be/3o0i1b5TOLA?t=1s">here</a> for regex tutorial.</span>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Password Format Error</label>
                <input type="text" class="form-control" name="pw_format_error" value="<?php echo $settings[0]->pw_format_error; ?>" maxlength=255 required />
                <span class="help-block justify">Error to be shown when the <strong>username</strong> does not follow the specified format.</span>
            </div>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <label>Minimum age for registrants</label>
                <input type="text" class="form-control" name="min_age" value="<?php echo $settings[0]->min_age; ?>" required />
                <span class="help-block justify">Use a whole number as value or 0 to disable. Users registered prior to changes are <strong>not</strong> affected.</span>
            </div>
            <div class="form-group">
                <label>Character reset position</label>
                <input type="text" class="form-control" name="char_res_pos" value="<?php echo $settings[0]->char_res_pos; ?>" />
                <span class="help-block">Value must follow the example format: <strong>prontera,155,170</strong> (map_name,x-pos,y-pos). Leave blank to disable position reset.</span>
            </div>
            <div class="form-group">
                <label>Disallow position reset from</label>
                <input type="text" class="form-control" name="char_no_res" value="<?php echo $settings[0]->char_no_res; ?>" />
                <span class="help-block">This will disallow position reset for characters in the specified maps above. Value must follow the format: <strong>map1,map2,...</strong></span>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="req_email_ver" value="1"<?php if(1 == $settings[0]->req_email_ver){ echo " checked"; } ?> /> Require e-mail verification
                    <span class="help-block inline"><strong>Note:</strong> Enabling this will disallow changing of emails in the profile page.</span>
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="email_allow_dupe" value="1"<?php if(1 == $settings[0]->email_allow_dupe){ echo " checked"; } ?> /> Allow duplicate email
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="sex_allow_change" value="1"<?php if(1 == $settings[0]->sex_allow_change){ echo " checked"; } ?> /> Allow sex change
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="bday_allow_change" value="1"<?php if(1 == $settings[0]->bday_allow_change){ echo " checked"; } ?> /> Allow birthday change
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="un_allow_change" value="1"<?php if(1 == $settings[0]->un_allow_change){ echo " checked"; } ?> /> Allow username change
                </label>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="req_capt_reg" value="1"<?php if(1 == $settings[0]->req_capt_reg){ echo " checked"; } ?> /> Require captcha on register
                </label>
                <span class="help-block inline"><strong>Note:</strong> Public and private keys <strong>must</strong> be provided in the <a href="dashboard/settings/general" alt="general settings">general settings</a> section.</span>
            </div>
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="use_md5" value="1"<?php if(1 == $settings[0]->use_md5){ echo " checked"; } ?> /> Use MD5 hash
                </label>
                <span class="help-block inline"><strong>Note:</strong> Hash password with md5. Existing account will not be affected. Your client must also be using md5.</span>
            </div>
            <div class="spacer"></div>
            <div class="right">
                <input type="submit" class="btn btn-primary" name="submit" value="Save Changes" />
                <input type="reset" class="btn btn-default" value="Cancel" />
            </div>
        </div>
    </div>
</form>