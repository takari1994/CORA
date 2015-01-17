<ul class="nav nav-pills fr">
    <li class="active">
        <a href="dashboard/currency?action=v4p">Vote 4 Points</a>
    </li>
    <li>
        <a href="dashboard/currency?action=donate">Donation</a>
    </li>
    <li>
        <a href="dashboard/currency?action=settings">Settings</a>
    </li>
</ul>
<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
<div class="hr"></div>
<?php

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<div class="well well-sm">
    <form action="v4p/add" method="POST" class="form-inline center">
        <input type="text" class="form-control" name="label" placeholder="Label" />
        <input type="text" class="form-control" name="url" placeholder="URL" />
        <input type="text" class="form-control" name="value" placeholder="Reward Amount (VPoints)" />
        <input type="submit" class="btn btn-primary" name="submit" value="Add Link" />
    </form>
</div>
<form action="v4p/delete" method="GET">
<table class="table table-striped">
    <thead>
        <tr>
            <th><input type="checkbox" id="check-all" /></th>
            <th>Image</th>
            <th>Label</th>
            <th>URL</th>
            <th>Reward</th>
            <th>Cooldown</th>
        </tr>
    </thead>
    <tbody>
        <?php if(null != $v4p_links): foreach($v4p_links as $link): ?>
        <tr>
            <td>
                <input type="checkbox" name="ids[]" value="<?php echo $link->v4p_id; ?>" />
                <a href="#" class="anchor-btn no-redirect" onclick="deleteObject('v4p',<?php echo $link->v4p_id; ?>);"><span class="glyphicon glyphicon-trash"></span></a>
                <a href="<?php echo current_url(); ?>?action=edit_v4p&id=<?php echo $link->v4p_id; ?>" class="anchor-btn"><span class="glyphicon glyphicon-pencil"></span></a>
            </td>
            <td><img src="<?php echo ($link->image ? $link->image:'img/def_vote.png'); ?>" class="vote-img" /></td>
            <td><?php echo $link->label; ?></td>
            <td><?php echo $link->url; ?></td>
            <td><?php echo $link->value; ?></td>
            <td><?php echo $link->cooldown; ?> minutes</td>
        </tr>
        <?php endforeach; else: ?>
        <tr>
            <td>-</td>
            <td>-</td>
            <td><em>No link found</em></td>
            <td>-</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
<div>
    <button class="btn btn-default check-action" name="del-submit" id="del-submit" data-form-action="page/delete">Delete Selected</button>
</div>
</form>