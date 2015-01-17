<div id="wid-<?php echo $wuid; ?>" class="panel panel-primary widget wid-nav">
    <div class="panel-heading">
        <span class="panel-title"><?php echo $title; ?></span>
    </div>
    <div class="list-group">
    <?php foreach($links as $link): ?>
        <a href="<?php echo $link['url']; ?>" class="list-group-item"><?php echo $link['label']; ?></a>
    <?php endforeach; ?>
    </div>
</div>