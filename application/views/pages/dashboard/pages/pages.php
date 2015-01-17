<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
<div class="hr"></div>
<?php

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<a href="<?php echo current_url(); ?>?action=new" class="btn btn-primary">Create New</a>
<button class="btn btn-default check-action" name="del-submit" id="del-submit" data-form-action="page/delete">Delete Selected</button>
<div class="spacer"></div>
<form method="GET" id="list-form">
<input type="hidden" name="action" id="action" />
<table class="table table-striped">
    <thead>
        <tr>
            <th><input type="checkbox" id="check-all" /></th>
            <th>Title</th>
            <th>Author</th>
            <th>Date</th>
        </tr>
    </thead>
    <tbody>
        <?php if(null == $pages): ?>
        <tr>
            <td>-</td>
            <td style="font-style:italic;">No page found</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <?php else: foreach($pages as $page): ?>
        <tr>
            <td>
                <input type="checkbox" name="ids[]" value="<?php echo $page->page_id; ?>" />
                <a href="#" class="anchor-btn no-redirect" onclick="deleteObject('page',<?php echo $page->page_id; ?>);"><span class="glyphicon glyphicon-trash"></span></a>
                <a href="<?php echo current_url(); ?>?action=edit&id=<?php echo $page->page_id; ?>" class="anchor-btn"><span class="glyphicon glyphicon-pencil"></span></a>
            </td>
            <td>
                <a href="<?php echo base_url().'page/view?id='.$page->page_id; ?>"><?php echo $page->title; ?></a></td>
            <td><?php echo $page->userid; ?></td>
            <td><?php echo $page->date; ?></td>
        </tr>
        <?php endforeach; endif; ?>
    </tbody>
</table>
</form>
<?php

if(null != $pages) {
    $curpage = (isset($_GET['page'])?$_GET['page']:1);
    //Pagination
    pagination(current_url(),$tp,10,PAGINATION_LPP,$curpage,'left');
}

?>