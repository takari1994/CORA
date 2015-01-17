<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
<div class="hr"></div>
<?php

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<form class="form-inline" action="dashboard/navigation?action=new" method="post">
    <input type="text" class="form-control" name="desc" placeholder="Navigation Description" required />
    <input type="submit" class="btn btn-primary" name="newnav" value="Create New" />
</form>
<div class="spacer"></div>
<form method="GET" id="list-form">
<input type="hidden" name="action" id="action" />
<table class="table table-striped">
    <thead>
        <tr>
            <th><input type="checkbox" id="check-all" /></th>
            <th>Description</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        <?php if(null == $navs): ?>
        <tr>
            <td>-</td>
            <td style="font-style:italic;">No navigation found</td>
            <td>-</td>
        </tr>
        <?php else: $count = 0; foreach($navs as $nav): ?>
        <tr>
            <td style="width: 100px;">
                <input type="checkbox" <?php if(0 < $count): ?>name="ids[]"<?php endif; ?> value="<?php echo $nav->nav_id; ?>"<?php if(0 == $count){ echo ' disabled';} ?> />
                <a href="#" class="anchor-btn no-redirect<?php if(0 == $count){ echo ' disabled';} ?>" <?php if(0 < $count): ?>onclick="deleteObject('nav',<?php echo $nav->nav_id; ?>);"<?php endif; ?>><span class="glyphicon glyphicon-trash"></span></a>
                <a href="<?php echo current_url(); ?>?action=edit&id=<?php echo $nav->nav_id; ?>" class="anchor-btn"><span class="glyphicon glyphicon-pencil"></span></a>
            </td>
            <td><?php echo $nav->description; ?></td>
            <td>
            <?php if(1 == $nav->status): ?>
                <em>In use - Main navigation</em>
            <?php elseif(1 == is_nav_wid($nav->nav_id)): ?>
                <em>In use - Widget</em>
            <?php else: ?>
                <em>Not in use.</em>
            <?php endif; ?>
            </td>
        </tr>
        <?php $count++; endforeach; endif; ?>
    </tbody>
</table>
</form>
<div>
    <button class="btn btn-default check-action" name="del-submit" id="del-submit" data-form-action="navigation/delete">Delete Selected</button>
</div>