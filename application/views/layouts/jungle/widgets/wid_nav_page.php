<div id="wid-<?php echo $wuid; ?>" class="panel panel-primary widget wid-nav"<?php if(0 == $wid_count){echo ' style="margin-top: 0 !important;"';} ?>>
    <div class="panel-heading">
        <img class="nav-img" src="img/jungle/nav-img.png">
        <span class="panel-title"><?php echo $title; ?></span>
    </div>
    <div class="list-group">
    <?php foreach($links as $link): ?>
        <a href="<?php echo $link['url']; ?>" class="list-group-item"><?php echo $link['label']; ?></a>
    <?php endforeach; ?>
    </div>
</div>