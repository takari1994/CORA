<?php

if($_GET['action'] == 'new') { $active = 'Create a New Page'; } else { $active = 'Edit a Page'; }
breadcrumb($crumbs,$active);

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<?php if($_GET['action'] == 'edit'): ?><div class="alert alert-info"><strong>Page URL:</strong>&nbsp;<span id="autoselect" onclick="selectText('autoselect');"><?php echo base_url().'page/view?id='.$page[0]->page_id; ?></span></div><?php endif; ?>
<form action="<?php echo base_url(); ?>page/save" method="post">
<div class="pull-right">
    <input type="submit" name="submit" value="Save Post" class="btn btn-primary" />
    <a href="<?php echo current_url(); ?>" class="btn btn-default">Cancel</a>
</div>
<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
    <?php if($_GET['action'] == 'edit'): ?><input type="hidden" name="id" value="<?php echo $page[0]->page_id; ?>" /><?php endif; ?>
    <input type="text" name="title" class="form-control" maxlength="45" placeholder="Please enter a title.."<?php if(isset($page[0]->title)) echo ' value="'.$page[0]->title.'"'; ?> required />
<textarea name="pagecontent" class="ckeditor"><?php if(isset($page[0]->content)) echo $page[0]->content; ?></textarea>
<?php echo $this->load->view('assets/editor',array('name'=>'pagecontent')); ?>
</form>