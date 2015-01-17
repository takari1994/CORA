<ul class="nav nav-tabs">
    <li class="active"><a href="community/player_ladder">Player Ladder</a></li>
    <li><a href="community/guild_ladder">Guild Ladder</a></li>
    <li><a href="community/castle_status">Castle Status</a></li>
    <li><a href="community/woe_schedule">WoE Schedule</a></li>
</ul>
<?php

$active = "Player Ladder";
breadcrumb($crumbs,$active);

?>
<div class="container-fluid v4p-container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="page-title"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
            <div class="spacer"></div>
            <?php
            if(isset($_GET['msgcode'])) {
                echo parse_msgcode($_GET['msgcode']);
            }
            ?>
            <div style="overflow: auto;">
            <form class="form form-inline pull-left">
                <label>Order By:</label>
                <select class="form-control" id="order">
                    <option value="kills"<?php if('kills' == $_GET['sort']){ echo ' selected'; } ?>>Kills</option>
                    <option value="base_level"<?php if('base_level' == $_GET['sort']){ echo ' selected'; } ?>>Base Level</option>
                    <option value="job_level"<?php if('job_level' == $_GET['sort']){ echo ' selected'; } ?>>Job Level</option>
                    <option value="zeny"<?php if('zeny' == $_GET['sort']){ echo ' selected'; } ?>>Zeny</option>
                </select>
            </form>
            <?php
            
            if(null != $ladder) {
                $curpage = (isset($_GET['page'])?$_GET['page']:1);
                //Pagination
                pagination(current_url(),$tp,10,PAGINATION_LPP,$curpage,'right');
            }
            
            ?>
            </div>
            <div class="spacer"></div>
            <div class="ladder-container">
            <table class="table ladder-list">
                <thead>
                    <tr>
                        <th class="center">Rank</th>
                        <th colspan=2>Name</th>
                        <th class="center<?php if($_GET['sort'] == 'kills'){echo ' warning';} ?>">Kills</th>
                        <th class="center">Deaths</th>
                        <th class="center">KDR</th>
                        <th class="center<?php if($_GET['sort'] == 'base_level'){echo ' warning';} ?>">Base Level</th>
                        <th class="center<?php if($_GET['sort'] == 'job_level'){echo ' warning';} ?>">Job Level</th>
                        <th>Base Exp</th>
                        <th>Job Exp</th>
                        <th>Class</th>
                        <th>Guild</th>
                        <th class="right<?php if($_GET['sort'] == 'zeny'){echo ' warning';} ?>">Zeny</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($x=0;$x<10;$x++): ?>
                    <?php
                    if(isset($_GET['page']) AND 2 <= $_GET['page'])
                        $start = ($_GET['page']-1)*10;
                    else
                        $start = 0;
                    if($x < count($ladder)):
                    ?>
                    <tr>
                        <td class="center"><?php echo $start+($x+1); ?></td>
                        <td class="char-head-container" style="background: url('ROChargen/characterhead/<?php echo $ladder[$x]->name; ?>'); background-position: -10px -25px;"></td>
                        <td><?php echo $ladder[$x]->name; ?></td>
                        <td class="center<?php if($_GET['sort'] == 'kills'){echo ' warning';} ?>"><?php echo (null != $ladder[$x]->kills?$ladder[$x]->kills:'0'); ?></td>
                        <td class="center"><?php echo (null != $ladder[$x]->deaths?$ladder[$x]->deaths:'0'); ?></td>
                        <td class="center">
                            <?php
                            if(0 == $ladder[$x]->deaths)
                                echo "&infin;";
                            else
                                echo number_format($ladder[$x]->kills/$ladder[$x]->deaths,2,'.',',');
                            ?>
                        </td>
                        <td class="center<?php if($_GET['sort'] == 'base_level'){echo ' warning';} ?>"><?php echo $ladder[$x]->base_level; ?></td>
                        <td class="center<?php if($_GET['sort'] == 'job_level'){echo ' warning';} ?>"><?php echo $ladder[$x]->job_level; ?></td>
                        <td><?php echo number_format($ladder[$x]->base_exp,0,'.',','); ?></td>
                        <td><?php echo number_format($ladder[$x]->job_exp,0,'.',','); ?></td>
                        <td><?php echo class_name($ladder[$x]->class); ?></td>
                        <td>
                            <?php if(null != $ladder[$x]->emblem): ?><img src="community/guild_emblem/<?php echo $ladder[$x]->guild_id; ?>" alt="guild emblem" /><?php else: ?><div style="display: inline-block; width: 24px;">&nbsp;</div><?php endif; ?>&nbsp;
                            <?php if(null != $ladder[$x]->guild_name){ echo $ladder[$x]->guild_name; } else { echo '<span style="font-style:italic;color: #ccc;">None</span>'; } ?>
                        </td>
                        <td class="right<?php if($_GET['sort'] == 'zeny'){echo ' warning';} ?>"><?php echo number_format($ladder[$x]->zeny,0,'.',','); ?></td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <td class="center"><?php echo $start+($x+1); ?></td>
                        <td></td>
                        <td></td>
                        <td class="center<?php if($_GET['sort'] == 'kills'){echo ' warning';} ?>"></td>
                        <td class="center"></td>
                        <td class="center"></td>
                        <td class="center<?php if($_GET['sort'] == 'base_level'){echo ' warning';} ?>"></td>
                        <td class="center<?php if($_GET['sort'] == 'job_level'){echo ' warning';} ?>"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td class="right<?php if($_GET['sort'] == 'zeny'){echo ' warning';} ?>"></td>
                    </tr>
                    <?php endif; ?>
                    <?php endfor; ?>
                </tbody>
            </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('#order').change(function() {
        var sort = $(this).val();
        document.location = "community/player_ladder?sort="+sort;
    });
</script>