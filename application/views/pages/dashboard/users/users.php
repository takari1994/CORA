<ul class="nav nav-pills pull-right">
    <li class="active"><a href="dashboard/users">Users</a></li>
    <li><a href="dashboard/users/characters">Characters</a></li>
    <li><a href="dashboard/users/ip_ban_list">IP Ban List</a></li>
</ul>
<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
<div class="hr"></div>
<?php

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<div class="well well-sm text-center">
<form class="form-inline" action="dashboard/users" method="GET">
    <input type="text" class="form-control" name="query" placeholder="Search user.." value="<?php if(isset($_GET['query']) AND null != $_GET['query']){ echo $_GET['query']; } ?>" />
    <select class="form-control" name="field">
        <option value="userid"<?php if(isset($_GET['field']) AND "userid" == $_GET['field']){ echo ' selected'; } ?>>Username</option>
        <option value="accountid"<?php if(isset($_GET['field']) AND "accountid" == $_GET['field']){ echo ' selected'; } ?>>Account ID</option>
        <option value="fname"<?php if(isset($_GET['field']) AND "fname" == $_GET['field']){ echo ' selected'; } ?>>First Name</option>
        <option value="lname"<?php if(isset($_GET['field']) AND "lname" == $_GET['field']){ echo ' selected'; } ?>>Last Name</option>
        <option value="lastip"<?php if(isset($_GET['field']) AND "lastip" == $_GET['field']){ echo ' selected'; } ?>>Last IP</option>
    </select>
    <select class="form-control" name="state">
        <optgroup label="State">
            <option value="all"<?php if(isset($_GET['state']) AND "all" == $_GET['state']){ echo ' selected'; } ?>>All</option>
            <option value="active"<?php if(isset($_GET['state']) AND "active" == $_GET['state']){ echo ' selected'; } ?>>Active</option>
            <option value="banned"<?php if(isset($_GET['state']) AND "banned" == $_GET['state']){ echo ' selected'; } ?>>Banned</option>
        </optgroup>
    </select>
    <select class="form-control" name="sort">
        <optgroup label="Sort By">
            <option value="account_id"<?php if(isset($_GET['sort']) AND "account_id" == $_GET['sort']){ echo ' selected'; } ?>>Account ID</option>
            <option value="userid"<?php if(isset($_GET['sort']) AND "userid" == $_GET['sort']){ echo ' selected'; } ?>>Username</option>
            <option value="fname"<?php if(isset($_GET['sort']) AND "fname" == $_GET['sort']){ echo ' selected'; } ?>>First Name</option>
            <option value="lname"<?php if(isset($_GET['sort']) AND "lname" == $_GET['sort']){ echo ' selected'; } ?>>Last Name</option>
            <option value="lastlogin"<?php if(isset($_GET['sort']) AND "lastlogin" == $_GET['sort']){ echo ' selected'; } ?>>Last Login</option>
            <option value="last_ip"<?php if(isset($_GET['sort']) AND "last_ip" == $_GET['sort']){ echo ' selected'; } ?>>Last IP</option>
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
<p>Showing <?php echo (($page-1)*PAGINATION_RPP)+count($users); ?> of <?php echo $tp; ?> result(s):</p>
<form method="GET" id="list-form">
    <input type="hidden" name="mode" value="user" />
    <input type="hidden" name="action" id="action" />
    <table class="table table-striped">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="check-all" />
                </th>
                <th>Username</th>
                <th>Account ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Last Login</th>
                <th>Last IP</th>
            </tr>
        </thead>
        <tbody>
        <?php if(null != $users): foreach($users as $user): ?>
            <tr>
                <td>
                    <input type="checkbox" name="ids[]" value="<?php echo $user->account_id; ?>" />
                    <a class="anchor-btn no-redirect" onclick="deleteObject('user',<?php echo $user->account_id; ?>);" href="#" data-toggle="tooltip" data-placement="top" title="Delete Account"><span class="glyphicon glyphicon-trash"></span></a>
                    <a class="anchor-btn" href="dashboard/users?action=ban&ids%5B%5D=<?php echo $user->account_id; ?>" data-toggle="tooltip" data-placement="top" title="Ban Account"><span class="glyphicon glyphicon-ban-circle"></span></a>
                    <a class="anchor-btn<?php if(strtotime(date("Y-m-d H:i:s",time())) > $user->unban_time){ echo ' disabled no-redirect'; } ?>" href="dashboard/users?action=unban&ids%5B%5D=<?php echo $user->account_id; ?>" data-toggle="tooltip" data-placement="top" title="Unban Account"><span class="glyphicon glyphicon-ok-circle"></span></a>  
                    <a class="anchor-btn" href="account/profile?id=<?php echo $user->account_id; ?>" target="_blank" data-toggle="tooltip" data-placement="top" title="Edit Account"><span class="glyphicon glyphicon-pencil"></span></a>
                </td>
                <?php $timestamp = $user->unban_time; $unban_time = unix_to_human($timestamp); ?>
                <td>
                <?php
                if(strtotime(date("Y-m-d H:i:s",time())) > $user->unban_time){ echo '<span class="label label-success">Active</span>'; }else{ echo '<span class="label label-danger label-toggle" data-toggle="tooltip" data-placement="top" title="Until: '.$unban_time.'">Banned</span>'; }
                echo ' <a href="'.base_url().'account/profile?id='.$user->account_id.'" alt="View User" target="_blank">'.$user->userid.'</a>';
                ?>
                </td>
                <td><?php echo $user->account_id; ?></td>
                <td><?php echo $user->fname; ?></td>
                <td><?php echo $user->lname; ?></td>
                <td><?php echo $user->lastlogin; ?></td>
                <td><?php echo $user->last_ip; ?></td>
            </tr>
        <?php endforeach; else: ?>
            <tr>
                <td>-</td>
                <td colspan="6" class="center"><em>No result found!</em></td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</form>
<div class="inline-pagination-action" style="overflow: auto;">
    <?php
    
    if(null != $users) {
        $curpage = (isset($_GET['page'])?$_GET['page']:1);
        //Pagination
        pagination(current_url(),$tp,PAGINATION_RPP,PAGINATION_LPP,$curpage,'left');
    }
    
    ?>
    <div>
        <button class="btn btn-default check-action" name="del-submit" id="del-submit" data-form-action="account/delete">Delete Selected</button>
        <button class="btn btn-danger check-action" name="ban-submit" id="ban-submit" data-form-action="dashboard/users">Ban Selected</button>
        <button class="btn btn-success check-action" name="unban-submit" id="unban-submit" data-form-action="dashboard/users">Unban Selected</button>
    </div>
</div>
<script type="text/javascript">
    $('.anchor-btn').tooltip();
    $('.label-toggle').tooltip();
</script>