<?php if($this->session->userdata('admin_userid')): ?>
<div id="switch">
    <div class="pull-right admin-info">
        Welcome, <?php echo $this->session->userdata('admin_userid'); ?>&nbsp;
        <a href="dashboard/settings/admin"><span class="glyphicon glyphicon-cog"></span> Admin Profile</a>&nbsp;
        <a href="admin/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a>
    </div>
    <a href="<?php echo base_url(); ?>dashboard">
        <div class="switch-btn fl">
            <span class="glyphicon glyphicon-th-large"></span>
            Dashboard
        </div>
    </a>
    <a href="<?php echo base_url(); ?>">
        <div class="switch-btn fl last">
            <span class="glyphicon glyphicon-globe"></span>
            Website
        </div>
    </a>
</div>
<?php endif; ?>