<ul class="nav nav-tabs">
    <li><a href="account/profile?id=<?php echo $profile[0]->account_id; ?>"><span class="glyphicon glyphicon-list-alt"></span> Profile</a></li>
    <li class="active"><a href="account/characters?id=<?php echo $profile[0]->account_id; ?>"><span class="glyphicon glyphicon-user"></span> Characters</a></li>
    <li><a href="account/logout"><span class="glyphicon glyphicon-log-out"></span> Logout</a></li>
</ul>
<?php

$active = 'Characters';
breadcrumb($crumbs,$active);

?>
<div class="container-fluid profile">
    <div class="row profile-header">
        <div class="col-md-12">
            <div class="img-container pull-left">
                <img alt="avatar" src="<?php if(false == file_exists(UPLOAD_AVATARS_PATH.$profile[0]->account_id.'.png')){ echo 'img/def_avatar.gif'; } else { echo UPLOAD_AVATARS_PATH.$profile[0]->account_id.'.png'; } ?>" />
            </div>
            <h1 class="post-title"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
        </div>
    </div>
    <div class="spacer"></div>
    <div class="row profile-body">
        <div class="col-md-12">
            <?php
                
            if(isset($_GET['msgcode'])) {
                echo '<div class="spacer"></div>';
                echo parse_msgcode($_GET['msgcode']);
            }
            
            ?>
        </div>
        <div class="col-md-12">
                <?php if(!isset($_GET['index'])): ?>
                <div class="tbl-container">
                <table class="table table-bordered char-list">
                    <tbody>
                    <tr>
                        <td colspan="2"><strong>Name</strong></td>
                        <td><strong>Slot</strong></td>
                        <td><strong>Class</strong></td>
                        <td><strong>Base Lvl</strong></td>
                        <td><strong>Job Lvl</strong></td>
                        <td><strong>Zeny</strong></td>
                        <td colspan="2"><strong>Guild</strong></td>
                    </tr>
                    <?php if(null == $chars): ?>
                    <tr>
                        <td>-</td>
                        <td><em>No character found</em></td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                    <?php else: $count=0; foreach($chars as $char): ?>
                    <tr>
                        <td class="char-head-container" style="background: url('ROChargen/characterhead/<?php echo $char->name; ?>'); background-position: -10px -25px;">&nbsp;</td>
                        <td><a href="<?php echo current_url().'?id='.$profile[0]->account_id.'&index='.$count; ?>" alt="view character"><?php echo $char->name; ?></a></td>
                        <td><?php echo $char->char_num; ?></td>
                        <td><?php echo class_name($char->class); ?></td>
                        <td><?php echo $char->base_level; ?></td>
                        <td><?php echo $char->job_level; ?></td>
                        <td><?php echo number_format($char->zeny,0,'.',','); ?></td>
                        <td class="center"><?php if(null != $char->emblem): ?><img src="community/guild_emblem/<?php echo $char->guild_id; ?>" alt="emblem" /><?php else: ?><em>-</em><?php endif; ?></td>
                        <td><?php if(null != $char->guild_name){ echo $char->guild_name; } else { echo '<em>None</em>'; } ?></td>
                    </tr>
                    <?php $count++; endforeach; endif; ?>
                    </tbody>
                </table>
                </div>
                <div class="spacer"></div>
                <p>&raquo; Click on the character name to view full details and available actions.</p>
                <?php else: $index = $_GET['index']; ?>
                <table class="table table-bordered char-list">
                    <tbody>
                        <tr>
                            <td colspan=5 class="name-container"><span class="inline"><strong>Character Name:</strong> <?php echo $chars[$index]->name; ?></span><?php if(null != $acc_set[0]->char_res_pos): ?><button class="btn btn-success pull-right" id="pos-res-btn" data-url="account/reset_position?id=<?php echo $chars[$index]->account_id; ?>&charid=<?php echo $chars[$index]->char_id; ?>&index=<?php echo $index; ?>">Reset Position</button><?php endif; ?></td>
                        </tr>
                        <tr>
                            <td rowspan=7 class="char-container" style="background: url('ROChargen/character/<?php echo $chars[$index]->name; ?>/0/0'); background-position: -50px -25px;">&nbsp;</td>
                            <td><strong>Location</strong></td>
                            <td colspan=3><?php echo $chars[$index]->last_map.','.$chars[$index]->last_x.','.$chars[$index]->last_y; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Char Slot</strong></td>
                            <td><?php echo $chars[$index]->char_num; ?></td>
                            <td><strong>Str</strong></td>
                            <td><?php echo $chars[$index]->str; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Class</strong></td>
                            <td><?php echo class_name($chars[$index]->class); ?></td>
                            <td><strong>Agi</strong></td>
                            <td><?php echo $chars[$index]->agi; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Base Level</strong></td>
                            <td><?php echo $chars[$index]->base_level; ?></td>
                            <td><strong>Vit</strong></td>
                            <td><?php echo $chars[$index]->vit; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Job Level</strong></td>
                            <td><?php echo $chars[$index]->job_level; ?></td>
                            <td><strong>Int</strong></td>
                            <td><?php echo $chars[$index]->int; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Zeny</strong></td>
                            <td><?php echo number_format($chars[$index]->zeny,0,'.',','); ?></td>
                            <td><strong>Dex</strong></td>
                            <td><?php echo $chars[$index]->dex; ?></td>
                        </tr>
                        <tr>
                            <td><strong>Guild</strong></td>
                            <td>
                                <?php if(null != $chars[$index]->emblem){ echo '<img src="community/guild_emblem/'.$chars[$index]->guild_id.'" alt="emblem" />&nbsp;'; } ?>
                                <?php if(null != $chars[$index]->guild_name){ echo $chars[$index]->guild_name; } else { echo '<em>None</em>'; } ?>
                            </td>
                            <td><strong>Luk</strong></td>
                            <td><?php echo $chars[$index]->luk; ?></td>
                        </tr>
                    </tbody>
                </table>
                <?php endif; ?>
        </div>
    </div>
</div>
<?php if(null != $acc_set[0]->char_res_pos): ?>
<script type="text/javascript">
    $('#pos-res-btn').click(function() {
        var url = $(this).attr("data-url");
        var conf = confirm("Are you sure you want to reset this character's position?");
        
        if (conf) {
            document.location = url;
        }
    });
</script>
<?php endif; ?>
<?php $this->load->view('assets/datepicker'); ?>
