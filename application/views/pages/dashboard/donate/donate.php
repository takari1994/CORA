<ul class="nav nav-pills fr">
    <li>
        <a href="dashboard/currency?action=v4p">Vote 4 Points</a>
    </li>
    <li class="active">
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
    <form action="donate/add" method="POST" class="form-inline center">
        <input type="text" class="form-control" name="amount" placeholder="Amount" />
        <input type="text" class="form-control" name="value" placeholder="Reward Amount (Credits)" />
        <input type="submit" class="btn btn-primary" name="submit" value="Add Link" />
    </form>
</div>
<form action="donate/delete" method="GET">
<table class="table table-striped">
    <thead>
        <tr>
            <th><input type="checkbox" id="check-all" /></th>
            <th>Amount</th>
            <th>Reward (Credits)</th>
        </tr>
    </thead>
    <tbody>
        <?php if(null != $donate_amounts): foreach($donate_amounts as $amount): ?>
        <tr>
            <td>
                <input type="checkbox" name="ids[]" value="<?php echo $amount->donate_id; ?>" />
                <a href="#" class="anchor-btn no-redirect" onclick="deleteObject('donate',<?php echo $amount->donate_id; ?>);"><span class="glyphicon glyphicon-trash"></span></a>
                <a href="<?php echo current_url(); ?>?action=edit_donate&id=<?php echo $amount->donate_id; ?>" class="anchor-btn"><span class="glyphicon glyphicon-pencil"></span></a>
            </td>
            <td><?php echo $amount->amount; ?></td>
            <td><?php echo $amount->value; ?></td>
        </tr>
        <?php endforeach; else: ?>
        <tr>
            <td>-</td>
            <td><em>No link found</em></td>
            <td>-</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>
<div>
    <button class="btn btn-default check-action" name="del-submit" id="del-submit" data-form-action="page/delete">Delete Selected</button>
</div>
</form>