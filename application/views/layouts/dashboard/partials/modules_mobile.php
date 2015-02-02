<div>
    <select class="form-control" id="module-select">
        <?php foreach($links as $link): ?>
        <option value="<?php echo $link->url; ?>"<?php if(strpos(current_url(),$link->url) !== FALSE){ echo ' selected'; } ?>><?php echo $link->desc; ?></option>
        <?php endforeach; ?>
    </select>
</div>
<script type="text/javascript">
    $('#module-select').change(function() {
        var val = $(this).val();
        document.location = val;
    });
</script>