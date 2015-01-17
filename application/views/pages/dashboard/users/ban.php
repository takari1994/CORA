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

if(!empty($ban_users_fail)):

?>
<div class="alert alert-danger">
    <strong>Error! The following <?php if('user' == $mode){ echo 'user'; }else{ echo 'character'; } ?>(s) cannot be banned:</strong>
    <div class="spacer"></div>
    <ul>
    <?php foreach($ban_users_fail as $ban_user_fail): ?>
    <li><?php echo $ban_user_fail['name']; ?></li>
    <?php endforeach; ?>
    </ul>
</div>
<div class="spacer"></div>
<?php endif; ?>
<?php if(!empty($ban_users)): ?>
<form action="account/ban" class="form form-inline" method="post">
<?php if('user' == $mode): ?>
<input type="hidden" name="mode" value="user" />
<?php else: ?>
<input type="hidden" name="mode" value="char" />
<?php endif; ?>
<div class="alert alert-warning">
    <strong>Warning! You are about to ban the following <?php if('user' == $mode){ echo 'user'; }else{ echo 'character'; } ?>(s):</strong>
    <div class="spacer"></div>
    <ul>
    <?php foreach($ban_users as $ban_user): ?>
    <li><input type="hidden" name="ban_id[]" value="<?php echo ('user'==$mode?$ban_user['account_id']:$ban_user['char_id']); ?>" /><?php echo $ban_user['name']; ?></li>
    <?php endforeach; ?>
    </ul>
</div>
<div class="spacer"></div>
<div class="row">
    <div class="col-md-12">
        <div class="well well-sm center">
            <input type="text" class="form-control datepicker-input" name="ban_date" placeholder="Ban Duration" data-date-format="yyyy-mm-dd" required />
            <input type="time" class="form-control" name="ban_time" required />
            <input type="submit" class="btn btn-danger" name="submit" value="Proceed &raquo;" />
        </div>
    </div>
</div>
</form>
<?php
$this->load->view('assets/datepicker');
else:
?>
<div class="alert alert-danger">
    <strong>Error!</strong> No proper user was selected to ban.
</div>
<?php endif; ?>