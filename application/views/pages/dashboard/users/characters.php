<ul class="nav nav-pills pull-right">
    <li><a href="dashboard/users">Users</a></li>
    <li class="active"><a href="dashboard/users/characters">Characters</a></li>
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
<form class="form-inline" action="dashboard/users/characters" method="GET">
    <input type="text" class="form-control" name="query" placeholder="Search character.." value="<?php if(isset($_GET['query']) AND null != $_GET['query']){ echo $_GET['query']; } ?>" />
    <select class="form-control" name="field">
        <option value="name"<?php if(isset($_GET['field']) AND "name" == $_GET['field']){ echo ' selected'; } ?>>Name</option>
        <option value="classid"<?php if(isset($_GET['field']) AND "classid" == $_GET['field']){ echo ' selected'; } ?>>Class ID</option>
        <option value="accountid"<?php if(isset($_GET['field']) AND "accountid" == $_GET['field']){ echo ' selected'; } ?>>Account ID</option>
        <option value="charid"<?php if(isset($_GET['field']) AND "charid" == $_GET['field']){ echo ' selected'; } ?>>Character ID</option>
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
            <option value="char_id"<?php if(isset($_GET['sort']) AND "char_id" == $_GET['sort']){ echo ' selected'; } ?>>Character ID</option>
            <option value="char.name"<?php if(isset($_GET['sort']) AND "char.name" == $_GET['sort']){ echo ' selected'; } ?>>Name</option>
            <option value="char.account_id"<?php if(isset($_GET['sort']) AND "char.account_id" == $_GET['sort']){ echo ' selected'; } ?>>Account ID</option>
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
<p>Showing <?php echo (($page-1)*PAGINATION_RPP)+count($chars); ?> of <?php echo $tp; ?> result(s):</p>
<form method="GET" id="list-form">
    <input type="hidden" name="mode" value="char" />
    <input type="hidden" name="action" id="action" />
    <table class="table table-striped">
        <thead>
            <tr>
                <th>
                    <input type="checkbox" id="check-all" />
                </th>
                <th colspan="2">Name</th>
                <th>Character ID</th>
                <th>Account ID</th>
                <th>Class</th>
                <th colspan="2">Guild</th>
            </tr>
        </thead>
        <tbody>
            <?php if(0 < count($chars)): foreach($chars as $char): ?>
            <tr>
                <td>
                    <input type="checkbox" name="ids[]" value="<?php echo $char->char_id; ?>" />
                    <a class="anchor-btn no-redirect" onclick="deleteObject('char',<?php echo $char->char_id; ?>);" href="#" data-toggle="tooltip" data-placement="top" title="Delete Character"><span class="glyphicon glyphicon-trash"></span></a>
                    <?php if('e' != $gen_settings[0]->emulator): ?>
                    <a class="anchor-btn" href="dashboard/users/characters?action=ban&ids%5B%5D=<?php echo $char->char_id; ?>" data-toggle="tooltip" data-placement="top" title="Ban Character"><span class="glyphicon glyphicon-ban-circle"></span></a>
                    <a class="anchor-btn<?php if(strtotime(date("Y-m-d H:i:s",time())) > $char->unban_time){ echo ' disabled no-redirect'; } ?>" href="dashboard/users/characters?action=unban&ids%5B%5D=<?php echo $char->char_id; ?>" data-toggle="tooltip" data-placement="top" title="Unban Character"><span class="glyphicon glyphicon-ok-circle"></span></a>
                    <?php endif; ?>
                </td>
                <td class="char-head-container" style="background-image: url('ROChargen/characterhead/<?php echo $char->name; ?>'); background-position: -10px -25px;"></td>
                <td>
                <?php
                if('e' != $gen_settings[0]->emulator) {
                    $timestamp = $char->unban_time; $unban_time = unix_to_human($timestamp);
                    if(strtotime(date("Y-m-d H:i:s",time())) > $char->unban_time){ echo '<span class="label label-success">Active</span>'; }else{ echo '<span class="label label-danger label-toggle" data-toggle="tooltip" data-placement="top" title="Until: '.$unban_time.'">Banned</span>'; }
                }
                echo '&nbsp;'.$char->name;
                ?></td>
                <td><?php echo $char->char_id; ?></td>
                <td><?php echo $char->account_id; ?></td>
                <td><?php echo class_name($char->class); ?></td>
                <td style="width: 24px;" class="center">
                    <?php if(null != $char->emblem): ?><img src="community/guild_emblem/<?php echo $char->guild_id; ?>" alt="emblem" /><?php else: ?>-<?php endif; ?>
                </td>
                <td>
                    <?php if(null != $char->guild_name): ?><?php echo $char->guild_name; ?><?php else: ?><span style="color:#ccc;font-style:italic;">None</span><?php endif; ?>
                </td>
            </tr>
            <?php endforeach; else: ?>
            <tr>
                <td>-</td>
                <td colspan="5" class="center"><em>No result found!</em></td>
            </tr>
            <?php endif; ?>
        </tbody>
    </table>
</form>
<div class="inline-pagination-action" style="overflow: auto;">
    <?php
    
    if(null != $chars) {
        $curpage = (isset($_GET['page'])?$_GET['page']:1);
        //Pagination
        pagination(current_url(),$tp,PAGINATION_RPP,PAGINATION_LPP,$curpage,'left');
    }
    
    ?>
    <div>
        <button class="btn btn-default check-action" name="del-submit" id="del-submit" data-form-action="account/delete">Delete Selected</button>
        <?php if('e' != $gen_settings[0]->emulator): ?>
        <button class="btn btn-danger check-action" name="ban-submit" id="ban-submit" data-form-action="dashboard/users/characters">Ban Selected</button>
        <button class="btn btn-success check-action" name="unban-submit" id="unban-submit" data-form-action="dashboard/users/characters">Unban Selected</button>
        <?php endif; ?>
    </div>
</div>
<script type="text/javascript">
    $('.anchor-btn').tooltip();
    $('.label-toggle').tooltip();
</script>