<ul class="nav nav-pills fr">
    <li class="active">
        <a href="dashboard/currency?action=v4p">Vote 4 Points</a>
    </li>
    <li>
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
<form action="v4p/update" method="post">
    <input type="hidden" name="id" value="<?php echo $v4p_link[0]->v4p_id; ?>" />
    <div class="form-group">
        <label>Image URL</label>
        <input type="text" class="form-control" name="image" value="<?php echo $v4p_link[0]->image; ?>" />
        <span class="help-block">URL of image you want to display for this V4P link.</span>
    </div>
    <div class="form-group">
        <label>Label</label>
        <input type="text" class="form-control" name="label" value="<?php echo $v4p_link[0]->label; ?>" />
        <span class="help-block">Name of the game ranking site.</span>
    </div>
    <div class="form-group">
        <label>URL</label>
        <input type="text" class="form-control" name="url" value="<?php echo $v4p_link[0]->url; ?>" />
        <span class="help-block">The url of your server on <strong><?php echo $v4p_link[0]->label; ?></strong>. It is provided by the ranking site.</span>
    </div>
    <div class="form-group">
        <label>Reward</label>
        <input type="text" class="form-control" name="value" value="<?php echo $v4p_link[0]->value; ?>" />
        <span class="help-block">The amount of <strong>VPoints</strong> given to users each vote using this link.</span>
    </div>
    <div class="form-group">
        <label>Cooldown</label>
        <input type="text" class="form-control" name="cooldown" value="<?php echo $v4p_link[0]->cooldown; ?>" />
        <span class="help-block">Number of minutes before a user can vote using this link again.</span>
    </div>
    <div class="spacer"></div>
    <div class="right">
        <input type="submit" class="btn btn-primary" name="submit" value="Save Changes" />
        <a href="<?php echo current_url(); ?>" class="btn btn-default">Cancel</a>
    </div>
</form>