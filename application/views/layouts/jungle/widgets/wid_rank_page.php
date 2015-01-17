<div id="wid-<?php echo $wuid; ?>" class="panel panel-primary widget wid-rank"<?php if(0 == $wid_count){echo ' style="margin-top: 0 !important;"';} ?>>
    <div class="panel-heading">
        <img class="pvp-img" src="img/jungle/pvp-img.png">
        <span class="panel-title"><?php echo $title; ?></span>
    </div>
    <div class="panel-body" role="tabpanel">
        <?php if(null != $pl && null != $gl): ?>
        <ul class="nav nav-tabs" role="tablist">
            <li role="presentation" class="active"><a href="#wid-<?php echo $wuid; ?>-pl-rank" data-toggle="tab"><img class="pvp-icon" src="img/jungle/pvp-icon.png">PVP</a></li>
            <li role="presentation"><a href="#wid-<?php echo $wuid; ?>-gl-rank" data-toggle="tab"><img class="guild-icon" src="img/jungle/guild-icon.png">Guild</a></li>
        </ul>
        <?php else: ?>
        <style type="text/css">
            div.wid-rank .panel-heading { padding-bottom: 5px !important; }
            div.wid-rank .panel-title { font-size: 20px !important; }
            div.wid-rank .tab-content { margin-top: 23px; }
        </style>
        <?php endif; ?>
        <div class="tab-content">
            <?php if(null != $pl): ?>
            <div role="tabpanel" class="tab-pane fade in active tbl-container" id="wid-<?php echo $wuid; ?>-pl-rank">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="center">Rank</th>
                            <th colspan="2">Name</th>
                            <?php if($plsort == 'k'): ?>
                            <th class="center">Kills</th>
                            <th class="center">Deaths</th>
                            <?php elseif($plsort == 'l'): ?>
                            <th class="center">BLvl</th>
                            <th class="center">BExp</th>
                            <?php elseif($plsort == 'z'): ?>
                            <th class="right">Zeny</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($x=0;$x<10;$x++): ?>
                        <?php if(array_key_exists($x,$pl)): ?>
                        <tr>
                            <td class="center"><?php echo $x+1; ?></td>
                            <td class="char-head-container-sm" style="background-image: url('ROChargen/characterhead/<?php echo $pl[$x]->name; ?>');background-repeat:no-repeat;background-position:-30px -38px;"></td>
                            <td><?php echo $pl[$x]->name; ?></td>
                            <?php if($plsort == 'k'): ?>
                            <td class="center"><?php echo (null!=$pl[$x]->kills?$pl[$x]->kills:'0'); ?></td>
                            <td class="center"><?php echo (null!=$pl[$x]->deaths?$pl[$x]->deaths:'0'); ?></td>
                            <?php elseif($plsort == 'l'): ?>
                            <td class="center"><?php echo (null!=$pl[$x]->base_level?$pl[$x]->base_level:'0'); ?></td>
                            <td class="center"><?php echo (null!=$pl[$x]->base_exp?$pl[$x]->base_exp:'0'); ?></td>
                            <?php elseif($plsort == 'z'): ?>
                            <td class="right"><?php echo number_format($pl[$x]->zeny,0,'.',','); ?></td>
                            <?php endif; ?>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <td class="center"><?php echo $x+1; ?></td>
                            <td style="width:24px;"></td>
                            <td>-</td>
                            <?php if($plsort == 'k' OR $plsort == 'l'): ?>
                            <td class="center">-</td>
                            <td class="center">-</td>
                            <?php elseif($plsort == 'z'): ?>
                            <td class="right">-</td>
                            <?php endif; ?>
                        </tr>
                        <?php endif; ?>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
            <?php if(null != $gl): ?>
            <div role="tabpanel" class="tab-pane fade<?php echo (null!=$gl&&null==$pl?' in active':''); ?> tbl-container" id="wid-<?php echo $wuid; ?>-gl-rank">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="center">Rank</th>
                            <th colspan="2">Name</th>
                            <?php if('c' == $glsort): ?>
                            <th class="center">Castles</th>
                            <th class="center">Level</th>
                            <?php else: ?>
                            <th class="center">Level</th>
                            <th class="center">Castles</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php for($x=0;$x<10;$x++): ?>
                        <?php if(array_key_exists($x,$gl)): ?>
                        <tr>
                            <td class="center"><?php echo $x+1; ?></td>
                            <td class="char-head-container-sm">
                                <?php if(null!=$gl[$x]->emblem){echo '<img src="community/guild_emblem/'.$gl[$x]->gid.'" alt="emblem" />';} ?>
                            </td>
                            <td><?php echo $gl[$x]->name; ?></td>
                            <?php if('c' == $glsort): ?>
                            <td class="center"><?php echo $gl[$x]->castles; ?></td>
                            <td class="center"><?php echo $gl[$x]->guild_lv; ?></td>
                            <?php else: ?>
                            <td class="center"><?php echo $gl[$x]->guild_lv; ?></td>
                            <td class="center"><?php echo $gl[$x]->castles; ?></td>
                            <?php endif; ?>
                        </tr>
                        <?php else: ?>
                        <tr>
                            <td class="center"><?php echo $x+1; ?></td>
                            <td style="width:24px;"></td>
                            <td>-</td>
                            <td class="center">-</td>
                            <td class="center">-</td>
                        </tr>
                        <?php endif; ?>
                        <?php endfor; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>    