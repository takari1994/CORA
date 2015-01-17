<div id="links-container">

<?php if(0 < count($links)): ?>
<table class="table">
    <thead>
        <tr>
            <th><strong>Label</strong></th>
            <th><strong>URL</strong></th>
            <th><strong>Action</strong></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($links as $link): ?>
        <tr>
            <td style="width: 45%;">
                <input type="hidden" name="id" value="<?php echo $link->nav_li_id; ?>" />
                <input type="text" data-li-id="<?php echo $link->nav_li_id; ?>" class="form-control label-input" name="label" value="<?php echo $link->label; ?>" />
            </td>
            <td style="width: 45%;">
                <input type="text" data-li-id="<?php echo $link->nav_li_id; ?>" class="form-control url-input" name="url" value="<?php echo $link->url; ?>" />
            </td>
            <td>
                <div class="input-group">
                    <div class="input-group-btn">
                      <button class="btn btn-default" onclick="switchPos(<?php echo $link->position; ?>,0);" <?php if(1 == $link->position) { echo ' disabled'; } ?>><span class="glyphicon glyphicon-arrow-up"></span></button>
                      <button class="btn btn-default" onclick="switchPos(<?php echo $link->position; ?>,1);" <?php if(count($links) == $link->position) { echo ' disabled'; } ?>><span class="glyphicon glyphicon-arrow-down"></span></button>
                      <button class="btn btn-default" onclick="deleteLink(<?php echo $link->nav_li_id; ?>);"><span class="glyphicon glyphicon-trash"></span></button>
                    </div>
                </div>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<?php else: ?>
<div style="font-style: italic;">No link found</div>
<?php endif; ?>
</div>
<script type="text/javascript">
    $('.label-input').change(function() {
        var label = $(this).val();
        var nav_li_id = $(this).attr('data-li-id');
        $('#nav_links').html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span>Loading...</span></div></div>');
        $.post('navigation/change_nav_li_label', { nav_id: $('#navid').val(), id: nav_li_id, label: label }, function(data) {
            $('#nav_links').html(data);
        });
    });
    
    $('.url-input').change(function() {
        var url = $(this).val();
        var nav_li_id = $(this).attr('data-li-id');
        $('#nav_links').html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span>Loading...</span></div></div>');
        $.post('navigation/change_nav_li_url', { nav_id: $('#navid').val(), id: nav_li_id, url: url }, function(data) {
            $('#nav_links').html(data);
        });
    });
</script>