<div id="wid-<?php echo $wuid; ?>" class="panel panel-primary widget wid-ss-inline">
    <div class="panel-heading" style="display: none;">
        <span class="panel-title"><?php echo $title; ?></span>
    </div>
    <ul>
        <li class="desc">Map Server:&nbsp;</li>
        <li class="val">
        <?php
        
        if(1 == $map)
            echo '<span class="label label-success">Online</span>';
        else
            echo '<span class="label label-danger">Offline</span>';
        
        ?>
        </li>
        <li class="desc">Char Server:&nbsp;</li>
        <li class="val">
        <?php
        
        if(1 == $char)
            echo '<span class="label label-success">Online</span>';
        else
            echo '<span class="label label-danger">Offline</span>';
        
        ?>
        </li>
        <li class="desc">Login Server:&nbsp;</li>
        <li class="val">
        <?php
        
        if(1 == $login)
            echo '<span class="label label-success">Online</span>';
        else
            echo '<span class="label label-danger">Offline</span>';
        
        ?>
        </li>
    </ul>
</div>