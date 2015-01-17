<?php

if('user' == $mode)
    $active = 'Ban Users';
else
    $active = 'Ban Characters';
    
breadcrumb($crumbs,$active);

?>
<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
<?php

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

if(!empty($unban_users_fail)):

?>
<div class="alert alert-danger">
    <strong>Error! The following <?php if('user' == $mode){ echo 'user'; }else{ echo 'character'; } ?>(s) cannot be unbanned:</strong>
    <div class="spacer"></div>
    <ul>
    <?php foreach($unban_users_fail as $unban_user_fail): ?>
    <li><?php echo $unban_user_fail['name']; ?></li>
    <?php endforeach; ?>
    </ul>
</div>
<div class="spacer"></div>
<?php endif; ?>
<?php if(!empty($unban_users)): ?>
<form action="account/unban" method="post">
<?php if('user' == $mode): ?>
<input type="hidden" name="mode" value="user" />
<?php else: ?>
<input type="hidden" name="mode" value="char" />
<?php endif; ?>
<div class="alert alert-warning">
    <strong>Are you sure you want to unban the following <?php if('user' == $mode){ echo 'user'; }else{ echo 'character'; } ?>(s):</strong>
    <div class="spacer"></div>
    <ul>
    <?php foreach($unban_users as $unban_user): ?>
    <li><input type="hidden" name="unban_id[]" value="<?php echo ('user'==$mode?$unban_user['account_id']:$unban_user['char_id']); ?>" /><?php echo $unban_user['name']; ?></li>
    <?php endforeach; ?>
    </ul>
</div>
<div class="spacer"></div>
<div class="center">
    <input type="submit" class="btn btn-lg btn-primary" name="submit" value="Proceed &raquo;" />
</div>
</form>
<?php
$this->load->view('assets/datepicker');
else:
?>
<div class="alert alert-danger">
    <strong>Error!</strong> No proper user was selected to unban.
</div>
<?php endif; ?>