<?php $main_nav_links = get_nav_links(1); ?>
<?php if(6 < count($main_nav_links)): ?>
<style type="text/css">
    #main-navigation ul#nav-holster li a {
        font-size: 12px !important;
    }
</style>
<?php endif; ?>
<nav id="main-navigation" class="text-center">
    <ul id="nav-holster">
        <li class="nav-wingl"><img src="img/jungle/nav-wingL.png"></li>
        <?php for($x=0;$x<count($main_nav_links)/2;$x++): ?>
        <li><a href="<?php echo $main_nav_links[$x]['url']; ?>" alt="<?php echo $main_nav_links[$x]['label']; ?>"><?php echo $main_nav_links[$x]['label']; ?></a></li>
        <?php endfor; ?>
        <li style="height: 250px;"><img src="img/logo.png" class="server-logo" alt="logo" /></li>
        <?php for($x=$x;$x<count($main_nav_links);$x++): ?>
        <li><a href="<?php echo $main_nav_links[$x]['url']; ?>" alt="<?php echo $main_nav_links[$x]['label']; ?>"><?php echo $main_nav_links[$x]['label']; ?></a></li>
        <?php endfor; ?>
        <li class="nav-wingr"><img src="img/jungle/nav-wingR.png"></li>
    </ul>
</nav>