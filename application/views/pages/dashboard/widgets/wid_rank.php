<form id="wid-form" name="wid-ss-form" method="post">
    <input type="hidden" name="wuid" value="<?php echo $wu[0]->wid_used_id; ?>" />
    <input type="hidden" name="wid_id" value="<?php echo $wu[0]->wid_id; ?>" />
    <div class="form-group">
        <label>Title</label>
        <input type="text" class="form-control" name="title" value="<?php echo $wu[0]->title; ?>" />
    </div>
    <div class="form-group">
        <label>Display</label>
        <select class="form-control" name="data[0]">
            <option value="b"<?php echo ('b'==$wu_info[0]->display?' selected':''); ?>>Both</option>
            <option value="p"<?php echo ('p'==$wu_info[0]->display?' selected':''); ?>>Player</option>
            <option value="g"<?php echo ('g'==$wu_info[0]->display?' selected':''); ?>>Guild</option>
        </select>
    </div>
    <div class="form-group">
        <label>Player Ladder Sorting</label>
        <select class="form-control" name="data[1]">
            <option value="k"<?php echo ('k'==$wu_info[0]->pl_rank_sort?' selected':''); ?>>Rank by Kills</option>
            <option value="l"<?php echo ('l'==$wu_info[0]->pl_rank_sort?' selected':''); ?>>Rank by Base Level</option>
            <option value="z"<?php echo ('z'==$wu_info[0]->pl_rank_sort?' selected':''); ?>>Rank by Zeny</option>
        </select>
    </div>
    <div class="form-group">
        <label>Guild Ladder Sorting</label>
        <select class="form-control" name="data[2]">
            <option value="l"<?php echo ('l'==$wu_info[0]->gl_rank_sort?' selected':''); ?>>Rank by Guild level</option>
            <option value="c"<?php echo ('c'==$wu_info[0]->gl_rank_sort?' selected':''); ?>>Rank by No. of Castles</option>
        </select>
    </div>
</form>
<div class="right">
    <button class="btn btn-primary" id="wid_rank_btn" name="submit">Save Changes</button>
</div>
<script type="text/javascript">
    $('#wid_rank_btn').click(function() {
        var form = $('#wid-form').serialize();
        $('#wid-set-container').html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span>Loading...</span></div></div>');
        $.post('widget/update_wid_sett', form, function(data) {
           $('#wid-set-container').html(data); 
        });
    });
</script>