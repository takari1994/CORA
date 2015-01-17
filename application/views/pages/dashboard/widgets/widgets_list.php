<style type="text/css">
    .loading-container {
        display: none;
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        background-color: rgba(255,255,255,0.5);
        background-image: url('img/loading.gif');
        background-position: center;
        background-repeat: no-repeat;
        background-size: 10%;
        z-index: 3;
    }
</style>
<div class="col-md-4" id="widget_list">
    <div class="loading-container">&nbsp;</div>
    <div class="input-group">
        <select id="wid_select" class="form-control">
            <?php foreach($wid_list as $wid): ?>
            <option value="<?php echo $wid->wid_id; ?>"><?php echo $wid->desc; ?></option>
            <?php endforeach; ?>
        </select>
        <span class="input-group-btn">
            <button class="btn btn-primary" id="wid_select_btn"><span class="glyphicon glyphicon-plus"></span> Widget</button>
        </span>
    </div>
    <form>
    <?php if(null != $wid_area_wids):foreach($wid_area_wids as $waw): ?>
    <div class="input-group">
        <input type="button" class="btn btn-block btn-default wid-sett" data-wuid="<?php echo $waw['wuid']; ?>" value="<?php echo $waw['desc']; ?>" />
        <div class="input-group-btn">
          <button type="button" class="btn btn-default move" data-movement="0" value="<?php echo $waw['position']; ?>"<?php if(1 == $waw['position']){ echo ' disabled'; } ?>><span class="glyphicon glyphicon-arrow-up"></span></button>
          <button type="button" class="btn btn-default move" data-movement="1" value="<?php echo $waw['position']; ?>"<?php if(count($wid_area_wids) == $waw['position']){ echo ' disabled'; } ?>><span class="glyphicon glyphicon-arrow-down"></span></button>
          <button type="button" class="btn btn-default delete" data-wuid="<?php echo $waw['wuid']; ?>"><span class="glyphicon glyphicon-trash"></span></button>
        </div>
    </div>
    <?php endforeach; else: ?>
    <em>No widget found</em>
    <?php endif; ?>
    </form>
</div>
<div class="col-md-8" id="wid-set-container">
</div>
<script type="text/javascript">
    $('#wid_areas').change(function() {
        var val = $(this).val();
        if (val != 'default') {
            window.location = "dashboard/widgets?area="+val;
        }
    });
    $('#wid_select_btn').click(function() {
        var wid_id = $('#wid_select').val();
        var parent = $('#wid_areas').val();
        $('.loading-container').css('display','block');
        $.post('widget/add', { wid_id: wid_id, parent: parent }, function(data) {
            $('#wid_list_container').html(data);
        });
    });
    $('.wid-sett').click(function() {
        var wuid = $(this).attr('data-wuid');
        $('#wid-set-container').html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span>Loading...</span></div></div>');
        $.post('widget/wid_sett', { wuid: wuid }, function(data) {
            $('#wid-set-container').html(data);
        });
    });
    $('.move').click(function() {
        var movement = $(this).attr('data-movement');
        var old_pos = $(this).val();
        var parent = $('#wid_areas').val();
        $('.loading-container').css('display','block');
        $.post('widget/switch_pos', { parent: parent, move: movement, old_pos: old_pos}, function(data) {
            $('#wid_list_container').html(data);    
        });
    });
    $('.delete').click(function() {
        var wuid = $(this).attr('data-wuid');
        var parent = $('#wid_areas').val();
        $('.loading-container').css('display','block');
        $.post('widget/delete', { wuid: wuid, parent: parent }, function(data) {
            $('#wid_list_container').html(data);    
        });
    });
</script>