<ul class="nav nav-pills pull-right">
    <li class="active">
        <a id="ig-dropdown-trigger" href="#" data-toggle="dropdown" aria-haspopup="true">In-Game Logs <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="ig-dropdown-trigger">
            <li><a href="dashboard/logs/ingame-login">Login</a></li>
            <li><a href="dashboard/logs/chat">Chat</a></li>
            <li><a href="dashboard/logs/pick">Pick</a></li>
            <li><a href="dashboard/logs/zeny">Zeny</a></li>
            <li><a href="dashboard/logs/mvp">MVP</a></li>
            <li><a href="dashboard/logs/atcommand">Atcommand</a></li>
        </ul>
    </li>
    <li>
        <a id="web-dropdown-trigger" href="#" data-toggle="dropdown" aria-haspopup="true">Web Logs <span class="caret"></span></a>
        <ul class="dropdown-menu" role="menu" aria-labelledby="web-dropdown-trigger">
            <li><a href="dashboard/logs/web-login">Login</a></li>
            <li><a href="dashboard/logs/ban">Ban</a></li>
            <li><a href="dashboard/logs/shop">Shop</a></li>
            <li><a href="dashboard/logs/vote">Vote</a></li>
            <li><a href="dashboard/logs/donate">Donate</a></li>
            <li><a href="dashboard/logs/acc-update">Account Update</a></li>
        </ul>
    </li>
</ul>
<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
<div class="hr"></div>
<?php

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<div class="well well-sm text-center">
<form class="form form-inline" action="dashboard/logs/ingame-login" method="GET">
    <input type="text" class="form-control"  name="query" placeholder="Search log.."<?php if(isset($_GET['query'])){ echo ' value="'.$_GET['query'].'"';} ?> />
    <select class="form-control" name="field">
        <option value="ip"<?php if(isset($_GET['field']) AND 'ip' == $_GET['field']){echo ' selected';} ?>>IP</option>
        <option value="user"<?php if(isset($_GET['field']) AND 'user' == $_GET['field']){echo ' selected';} ?>>User</option>
        <option value="rcode"<?php if(isset($_GET['field']) AND 'rcode' == $_GET['field']){echo ' selected';} ?>>Code</option>
    </select>
    <select class="form-control" name="sort">
        <optgroup label="Sort By">
            <option value="time"<?php if(isset($_GET['sort']) AND 'time' == $_GET['sort']){echo ' selected';} ?>>Time</option>
            <option value="ip"<?php if(isset($_GET['sort']) AND 'ip' == $_GET['sort']){echo ' selected';} ?>>IP</option>
            <option value="User"<?php if(isset($_GET['sort']) AND 'user' == $_GET['sort']){echo ' selected';} ?>>User</option>
            <option value="rcode"<?php if(isset($_GET['sort']) AND 'rcode' == $_GET['sort']){echo ' selected';} ?>>Code</option>
        </optgroup>
    </select>
    <select class="form-control" name="order">
        <option value="desc"<?php if(isset($_GET['order']) AND 'desc' == $_GET['order']){echo ' selected';} ?>>DESC</option>
        <option value="asc"<?php if(isset($_GET['order']) AND 'asc' == $_GET['order']){echo ' selected';} ?>>ASC</option>
    </select>
    <button class="btn btn-primary" role="submit" name="search" value="1">
        <span class="glyphicon glyphicon-search"></span>&nbsp;Search
    </button>
</form>
</div>
<div class="spacer"></div>
<?php $page = (isset($_GET['page'])?$_GET['page']:1); ?>
<p>Showing <?php echo (($page-1)*PAGINATION_RPP)+count($logs); ?> of <?php echo $tp; ?> result(s):</p>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Time</th>
            <th class="center">IP</th>
            <th>User</th>
            <th class="center">Code</th> 
            <th>Response</th>    
        </tr>
    </thead>
    <tbody>
        <?php if(null != $logs): foreach($logs as $log): ?>
        <tr>
            <td><?php echo $log->time; ?></td>
            <td class="center"><?php echo $log->ip; ?></td>
            <td><?php echo $log->user; ?></td>
            <td class="center"><?php echo $log->rcode; ?></td>
            <td><?php echo $log->log; ?></td>
        </tr>
        <?php endforeach; else: ?>
        <tr>
            <td colspan="5" style="font-style: italic; color: #ccc;" class="center">No result found!</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
<?php

if(null != $logs) {
    $curpage = (isset($_GET['page'])?$_GET['page']:1);
    //Pagination
    pagination(current_url(),$tp,PAGINATION_RPP,PAGINATION_LPP,$curpage,'left');
}

?>