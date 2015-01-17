<?php $main_nav_links = get_nav_links(1); ?>
<nav id="main-navigation">
    <div id="title-nav-holster-container">
        <div id="title-container">
            <img src="<?php echo base_url(); ?>img/logo.png" alt="logo" />
            <span><?php echo $serv_name; ?></span>
        </div>
        <ul id="nav-holster">
            <?php foreach($main_nav_links as $nav_link): ?>
            <li><a href="<?php echo $nav_link['url']; ?>" alt="<?php echo $nav_link['label']; ?>"><?php echo $nav_link['label']; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
</nav>