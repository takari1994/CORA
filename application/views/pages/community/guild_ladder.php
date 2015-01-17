<ul class="nav nav-tabs">
    <li><a href="community/player_ladder">Player Ladder</a></li>
    <li class="active"><a href="community/guild_ladder">Guild Ladder</a></li>
    <li><a href="community/castle_status">Castle Status</a></li>
    <li><a href="community/woe_schedule">WoE Schedule</a></li>
</ul>
<?php

$active = "Guild Ladder";
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
                    <option value="guild_lv"<?php if('guild_lv' == $_GET['sort']){ echo ' selected'; } ?>>Guild Level</option>
                    <option value="castles"<?php if('castles' == $_GET['sort']){ echo ' selected'; } ?>>Castles</option>
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
                        <th>Name</th>
                        <th class="center<?php if($_GET['sort'] == 'guild_lv'){echo ' warning';} ?>">Guild Level</th>
                        <th class="center<?php if($_GET['sort'] == 'castles'){echo ' warning';} ?>">Castles</th>
                        <th class="center">Guild Exp</th>
                        <th colspan="2">Master</th>
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
                        <td>
                            <?php if(null != $ladder[$x]->emblem): ?><img src="community/guild_emblem/<?php echo $ladder[$x]->gid; ?>" alt="emblem" /><?php else: ?><div style="display: inline-block; width: 24px;">&nbsp;</div><?php endif; ?>
                            <?php echo $ladder[$x]->name; ?>
                        </td>
                        <td class="center<?php if($_GET['sort'] == 'guild_lv'){echo ' warning';} ?>"><?php echo $ladder[$x]->guild_lv; ?></td>
                        <td class="center<?php if($_GET['sort'] == 'castles'){echo ' warning';} ?>"><?php echo $ladder[$x]->castles; ?></td>
                        <td class="center"><?php echo $ladder[$x]->exp; ?></td>
                        <td class="char-head-container" style="background: url('ROChargen/characterhead/<?php echo $ladder[$x]->master; ?>'); background-position: -10px -25px;">&nbsp;</td>
                        <td><?php echo $ladder[$x]->master; ?></td>
                    </tr>
                    <?php else: ?>
                    <tr>
                        <td class="center"><?php echo $start+($x+1); ?></td>
                        <td></td>
                        <td class="center<?php if($_GET['sort'] == 'guild_lv'){echo ' warning';} ?>"></td>
                        <td class="center<?php if($_GET['sort'] == 'castles'){echo ' warning';} ?>"></td>
                        <td class="center"></td>
                        <td></td>
                        <td></td>
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
        document.location = "community/guild_ladder?sort="+sort;
    });
</script>