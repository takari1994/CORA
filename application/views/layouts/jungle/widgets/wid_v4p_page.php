<?php $v4p_links = get_vote_links(); ?>
<div id="wid-<?php echo $wuid; ?>" class="panel panel-primary widget wid-v4p"<?php if(0 == $wid_count){echo ' style="margin-top: 0 !important;"';} ?>>
    <div class="panel-heading">
        <img class="widv4p-img" src="img/jungle/v4p-img.png">
        <span class="panel-title"><?php echo $title; ?></span>
    </div>
    <div class="panel-body center">
    <?php if(null != $v4p_links): foreach($v4p_links as $link): ?>
    <a href="v4p/vote?id=<?php echo $link['v4p_id']; ?>" style="background-image: url(<?php echo $link['image'] ?>);" class="v4p-img" >
        <?php echo $link['label']; ?> 
    </a>
    <?php endforeach; else: ?>
    <em>No link available</em>
    <?php endif; ?>
    </div>
</div>
