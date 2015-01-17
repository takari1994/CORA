<ul class="nav nav-pills fr">
    <li>
        <a href="dashboard/settings/general">General</a>
    </li>
    <li>
        <a href="dashboard/settings/account">Account</a>
    </li>
    <li class="active">
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
<form action="dashboard/settings/mailing?action=update" method="POST">
    <div class="row">
        <div class="col-md-12">
            <div class="form-group">
                <label>Select service</label>
                <select class="form-control tcp-input-md block" name="active_service" id="service">
                    <option value="SMTP"<?php if('SMTP' == $settings[0]->active_service){ echo ' selected'; } ?>>SMTP</option>
                    <option value="MAIL"<?php if('MAIL' == $settings[0]->active_service){ echo ' selected'; } ?>>PHP Mail</option>
                </select>
                <span class="help-block">Choose the service that your would like to use.</span>
            </div>
            <div id="smtp">
                <div class="form-group">
                    <label>SMTP Host</label>
                    <input type="text" class="form-control" name="smtp_host" value="<?php echo $settings[0]->smtp_host; ?>" />
                    <span class="help-block">Use SMTP Host provided by mailer as value. Click <a href="https://www.digitalocean.com/community/tutorials/how-to-use-google-s-smtp-server" target="new" alt="Google SMTP Host">here</a> for Google's SMTP Host.</span>
                </div>
                <div class="form-group">
                    <label>SMTP Port</label>
                    <input type="text" class="form-control" name="smtp_port" value="<?php echo $settings[0]->smtp_port; ?>" />
                    <span class="help-block">Use SMTP Port provided by mailer as value. Click <a href="https://www.digitalocean.com/community/tutorials/how-to-use-google-s-smtp-server" target="new" alt="Google SMTP Port">here</a> for Google's SMTP Port.</span>
                </div>
                <div class="form-group">
                    <label>E-mail Address</label>
                    <input type="email" class="form-control" name="email_smtp" value="<?php echo $settings[0]->email_smtp; ?>" />
                    <span class="help-block">Use your email account as value. The email <strong>must</strong> belong to the SMTP Host specified above.</span>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" class="form-control" name="userpass" value="<?php echo $settings[0]->userpass; ?>" />
                    <span class="help-block">Use the password of the email provided above as value.</span>
                </div>
            </div>
            <div id="mail">
                <div class="form-group">
                    <label>E-mail Address</label>
                    <input type="email" class="form-control" name="email" value="<?php echo $settings[0]->email; ?>" />
                    <span class="help-block">Use an email address from your website&rsquo;s e-mail accounts as value.</span>
                </div>
            </div>
            <div class="spacer"></div>
            <div class="right">
                <input type="submit" class="btn btn-primary" name="submit" value="Save Changes" />
                <input type="reset" class="btn btn-default" value="Cancel" />
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
    $(document).ready(function() {
        var cur_service = $('#service').val();
        if (cur_service == 'SMTP') {
            $('#mail').hide();
        } else {
            $('#smtp').hide();
        }
    });
    
    $('#service').change(function() {
        var cur_service = $(this).val();
        if (cur_service == 'SMTP') {
            $('#mail').hide(400,function() {
                $('#smtp').show(400);    
            });
        } else {
            $('#smtp').hide(400,function() {
                $('#mail').show(400);    
            });
        }
    });
</script>