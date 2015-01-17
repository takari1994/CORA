<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
<div class="hr"></div>
<?php

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<div class="btn-group">
    <a href="<?php echo current_url(); ?>?action=new&type=news" class="btn btn-primary">Create New</a>
    <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown">
      <span class="caret"></span>
      <span class="sr-only">Toggle Dropdown</span>
    </button>
    <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
      <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo current_url(); ?>?action=new&type=news">News</a></li>
      <li role="presentation"><a role="menuitem" tabindex="-1" href="<?php echo current_url(); ?>?action=new&type=event">Event</a></li>
    </ul>
</div>
<button href="#" class="btn btn-default check-action" name="del-submit" id="del-submit" data-form-action="post/delete">Delete Selected</button>
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
        <?php if(null == $posts): ?>
        <tr>
            <td>-</td>
            <td style="font-style:italic;">No post found</td>
            <td>-</td>
            <td>-</td>
        </tr>
        <?php else: foreach($posts as $post): ?>
        <tr>
            <td>
                <input type="checkbox" name="ids[]" value="<?php echo $post->post_id; ?>" />
                <a href="#" class="anchor-btn no-redirect" onclick="deleteObject('post',<?php echo $post->post_id; ?>);"><span class="glyphicon glyphicon-trash"></span></a>
                <a href="<?php echo current_url(); ?>?action=edit&type=<?php echo ($post->type == 1 ? 'news':'event' ) ?>&id=<?php echo $post->post_id; ?>" class="anchor-btn"><span class="glyphicon glyphicon-pencil"></span></a>
            </td>
            <td>
                <?php
                    
                switch($post->type) {
                    case 1:
                        echo '<div class="label label-primary">News</div>'; break;
                    case 2:
                        echo '<div class="label label-warning">Event</div>'; break;
                    case 3:
                        echo '<div class="label label-info">Logs</div>';
                }
                    
                ?>
                <a href="<?php echo base_url().'post/view?id='.$post->post_id; ?>"><?php echo $post->title; ?></a></td>
            <td><?php echo $post->userid; ?></td>
            <td><?php echo $post->date; ?></td>
        </tr>
        <?php endforeach; endif; ?>
    </tbody>
</table>
</form>
<?php

if(null != $posts) {
    $curpage = (isset($_GET['page'])?$_GET['page']:1);
    //Pagination
    pagination(current_url(),$tp,10,PAGINATION_LPP,$curpage,'left');
}

?>