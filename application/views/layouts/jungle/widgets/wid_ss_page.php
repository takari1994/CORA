<div id="wid-<?php echo $wuid; ?>" class="panel panel-primary widget wid-ss"<?php if(0 == $wid_count){echo ' style="margin-top: 0 !important;"';} ?>>
    <div class="panel-heading">
        <img class="ss-img" src="img/jungle/ss-img.png">
        <span class="panel-title"><?php echo $title; ?></span>
    </div>
    <div class="panel-body">
        
        <table>
            <tr>
                <td class="desc text-left">MAP SERVER:</td>
                <td>
                <?php
                
                if(1 == $map)
                    echo '<span class="label label-success">ONLINE</span>';
                else
                    echo '<span class="label label-danger">OFFLINE</span>';
                
                ?>
                </td>
            </tr>
            <tr>
                <td class="desc text-left">CHAR SERVER:</td>
                <td>
                <?php
                
                if(1 == $char)
                    echo '<span class="label label-success">ONLINE</span>';
                else
                    echo '<span class="label label-danger">OFFLINE</span>';
                
                ?>
                </td>
                
            </tr>
            <tr>
                <td class="desc text-left">LOGIN SERVER:</td>
                <td>
                <?php
                
                if(1 == $login)
                    echo '<span class="label label-success">ONLINE</span>';
                else
                    echo '<span class="label label-danger">OFFLINE</span>';
                
                ?>
                </td>
            </tr>
            <tr>
                <?php if(1 == $player_online): ?>
                <td class="desc">PLAYERS ONLINE:</td>
                <td>
                    <?php
                    $json = file_get_contents(base_url().'community/player_statistics');
                    $ps   = json_decode($json);
                    echo '<span class="label label-primary">'.$ps->player_count.'</span>';
                    ?>
                </td>
                <?php endif; ?>
            </tr>
            <tr>
                <?php if(1 == $player_peak): ?>
                <td class="desc">ONLINE PEAK:</td>
                <td>
                    <?php
                    $json = file_get_contents(base_url().'community/player_statistics');
                    $ps   = json_decode($json);
                    echo '<span class="label label-primary">'.$ps->player_peak.'</span>';
                    ?>
                </td>
                <?php endif; ?>
            </tr>
        </table>
    </div>
</div>