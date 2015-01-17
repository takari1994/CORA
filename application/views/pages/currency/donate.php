<?php

$active = "Donate";
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
            
            if($cur_settings[0]->status == 0):
            
            ?>
            <div class="alert alert-warning"><strong>Oops!</strong> The donation function is currently disabled.</div>
            <?php endif; ?>
            <p>Please enter the desired amount that you would want to donate:</p>
        </div>
    </div>
    <div class="spacer"></div>
    <div class="row">
        <div class="col-md-6">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Amount</th>
                        <th>Donate Points</th>
                    </tr>
                </thead>
                <tbody>
                <?php if(null != $donate_amounts): foreach($donate_amounts as $amount): ?>
                    <tr>
                        <td><?php echo $amount->amount; ?></td>
                        <td><?php echo $amount->value; ?></td>
                    </tr>
                <?php endforeach; else: ?>
                    <tr>
                        <td colspan="2"><em>No amount specified</em></td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
        <?php if(1 == $cur_settings[0]->status AND null != $cur_settings[0]->pp_merch_id AND null != $cur_settings[0]->pp_org_name AND null != $cur_settings[0]->pp_currency AND null != $cur_settings[0]->return_url AND null != $cur_settings[0]->cancel_url): ?>
        <div class="col-md-6">
            <form action="https://www.<?php echo $pp_domain; ?>.com/cgi-bin/webscr" method="post" target="_top" class="donate-box center">
                <div class="input-group">
                    <span class="input-group-addon"><?php echo $cur_settings[0]->pp_currency; ?></span>
                    <select class="form-control" name="amount">
                    <?php if(null != $donate_amounts): foreach($donate_amounts as $amount): ?>
                    <option value="<?php echo $amount->amount;?>"><?php echo $amount->amount; ?></option>
                    <?php endforeach; else: ?>
                    <option>No amount specified</option>
                    <?php endif; ?>
                    </select>
                </div>
                <div class="spacer"></div>
                <input type="hidden" name="cmd" value="_donations">
                <input type="hidden" name="custom" value="<?php echo $this->session->userdata('account_id'); ?>">
                <input type="hidden" name="business" value="<?php echo $cur_settings[0]->pp_merch_id; ?>">
                <input type="hidden" name="item_name" value="<?php echo $cur_settings[0]->pp_org_name; ?>">
                <input type="hidden" name="no_note" value="1">
                <input type="hidden" name="no_shipping" value="1">
                <input type="hidden" name="rm" value="1">
                <input type="hidden" name="return" value="<?php echo base_url().$cur_settings[0]->return_url; ?>">
                <input type="hidden" name="cancel_return" value="<?php echo base_url().$cur_settings[0]->cancel_url; ?>">
                <input type="hidden" name="currency_code" value="<?php echo $cur_settings[0]->pp_currency; ?>">
                <input type="hidden" name="bn" value="PP-DonationsBF:btn_donateCC_LG.gif:NonHosted">
                <input type="image" src="https://www.<?php echo $pp_domain; ?>.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                <img alt="" border="0" src="https://www.<?php echo $pp_domain; ?>.com/en_US/i/scr/pixel.gif" width="1" height="1">
            </form>
        </div>
        <?php endif; ?>
    </div>
</div>