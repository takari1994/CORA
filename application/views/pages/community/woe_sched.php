<ul class="nav nav-tabs">
    <li><a href="community/player_ladder">Player Ladder</a></li>
    <li><a href="community/guild_ladder">Guild Ladder</a></li>
    <li><a href="community/castle_status">Castle Status</a></li>
    <li class="active"><a href="community/woe_schedule">WoE Schedule</a></li>
</ul>
<?php

$active = "WoE Schedule";
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
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Day</th>
                        <th>Time</th>
                        <th>Castles</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Sunday -->
                    <?php if(0 <count($sun)): for($x=0;$x<count($sun);$x++): ?>
                    <tr>
                        <?php if($x==0): ?>
                        <td style="vertical-align: top !important;"<?php echo (1<count($sun)?' rowspan='.count($sun):''); ?>>Sunday</td>
                        <?php endif; ?>
                        <td style="vertical-align: top !important;">
                        <?php echo date("h:i a", strtotime((string)$sun[$x]['start'].':00')).' - '.date("h:i a", strtotime((string)$sun[$x]['end'].':00')); ?>
                        </td>
                        <td style="vertical-align: top !important;">
                        <?php
                        $castles = mask2castles($sun[$x]['mask']);
                        foreach($castles as $c){ echo $c.'<br />'; }
                        ?>
                        </td>
                    </tr>
                    <?php endfor; else: ?>
                    <tr>
                        <td>Sunday</td>
                        <td style="font-style:italic;color: #ccc;">No schedule</td>
                        <td style="font-style:italic;color: #ccc;">No schedule</td>
                    </tr>
                    <?php endif; ?>
                    <!-- Monday -->
                    <?php if(0 <count($mon)): for($x=0;$x<count($mon);$x++): ?>
                    <tr>
                        <?php if($x==0): ?>
                        <td style="vertical-align: top !important;"<?php echo (1<count($mon)?' rowspan='.count($mon):''); ?>>Monday</td>
                        <?php endif; ?>
                        <td style="vertical-align: top !important;">
                        <?php echo date("h:i a", strtotime((string)$mon[$x]['start'].':00')).' - '.date("h:i a", strtotime((string)$mon[$x]['end'].':00')); ?>
                        </td>
                        <td style="vertical-align: top !important;">
                        <?php
                        $castles = mask2castles($mon[$x]['mask']);
                        foreach($castles as $c){ echo $c.'<br />'; }
                        ?>
                        </td>
                    </tr>
                    <?php endfor; else: ?>
                    <tr>
                        <td>Monday</td>
                        <td style="font-style:italic;color: #ccc;">No schedule</td>
                        <td style="font-style:italic;color: #ccc;">No schedule</td>
                    </tr>
                    <?php endif; ?>
                    <!-- Tuesday -->
                    <?php if(0 <count($tue)): for($x=0;$x<count($tue);$x++): ?>
                    <tr>
                        <?php if($x==0): ?>
                        <td style="vertical-align: top !important;"<?php echo (1<count($tue)?' rowspan='.count($tue):''); ?>>Tuesday</td>
                        <?php endif; ?>
                        <td style="vertical-align: top !important;">
                        <?php echo date("h:i a", strtotime((string)$tue[$x]['start'].':00')).' - '.date("h:i a", strtotime((string)$tue[$x]['end'].':00')); ?>
                        </td>
                        <td style="vertical-align: top !important;">
                        <?php
                        $castles = mask2castles($tue[$x]['mask']);
                        foreach($castles as $c){ echo $c.'<br />'; }
                        ?>
                        </td>
                    </tr>
                    <?php endfor; else: ?>
                    <tr>
                        <td>Tuesday</td>
                        <td style="font-style:italic;color: #ccc;">No schedule</td>
                        <td style="font-style:italic;color: #ccc;">No schedule</td>
                    </tr>
                    <?php endif; ?>
                    <!-- Wednesday -->
                    <?php if(0 <count($wed)): for($x=0;$x<count($wed);$x++): ?>
                    <tr>
                        <?php if($x==0): ?>
                        <td style="vertical-align: top !important;"<?php echo (1<count($wed)?' rowspan='.count($wed):''); ?>>Wednesday</td>
                        <?php endif; ?>
                        <td style="vertical-align: top !important;">
                        <?php echo date("h:i a", strtotime((string)$wed[$x]['start'].':00')).' - '.date("h:i a", strtotime((string)$wed[$x]['end'].':00')); ?>
                        </td>
                        <td style="vertical-align: top !important;">
                        <?php
                        $castles = mask2castles($wed[$x]['mask']);
                        foreach($castles as $c){ echo $c.'<br />'; }
                        ?>
                        </td>
                    </tr>
                    <?php endfor; else: ?>
                    <tr>
                        <td>Wednesday</td>
                        <td style="font-style:italic;color: #ccc;">No schedule</td>
                        <td style="font-style:italic;color: #ccc;">No schedule</td>
                    </tr>
                    <?php endif; ?>
                    <!-- Thursday -->
                    <?php if(0 <count($thu)): for($x=0;$x<count($thu);$x++): ?>
                    <tr>
                        <?php if($x==0): ?>
                        <td style="vertical-align: top !important;"<?php echo (1<count($thu)?' rowspan='.count($thu):''); ?>>Thursday</td>
                        <?php endif; ?>
                        <td style="vertical-align: top !important;">
                        <?php echo date("h:i a", strtotime((string)$thu[$x]['start'].':00')).' - '.date("h:i a", strtotime((string)$thu[$x]['end'].':00')); ?>
                        </td>
                        <td style="vertical-align: top !important;">
                        <?php
                        $castles = mask2castles($thu[$x]['mask']);
                        foreach($castles as $c){ echo $c.'<br />'; }
                        ?>
                        </td>
                    </tr>
                    <?php endfor; else: ?>
                    <tr>
                        <td>Thursday</td>
                        <td style="font-style:italic;color: #ccc;">No schedule</td>
                        <td style="font-style:italic;color: #ccc;">No schedule</td>
                    </tr>
                    <?php endif; ?>
                    <!-- Friday -->
                    <?php if(0 <count($fri)): for($x=0;$x<count($fri);$x++): ?>
                    <tr>
                        <?php if($x==0): ?>
                        <td style="vertical-align: top !important;"<?php echo (1<count($fri)?' rowspan='.count($fri):''); ?>>Friday</td>
                        <?php endif; ?>
                        <td style="vertical-align: top !important;">
                        <?php echo date("h:i a", strtotime((string)$fri[$x]['start'].':00')).' - '.date("h:i a", strtotime((string)$fri[$x]['end'].':00')); ?>
                        </td>
                        <td style="vertical-align: top !important;">
                        <?php
                        $castles = mask2castles($fri[$x]['mask']);
                        foreach($castles as $c){ echo $c.'<br />'; }
                        ?>
                        </td>
                    </tr>
                    <?php endfor; else: ?>
                    <tr>
                        <td>Friday</td>
                        <td style="font-style:italic;color: #ccc;">No schedule</td>
                        <td style="font-style:italic;color: #ccc;">No schedule</td>
                    </tr>
                    <?php endif; ?>
                    <!-- Saturday -->
                    <?php if(0 <count($sat)): for($x=0;$x<count($sat);$x++): ?>
                    <tr>
                        <?php if($x==0): ?>
                        <td style="vertical-align: top !important;"<?php echo (1<count($sat)?' rowspan='.count($sat):''); ?>>Saturday</td>
                        <?php endif; ?>
                        <td style="vertical-align: top !important;">
                        <?php echo date("h:i a", strtotime((string)$sat[$x]['start'].':00')).' - '.date("h:i a", strtotime((string)$sat[$x]['end'].':00')); ?>
                        </td>
                        <td style="vertical-align: top !important;">
                        <?php
                        $castles = mask2castles($sat[$x]['mask']);
                        foreach($castles as $c){ echo $c.'<br />'; }
                        ?>
                        </td>
                    </tr>
                    <?php endfor; else: ?>
                    <tr>
                        <td>Saturday</td>
                        <td style="font-style:italic;color: #ccc;">No schedule</td>
                        <td style="font-style:italic;color: #ccc;">No schedule</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>