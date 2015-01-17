<ul class="nav nav-pills fr">
    <li>
        <a href="dashboard/currency?action=v4p">Vote 4 Points</a>
    </li>
    <li>
        <a href="dashboard/currency?action=donate">Donation</a>
    </li>
    <li class="active">
        <a href="dashboard/currency?action=settings">Settings</a>
    </li>
</ul>
<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
<div class="hr"></div>
<?php

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<form action="donate/update_settings" method="POST">
    <div class="form-group">
        <label>Paypal Merchant ID</label>
        <input type="text" class="form-control" name="pp_merch_id" value="<?php echo $cur_settings[0]->pp_merch_id; ?>" required />
        <span class="help-block">Unique and safe ID (string) provided by paypal.</span>
    </div>
    <div class="form-group">
        <label>Organization Name</label>
        <input type="text" class="form-control" name="pp_org_name" value="<?php echo $cur_settings[0]->pp_org_name; ?>" required />
        <span class="help-block">The item name or cause of the donation. Example: <strong>NameRO Donation</strong>.</span>
    </div>
    <div class="form-group">
        <label>Currency</label>
        <input type="text" class="form-control" name="pp_currency" value="<?php echo $cur_settings[0]->pp_currency; ?>" required />
        <span class="help-block">Currency code of the desired currency to be used. Refer to <a href="https://developer.paypal.com/docs/classic/api/currency_codes/" target="_new">Paypal&rsquo;s Currency Codes</a> for the correct code.</span>
    </div>
    <div class="form-group">
        <label>Return URL</label>
        <input type="text" class="form-control" name="return_url" value="<?php echo $cur_settings[0]->return_url; ?>" required />
        <span class="help-block">The trailing url which users are redirected to after a successful donation. Example: www.namero.com/<strong>donate/thankyou</strong></span>
    </div>
    <div class="form-group">
        <label>Cancel URL</label>
        <input type="text" class="form-control" name="cancel_url" value="<?php echo $cur_settings[0]->cancel_url; ?>" required />
        <span class="help-block">The trailing url which users are redirected to after a cancelled donation. Example: www.namero.com/<strong>cancel</strong></span>
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox" name="use_sandbox" value="1"<?php if(1 == $cur_settings[0]->use_sandbox){ echo ' checked'; } ?> /> Use sandbox (safe mode)
            <span class="help-block inline"></span>
        </label>
    </div>
    <div class="checkbox">
        <label>
            <input type="checkbox" name="status" value="1"<?php if(1 == $cur_settings[0]->status){ echo ' checked'; } ?> /> Enable donation
            <span class="help-block inline"></span>
        </label>
    </div>
    <div class="spacer"></div>
    <div class="right">
        <input type="submit" class="btn btn-primary" name="submit" value="Save Changes" />
        <input type="reset" class="btn btn-default" value="Cancel" />
    </div>
</form>