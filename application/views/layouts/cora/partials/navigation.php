<?php $main_nav_links = get_nav_links(1); ?>
<nav id="main-navigation">
    <div class="container">
        <div class="row">
            <ul id="nav-holster">
                <?php foreach($main_nav_links as $nav_link): ?>
                <?php
                
                $cururl = current_url();
                
                if($cururl == $nav_link['url'] OR $cururl == base_url().$nav_link['url'])
                    $active = true;
                else
                    $active = false;
                
                ?>
                <li><a href="<?php echo $nav_link['url']; ?>" alt="<?php echo $nav_link['label']; ?>"<?php if($active){ echo ' class="active"'; } ?>><?php echo $nav_link['label']; ?></a></li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</nav>