<style type="text/css">
    .note {
        color: #777;
        font-size: 11px;
    }
</style>
<ul class="nav nav-pills pull-right">
    <li>
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
    <li class="active">
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
<form class="form form-inline" action="dashboard/logs/ban" method="GET">
    <input type="text" class="form-control"  name="query" placeholder="Search log.."<?php if(isset($_GET['query'])){ echo ' value="'.$_GET['query'].'"';} ?> />
    <select class="form-control" name="field">
        <option value="user1"<?php if(isset($_GET['field']) AND 'user1' == $_GET['field']){echo ' selected';} ?>>Banned ID/IP</option>
        <option value="user2"<?php if(isset($_GET['field']) AND 'user2' == $_GET['field']){echo ' selected';} ?>>Admin ID</option>
        <option value="ip"<?php if(isset($_GET['field']) AND 'ip' == $_GET['field']){echo ' selected';} ?>>IP</option>
    </select>
    <select class="form-control" name="type">
        <optgroup label="Type">
            <option value="all"<?php if(isset($_GET['type']) AND 'all' == $_GET['type']){echo ' selected';} ?>>All</option>
            <option value="IP Ban"<?php if(isset($_GET['type']) AND 'IP Ban' == $_GET['type']){echo ' selected';} ?>>IP Ban</option>
            <option value="Char Ban"<?php if(isset($_GET['type']) AND 'Char Ban' == $_GET['type']){echo ' selected';} ?>>Char Ban</option>
            <option value="Account Ban"<?php if(isset($_GET['type']) AND 'Account Ban' == $_GET['type']){echo ' selected';} ?>>Account Ban</option>
        </optgroup>
    </select>
    <select class="form-control" name="sort">
        <optgroup label="Sort By">
            <option value="date"<?php if(isset($_GET['sort']) AND 'date' == $_GET['sort']){echo ' selected';} ?>>Time</option>
            <option value="type"<?php if(isset($_GET['sort']) AND 'type' == $_GET['sort']){echo ' selected';} ?>>Type</option>
            <option value="user1"<?php if(isset($_GET['sort']) AND 'user1' == $_GET['sort']){echo ' selected';} ?>>Banned ID/IP</option>
            <option value="user2"<?php if(isset($_GET['sort']) AND 'user2' == $_GET['sort']){echo ' selected';} ?>>Admin ID</option>
            <option value="ip"<?php if(isset($_GET['sort']) AND 'ip' == $_GET['sort']){echo ' selected';} ?>>IP</option>
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
            <th>Type</th>
            <th class="center">Banned ID / IP</th>
            <th class="center">Admin ID</th>
            <th class="center">IP</th>
            <th style="width: 315px;">Details</th>
        </tr>
    </thead>
    <tbody>
        <?php if(null != $logs): foreach($logs as $log): ?>
        <tr>
            <td style="vertical-align: top !important;"><?php echo $log->date; ?></td>
            <td style="vertical-align: top !important;"><?php echo $log->type; ?></td>
            <td style="vertical-align: top !important;" class="center"><?php echo ('IP Ban' == $log->type?$log->user1_str:$log->user1); ?></td>
            <td style="vertical-align: top !important;" class="center"><?php echo $log->user2; ?></td>
            <td style="vertical-align: top !important;" class="center"><?php echo $log->ip; ?></td>
            <td style="vertical-align: top !important;">
                <a href="#" class="no-redirect pull-right note-toggle"> Show/Hide</a>
                <?php echo character_limiter($log->note,30); ?>
                <div class="note"><?php echo $log->note; ?></div>
            </td>
        </tr>
        <?php endforeach; else: ?>
        <tr>
            <td colspan="6" style="font-style: italic; color: #ccc;" class="center">No result found!</td>
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
<script type="text/javascript">
    $(document).ready(function() {
        $('.note').hide();    
    });
    $('.note-toggle').click(function() {
        $(this).siblings('.note').slideToggle();    
    });
</script>