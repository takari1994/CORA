<?php

$active = "Vote 4 Points";
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
            <?php if(null != $v4p_links): ?>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Site</th>
                        <th class="center">Points</th>
                        <th class="center">Next Vote Time</th>
                        <th class="center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($v4p_links as $link): ?>
                    <tr>
                        <td>
                            <strong><?php echo $link->label; ?></strong>
                        </td>
                        <td class="center"><?php echo $link->value; ?></td>
                        <td class="center">
                        <?php
                        
                        if(null != $this->session->userdata('account_id')) {
                            $link_avail = vote_avail_check($link->v4p_id,$this->session->userdata('account_id'),$link->cooldown);
                            if('-' != $link_avail['next_vote'])
                                echo unix_to_human((int)$link_avail['next_vote'], TRUE);
                            else
                                echo '-';
                        } else {
                            echo 'N/A';
                            $link_avail['is_avail'] = 1;
                        }
                        
                        ?>
                        </td>
                        <td class="center"><a target="_blank" href="<?php echo current_url().'/vote?id='.$link->v4p_id; ?>" class="btn btn-success v4p-btn<?php if(false == $link_avail['is_avail']){ echo ' disabled'; } ?>">VOTE NOW</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <div class="alert alert-danger">
                <strong>Error!</strong> no vote 4 points link found.
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('.v4p-btn').click(function() {
        $(this).addClass('disabled');    
    });
</script>