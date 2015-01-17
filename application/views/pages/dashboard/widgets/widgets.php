<select id="wid_areas" class="form-control pull-right tcp-input-sm">
    <option value="default">Choose Widget Area</option>
    <?php if(null != $wid_areas): foreach($wid_areas as $wid_area): ?>
    <option value="<?php echo $wid_area['id']; ?>"<?php if($wid_area['id'] == $_GET['area']){ echo ' selected'; } ?>><?php echo $wid_area['name']; ?></option>
    <?php endforeach; else: ?>
    <option>--None Available--</option>
    <?php endif; ?>
</select>
<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
<div class="hr"></div>
<?php

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<div class="row" id="wid_list_container">
    <?php
    
    $data['wid_list'] = $wid_list;
    $data['wid_area_wids'] = $wid_area_wids;
    $this->load->view('pages/dashboard/widgets/widgets_list',$data);
    
    ?>
</div>