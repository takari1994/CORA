<ul class="nav nav-tabs">
    <li><a href="community/player_ladder">Player Ladder</a></li>
    <li><a href="community/guild_ladder">Guild Ladder</a></li>
    <li class="active"><a href="community/castle_status">Castle Status</a></li>
    <li><a href="community/woe_schedule">WoE Schedule</a></li>
</ul>
<?php

$active = "Castle Status";
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
            <div class="row">
                <div class="col-md-6">
                    <!-- Prontera & Payon -->
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Castle</th>
                                <th>Owner</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for($x=15,$y=1;$x<20;$x++,$y++): ?>
                        <tr>
                            <td style="height: 41px;">prtg_cas0<?php echo $y; ?></td>
                            <td style="height: 41px;"><?php echo castle_name($x); ?></td>
                            <td style="height: 41px;"><?php if(array_key_exists($x,$castles)): ?><img src="community/guild_emblem/<?php echo $castles[$x]['id']; ?>" alt="emblem" />&nbsp;<?php echo $castles[$x]['name']; ?><?php else: ?><div style="display:inline-block;width:24px;">&nbsp;</div>&nbsp;<span style="font-style:italic;color:#ccc">None</span><?php endif; ?></td>
                        </tr>
                        <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Castle</th>
                                <th>Owner</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for($x=10,$y=1;$x<15;$x++,$y++): ?>
                        <tr>
                            <td style="height: 41px;">payg_cas0<?php echo $y; ?></td>
                            <td style="height: 41px;"><?php echo castle_name($x); ?></td>
                            <td style="height: 41px;"><?php if(array_key_exists($x,$castles)): ?><img src="community/guild_emblem/<?php echo $castles[$x]['id']; ?>" alt="emblem" />&nbsp;<?php echo $castles[$x]['name']; ?><?php else: ?><div style="display:inline-block;width:24px;">&nbsp;</div>&nbsp;<span style="font-style:italic;color:#ccc">None</span><?php endif; ?></td>
                        </tr>
                        <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <div class="spacer"></div>
                <!-- Geffen & Aldebaran -->
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Castle</th>
                                <th>Owner</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for($x=5,$y=1;$x<10;$x++,$y++): ?>
                        <tr>
                            <td style="height: 41px;">gefg_cas0<?php echo $y; ?></td>
                            <td style="height: 41px;"><?php echo castle_name($x); ?></td>
                            <td style="height: 41px;"><?php if(array_key_exists($x,$castles)): ?><img src="community/guild_emblem/<?php echo $castles[$x]['id']; ?>" alt="emblem" />&nbsp;<?php echo $castles[$x]['name']; ?><?php else: ?><div style="display:inline-block;width:24px;">&nbsp;</div>&nbsp;<span style="font-style:italic;color:#ccc">None</span><?php endif; ?></td>
                        </tr>
                        <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Castle</th>
                                <th>Owner</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for($x=0,$y=1;$x<5;$x++,$y++): ?>
                        <tr>
                            <td style="height: 41px;">aldeg_cas0<?php echo $y; ?></td>
                            <td style="height: 41px;"><?php echo castle_name($x); ?></td>
                            <td style="height: 41px;"><?php if(array_key_exists($x,$castles)): ?><img src="community/guild_emblem/<?php echo $castles[$x]['id']; ?>" alt="emblem" />&nbsp;<?php echo $castles[$x]['name']; ?><?php else: ?><div style="display:inline-block;width:24px;">&nbsp;</div>&nbsp;<span style="font-style:italic;color:#ccc">None</span><?php endif; ?></td>
                        </tr>
                        <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <div class="spacer"></div>
                <!-- Arug & Schg -->
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Castle</th>
                                <th>Owner</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for($x=29,$y=1;$x<34;$x++,$y++): ?>
                        <tr>
                            <td style="height: 41px;">arug_cas0<?php echo $y; ?></td>
                            <td style="height: 41px;"><?php echo castle_name($x); ?></td>
                            <td style="height: 41px;"><?php if(array_key_exists($x,$castles)): ?><img src="community/guild_emblem/<?php echo $castles[$x]['id']; ?>" alt="emblem" />&nbsp;<?php echo $castles[$x]['name']; ?><?php else: ?><div style="display:inline-block;width:24px;">&nbsp;</div>&nbsp;<span style="font-style:italic;color:#ccc">None</span><?php endif; ?></td>
                        </tr>
                        <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Castle</th>
                                <th>Owner</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php for($x=24,$y=1;$x<29;$x++,$y++): ?>
                        <tr>
                            <td style="height: 41px;">schg_cas0<?php echo $y; ?></td>
                            <td style="height: 41px;"><?php echo castle_name($x); ?></td>
                            <td style="height: 41px;"><?php if(array_key_exists($x,$castles)): ?><img src="community/guild_emblem/<?php echo $castles[$x]['id']; ?>" alt="emblem" />&nbsp;<?php echo $castles[$x]['name']; ?><?php else: ?><div style="display:inline-block;width:24px;">&nbsp;</div>&nbsp;<span style="font-style:italic;color:#ccc">None</span><?php endif; ?></td>
                        </tr>
                        <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>