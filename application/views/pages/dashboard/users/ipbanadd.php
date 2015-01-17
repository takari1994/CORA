<?php

$active = "Add New IP";
breadcrumb($crumbs,$active);

?>
<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
<div class="hr"></div>
<div class="spacer"></div>
<?php

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<form action="account/ip_ban_add">
    <div class="row">
        <div class="col-md-4 col-md-offset-2"><input type="text" class="form-control" name="ip" placeholder="IP" required /></div>
        <div class="col-md-2"><input type="text" class="form-control datepicker-input" name="ban_date" placeholder="Ban Duration" data-date-format="yyyy-mm-dd" required /></div>
        <div class="col-md-2"><input type="time" class="form-control" name="ban_time" required /></div>
    </div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <textarea name="reason" maxlength="255" class="form-control" rows="10" placeholder="Reason [ Optional | Up to 255 Characters ]"></textarea>
        </div>
    </div>
    <div class="spacer"></div>
    <div class="row">
        <div class="col-md-8 col-md-offset-2 text-center">
            <input type="submit" class="btn btn-primary" name="submit" value="Add New IP" />
        </div>
    </div>
</form>
<?php
$this->load->view('assets/datepicker');
?>