<div id="wid-<?php echo $wuid; ?>" class="panel panel-primary widget wid-ss">
    <div class="panel-heading">
        <span class="panel-title"><?php echo $title; ?></span>
    </div>
    <div class="panel-body">
        
        <table>
            <tr>
                <td class="desc text-right">Map Server</td>
                <td>
                <?php
                
                if(1 == $map)
                    echo '<span class="label label-success">ON</span>';
                else
                    echo '<span class="label label-danger">OFF</span>';
                
                ?>
                </td>
                <?php if(1 == $player_online): ?>
                <td class="desc text-right">Players Online</td>
                <td>
                    <?php
                    $json = file_get_contents(base_url().'community/player_statistics');
                    $ps   = json_decode($json);
                    echo '<span class="label label-warning">'.$ps->player_count.'</span>';
                    ?>
                </td>
                <?php elseif(1 == $player_peak): ?>
                <td class="desc text-right">Online Peak</td>
                <td>
                    <?php
                    $json = file_get_contents(base_url().'community/player_statistics');
                    $ps   = json_decode($json);
                    echo '<span class="label label-warning">'.$ps->player_peak.'</span>';
                    ?>
                </td>
                <?php endif; ?>
            </tr>
            <tr>
                <td class="desc text-right">Char Server</td>
                <td>
                <?php
                
                if(1 == $char)
                    echo '<span class="label label-success">ON</span>';
                else
                    echo '<span class="label label-danger">OFF</span>';
                
                ?>
                </td>
                <?php if(1 == $player_online AND 1 == $player_peak): ?>
                <td class="desc text-right">Players Peak</td>
                <td>
                    <?php
                    $json = file_get_contents(base_url().'community/player_statistics');
                    $ps   = json_decode($json);
                    echo '<span class="label label-warning">'.$ps->player_peak.'</span>';
                    ?>
                </td>
                <?php endif; ?>
            </tr>
            <tr>
                <td class="desc text-right">Login Server</td>
                <td>
                <?php
                
                if(1 == $login)
                    echo '<span class="label label-success">ON</span>';
                else
                    echo '<span class="label label-danger">OFF</span>';
                
                ?>
                </td>
            </tr>
        </table>
    </div>
</div>