<?php

if($_GET['action'] == 'new') { $active = 'Create a New Post'; } else { $active = 'Edit a News'; }
breadcrumb($crumbs,$active);

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<form action="<?php echo base_url(); ?>post/save/news" method="post">
<div class="pull-right">
    <input type="submit" name="submit" value="Save Post" class="btn btn-primary" />
    <a href="<?php echo current_url(); ?>" class="btn btn-default">Cancel</a>
</div>
<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
    <?php if($_GET['action'] == 'edit'): ?><input type="hidden" name="id" value="<?php echo $news[0]->post_id; ?>" /><?php endif; ?>
    <input type="text" name="title" class="form-control" maxlength="45" placeholder="Please enter a title.."<?php if(isset($news[0]->title)) echo ' value="'.$news[0]->title.'"'; ?> required />
<textarea name="postcontent" class="ckeditor"><?php if(isset($news[0]->content)) echo $news[0]->content; ?></textarea>
<?php echo $this->load->view('assets/editor',array('name'=>'postcontent')); ?>
</form>