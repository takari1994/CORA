<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
<div class="hr"></div>
<div style="font-size: 10px;"><strong>NOTE:</strong> ALL CHANGES YOU MAKE IS AUTOMATICALLY SAVED.</div>
<div class="spacer"></div>
<div class="row">
    <div class="col-md-4">
        <input type="hidden" name="navid" id="navid" value="<?php echo $nav[0]->nav_id; ?>" />
        <div class="input-group">
            <input type="text" name="label" placeholder="Label" class="form-control" id="new-label" />
            <span class="input-group-btn"><button class="btn btn-primary no-redirect" role="submit" onclick="addlink();"><span class="glyphicon glyphicon-plus"></span> Link</button></span>
        </div>
    </div>
</div>
<div class="spacer"></div>
<!-- Links -->
<div id="nav_links">
<?php

$data['links'] = $nav_li;
$this->load->view('pages/dashboard/navs/nav_links',$data);

?>
</div>
<!-- End of Links -->
<script type="text/javascript">
    function addlink() {
        if (!$('#new-label').val()) {
            alert("Label cannot be empty!");
        } else {
            $('#nav_links').html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span>Loading...</span></div></div>');
            $.post('navigation/add_nav_li', { nav_id: $('#navid').val(), label: $('#new-label').val() }, function(data) {
                $('#nav_links').html(data);
            });
        }
    }
    
    function deleteLink(nav_li_id) {
        var conf = window.confirm("Are you sure you want to delete this?");
        if (conf) {
            $('#nav_links').html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span>Loading...</span></div></div>');
            $.post('navigation/delete_nav_li', { nav_id: $('#navid').val(), id: nav_li_id }, function(data) {
                $('#nav_links').html(data);
            });
        }
    }
    
    function switchPos(pos, move) {
        $('#nav_links').html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span>Loading...</span></div></div>');
        $.post('navigation/switch_nav_li_pos', { nav_id: $('#navid').val(), old_pos: pos, move: move }, function(data) {
            $('#nav_links').html(data);
        });
    }
    
</script>