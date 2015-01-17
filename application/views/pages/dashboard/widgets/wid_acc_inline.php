<form id="wid-form" name="wid-ss-form" method="post">
    <input type="hidden" name="wuid" value="<?php echo $wu[0]->wid_used_id; ?>" />
    <input type="hidden" name="wid_id" value="<?php echo $wu[0]->wid_id; ?>" />
    <div class="form-group">
        <label>Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo $wu[0]->title; ?>" />
    </div>
</form>
<div class="right">
    <button class="btn btn-primary" id="wid_ss_btn" name="submit">Save Changes</button>
</div>
<script type="text/javascript">
    $('#wid_ss_btn').click(function() {
        var form = $('#wid-form').serialize();
        $('#wid-set-container').html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span>Loading...</span></div></div>');
        $.post('widget/update_wid_sett', form, function(data) {
           $('#wid-set-container').html(data); 
        });
    });
</script>