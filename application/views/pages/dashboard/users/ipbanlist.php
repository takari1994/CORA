<style type="text/css">
    .reason {
        color: #777;
        font-size: 11px;
    }
</style>
<ul class="nav nav-pills pull-right">
    <li><a href="dashboard/users">Users</a></li>
    <li><a href="dashboard/users/characters">Characters</a></li>
    <li class="active"><a href="dashboard/users/ip_ban_list">IP Ban List</a></li>
</ul>
<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
<div class="hr"></div>
<?php

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<div class="well well-sm text-center">
<form class="form-inline" action="dashboard/users/ip_ban_list" method="GET">
    <input type="text" class="form-control" name="query" placeholder="Search IP.." value="<?php if(isset($_GET['query']) AND null != $_GET['query']){ echo $_GET['query']; } ?>" />
    <select class="form-control" name="state">
        <optgroup label="State">
            <option value="all"<?php if(isset($_GET['state']) AND "all" == $_GET['state']){ echo ' selected'; } ?>>All</option>
            <option value="active"<?php if(isset($_GET['state']) AND "active" == $_GET['state']){ echo ' selected'; } ?>>Active</option>
            <option value="expired"<?php if(isset($_GET['state']) AND "expired" == $_GET['state']){ echo ' selected'; } ?>>Expired</option>
        </optgroup>
    </select>
    <select class="form-control" name="sort">
        <optgroup label="Sort By">
            <option value="btime"<?php if(isset($_GET['sort']) AND "btime" == $_GET['sort']){ echo ' selected'; } ?>>Ban Time</option>
            <option value="list"<?php if(isset($_GET['sort']) AND "list" == $_GET['sort']){ echo ' selected'; } ?>>IP</option>
            <option value="rtime"<?php if(isset($_GET['sort']) AND "rtime" == $_GET['sort']){ echo ' selected'; } ?>>Ban Duration</option>
        </optgroup>
    </select>
    <select class="form-control" name="order">
        <option value="asc"<?php if(isset($_GET['order']) AND "asc" == $_GET['order']){ echo ' selected'; } ?>>ASC</option>
        <option value="desc"<?php if(isset($_GET['order']) AND "desc" == $_GET['order']){ echo ' selected'; } ?>>DESC</option>
    </select>
    <button role="submit" class="btn btn-primary" name="search" value="true"><span class="glyphicon glyphicon-search"></span> Search</button>
</form>
</div>
<div class="spacer"></div>
<?php $page = (isset($_GET['page'])?$_GET['page']:1); ?>
<p>Showing <?php echo (($page-1)*PAGINATION_RPP)+count($ip_ban_list); ?> of <?php echo $tp; ?> result(s):</p>
<form method="GET" id="list-form">
    <input type="hidden" name="mode" value="ipban" />
    <table class="table table-striped">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="check-all" />
                </th>
                <th class="text-center">IP</th>
                <th class="text-center">Ban Time</th>
                <th class="text-center">Ban Duration</th>
                <th class="text-left" style="width: 40%;">Reason</th>
            </tr>
        </thead>
        <tbody>
            <?php if(0 < count($ip_ban_list)): foreach($ip_ban_list as $ip): ?>
            <tr>
                <td style="vertical-align: top !important;">
                    <input type="checkbox" name="ids[]" value="<?php echo $ip->list; ?>" />
                    <a class="anchor-btn no-redirect" onclick="deleteObject('ipban','<?php echo $ip->list; ?>');" href="#" data-toggle="tooltip" data-placement="top" title="Delete IP"><span class="glyphicon glyphicon-trash"></span></a>
                </td>
                <td style="vertical-align: top !important;">
                    <?php
                    if(date("Y-m-d H:i:s") < $ip->rtime){ echo '<span class="label label-success">Active</span>'; }else{ echo '<span class="label label-danger">Expired</span>'; }
                    echo '&nbsp;'.$ip->list;
                    ?>
                </td>
                <td class="text-center" style="vertical-align: top !important;"><?php echo $ip->btime; ?></td>
                <td class="text-center" style="vertical-align: top !important;"><?php echo $ip->rtime; ?></td>
                <td class="text-justify" style="vertical-align: top !important;">
                    <?php if(null != $ip->reason): ?>
                    <a href="#" class="no-redirect pull-right reason-toggle"> Show/Hide</a>
                    <?php echo character_limiter($ip->reason,30); ?>
                    <div class="reason"><?php echo $ip->reason; ?></div>
                    <?php else: ?>
                    <div style="font-style:italic;color:#ccc;">None</div>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
                <td>-</td>
                <td colspan="4" class="center"><em>No result found!</em></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</form>
<div class="inline-pagination-action" style="overflow: auto;">
    <?php
    
    if(null != $ip_ban_list) {
        $curpage = (isset($_GET['page'])?$_GET['page']:1);
        //Pagination
        pagination(current_url(),$tp,PAGINATION_RPP,PAGINATION_LPP,$curpage,'left');
    }
    
    ?>
    <div>
        <a href="dashboard/users/ip_ban_list?action=new" class="btn btn-primary">Add New IP</a>
        <button class="btn btn-default check-action" name="del-submit" id="del-submit" data-form-action="account/delete">Delete Selected</button>
    </div>
</div>
<script type="text/javascript">
    $('.anchor-btn').tooltip();
    $(document).ready(function() {
        $('.reason').hide();    
    });
    $('.reason-toggle').click(function() {
        $(this).siblings('div.reason').slideToggle();    
    });
</script>