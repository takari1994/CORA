<div id="nav">
        <ul>
            <?php $count=0;foreach($links as $link): ?>
            <li>
                <a href="<?php echo $link->url; ?>"
                <?php if(0 == $count){ echo ' class="top';if(strpos(current_url(),$link->url) !== FALSE){echo ' active';}echo '"'; }
                else if(strpos(current_url(),$link->url) !== FALSE){echo ' class="active"';} ?>>
                    <div>
                    <?php
                    
                    echo $link->desc;
                    if(strpos(current_url(),$link->url) !== FALSE){ echo '<span class="glyphicon glyphicon-chevron-right fr"></span>'; }
                    
                    ?>
                    </div>
                </a>
            </li>
            <?php $count++;endforeach; ?>
            <li><div class="bottom"></div></li>
        </ul>
</div>