<form id="wid-form" name="wid-ss-form" method="post">
    <input type="hidden" name="wuid" value="<?php echo $wu[0]->wid_used_id; ?>" />
    <input type="hidden" name="wid_id" value="<?php echo $wu[0]->wid_id; ?>" />
    <div class="form-group">
        <label>Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo $wu[0]->title; ?>" />
    </div>
    <div class="form-group">
        <label>Server IP</label>
        <input type="text" class="form-control" name="data[0]" value="<?php echo $wu_info[0]->ip; ?>" />
    </div>
    <div class="form-group">
        <label>Map Port</label>
        <input type="text" class="form-control" name="data[1]" value="<?php echo $wu_info[0]->port_map; ?>" />
    </div>
    <div class="form-group">
        <label>Char Port</label>
        <input type="text" class="form-control" name="data[2]" value="<?php echo $wu_info[0]->port_char; ?>" />
    </div>
    <div class="form-group">
        <label>Login Port</label>
        <input type="text" class="form-control" name="data[3]" value="<?php echo $wu_info[0]->port_login; ?>" />
    </div>
    <div class="checkbox">
        <label>
            <input type="hidden" name="data[4]" value="0" />
            <input type="checkbox" name="data[4]" value="1"<?php echo (1 == $wu_info[0]->player_online ? ' checked':''); ?> /> Display online players
        </label>
    </div>
    <div class="checkbox">
        <label>
            <input type="hidden" name="data[5]" value="0" />
            <input type="checkbox" name="data[5]" value="1"<?php echo (1 == $wu_info[0]->player_peak ? ' checked':''); ?> /> Display peak players
        </label>
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