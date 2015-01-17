<?php

$active = 'Checkout';
breadcrumb($crumbs,$active);

?>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <?php
            
            $data = array('donate_points'=>$donate_points,'vote_points'=>$vote_points);
            $this->load->view('pages/shop/currencyinfo',$data);
            
            ?>
            <h1 class="post-title"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
            <div class="spacer"></div>
            <?php
            
            if(isset($_GET['msgcode'])) {
                echo parse_msgcode($_GET['msgcode']);
            }
            
            ?>
        </div>
        <div class="col-md-12">
            <?php if(count($items) > 0): ?>
            <form class="form-horizontal" role="form" id="checkout-form" action="shop/process_payment" method="POST">
            <input type="hidden" name="tt" value="<?php echo $tt; ?>" />
            <div class="form-group">
              <label for="recipient" class="col-md-2 control-label left">Recipient</label>
              <div class="col-sm-4">
                <?php if("gift" != $tt): ?>
                <select class="form-control" id="recipient" name="recipient">
                <?php foreach($characters as $char) { echo '<option value="'.$char->name.'">'.$char->name.'</option>'; } ?>
                </select>
                <?php else: ?>
                <input type="text" class="form-control" id="recipient" name="recipient" required />
                <?php endif; ?>
              </div>
            </div>
            <?php if("gift" == $tt): ?>
            <div class="form-group">
              <label for="sender" class="col-md-2 control-label left">Sender</label>
              <div class="col-sm-4">
                <select class="form-control" id="sender" name="sender">
                <?php foreach($characters as $char) { echo '<option value="'.$char->name.'">'.$char->name.'</option>'; } ?>
                </select>
              </div>
            </div>
            <?php endif; ?>
            <div class="form-group">
              <label for="paymentMethod" class="col-md-2 control-label left">Payment via</label>
              <div class="col-sm-4">
                <div class="checkbox"><label><input type="radio" name="paymethod" id="paymentMethod" class="pay-method" value="dp" checked /> Credits</label></div>
                
                <div class="checkbox"><label><input type="radio" name="paymethod" class="pay-method" value="vp" /> Vote Points</label></div>
              </div>
            </div>
            <div class="spacer"></div>
            <span style="font-size: 12px;">Note: <em>Yellow rows means that the item is not available for the selected payment method.</em></span>
            <div class="spacer"></div>
            <div id="checkout-itemlist">
            <?php $this->load->view('pages/shop/itemlist',array('items'=>$items,'pm'=>'dp')); ?>
            </div>
            <div class="right">
                <button class="btn btn-primary" role="submit" name="checkout">Finish and Pay &raquo;</button>
            </div>
            </form>
            <?php endif; ?>
        </div>
    </div>
</div>
<script>
    $('.pay-method').change(function() {
        var postdata = $('#checkout-form').serialize();
        $('#checkout-itemlist').html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span>Loading...</span></div></div>');
        $.post('shop/switch_currency', postdata, function(data) {
            $('#checkout-itemlist').html(data);
        });
    });
</script>