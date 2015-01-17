<ul class="nav nav-pills fr">
    <li>
        <a href="dashboard/currency?action=v4p">Vote 4 Points</a>
    </li>
    <li class="active">
        <a href="dashboard/currency?action=donate">Donation</a>
    </li>
    <li>
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
<form action="donate/update" method="post">
    <input type="hidden" name="id" value="<?php echo $donate_amount[0]->donate_id; ?>" />
    <div class="form-group">
        <label>Amount</label>
        <input type="text" class="form-control" name="amount" value="<?php echo $donate_amount[0]->amount; ?>" />
        <span class="help-block">The amount to donate. Please enter pure integer, <strong>no non-numeric nor float values</strong>.</span>
    </div>
    <div class="form-group">
        <label>Reward</label>
        <input type="text" class="form-control" name="value" value="<?php echo $donate_amount[0]->value; ?>" />
        <span class="help-block">The amount of <strong>credits</strong> given to users for donating the amount above.</span>
    </div>
    <div class="spacer"></div>
    <div class="right">
        <input type="submit" class="btn btn-primary" name="submit" value="Save Changes" />
        <a href="<?php echo current_url(); ?>" class="btn btn-default">Cancel</a>
    </div>
</form>