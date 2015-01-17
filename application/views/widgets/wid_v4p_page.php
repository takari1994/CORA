<?php $v4p_links = get_vote_links(); ?>
<div id="wid-<?php echo $wuid; ?>" class="panel panel-primary widget wid-v4p">
    <div class="panel-heading">
        <span class="panel-title"><?php echo $title; ?></span>
    </div>
    <div class="panel-body center">
    <?php if(null != $v4p_links): foreach($v4p_links as $link): ?>
    <a href="v4p/vote?id=<?php echo $link['v4p_id']; ?>" class="wid-vote-link">
        <img src="<?php echo ($link['image'] ? $link['image']:'img/def_vote.png'); ?>" style="height:55px!important;" />
    </a><br />
    <?php endforeach; else: ?>
    <em>No link available</em>
    <?php endif; ?>
    </div>
</div>
