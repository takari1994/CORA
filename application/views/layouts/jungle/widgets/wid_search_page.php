<div id="wid-<?php echo $wuid; ?>" class="panel panel-primary widget wid-search"<?php if(0 == $wid_count){echo ' style="margin-top: 0 !important;"';} ?>>
    <div class="panel-heading">
        <img class="default-img" src="img/jungle/default-img.png">
        <span class="panel-title"><?php echo $title; ?></span>
    </div>
    <div class="panel-body">
    <form id="wid-<?php echo $wuid; ?>-search" class="wid-search-form" action="database" method="post">
        <input type="text" class="form-control" name="query" placeholder="Enter name.." />
        <div class="input-group">
            <select class="form-control" name="tbl">
                <option value="item">Item</option>
                <option value="mob">Monster</option>
            </select>
            <span class="input-group-btn">
                <input type="submit" class="btn btn-primary" name="submit" value="submit" />
            </span>
        </div>
    </form>
    </div>
</div>