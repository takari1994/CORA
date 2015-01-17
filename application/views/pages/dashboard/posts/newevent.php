<?php

if($_GET['action'] == 'new') { $active = 'Create a New Post'; } else { $active = 'Edit an Event'; }
breadcrumb($crumbs,$active);

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<form action="<?php echo base_url(); ?>post/save/event" method="post">
<div class="pull-right">
    <input type="submit" name="submit" value="Save Post" class="btn btn-primary" />
    <a href="<?php echo current_url(); ?>" class="btn btn-default">Cancel</a>
</div>
<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
    <div class="row">
        <?php if($_GET['action'] == 'edit'): ?><input type="hidden" name="id" value="<?php echo $event[0]->post_id; ?>" /><?php endif; ?>
        <div class="col-sm-6"><input type="text" name="title" class="form-control" maxlength="45" placeholder="Please enter a title"<?php if(isset($event[0]->title)) echo ' value="'.$event[0]->title.'"'; ?> required /></div>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="text" name="eventStart" class="datepicker-input form-control" placeholder="Event Start"<?php if(isset($event[0]->start)) echo ' value="'.$event[0]->start.'"'; ?> data-date-format="yyyy-mm-dd" required />
                <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="input-group">
                <input type="text" name="eventEnd" class="datepicker-input form-control" placeholder="Event End"<?php if(isset($event[0]->end)) echo ' value="'.$event[0]->end.'"'; ?> data-date-format="yyyy-mm-dd" required />
                <div class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></div>
            </div>
        </div>
    </div>
    <?php $this->load->view('assets/datepicker'); ?>
<textarea name="postcontent" class="ckeditor"><?php if(isset($event[0]->content)) echo $event[0]->content; ?></textarea>
<?php echo $this->load->view('assets/editor',array('name'=>'postcontent')); ?>
</form>