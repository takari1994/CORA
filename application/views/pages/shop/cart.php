<?php

$active = 'My Cart';
breadcrumb($crumbs,$active);

?>
<div class="container-fluid">
<div class="row">
    <div class="col-md-12">
        <?php
        
        $data = array('cart_item_count'=>$cart_item_count,'donate_points'=>$donate_points,'vote_points'=>$vote_points);
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
        <form action="shop/checkout" method="GET">
        <input type="hidden" name="transaction_type" value="cart" />
        <table class="table table-striped cart-list">
            <thead>
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th class="center">Quantity</th>
                    <th class="right">Unit Price</th>
                    <th class="right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php if(null != $items): foreach($items as $item): ?>
                <tr>
                    <td class="center"><a href="#" class="no-redirect anchor-btn" onclick="deleteObject('cart-item',<?php echo $item['cart_id']; ?>);"><span class="glyphicon glyphicon-remove"></span></a></td>
                    <td>
                        <input type="hidden" name="item[]" value="<?php echo $item['item_id']; ?>" />
                        <input type="hidden" name="qty[]" value="<?php echo $item['qty']; ?>" />
                        <img src="ROChargen/item/<?php echo $item['item_id']; ?>" />
                        <?php echo $item['name']; ?>
                    </td>
                    <td class="center"><?php echo $item['qty']; ?>x</td>
                    <td class="right">
                        <?php
                        
                        if(0 < $item['price_dp'])
                            echo $item['price_dp'].' Credits';
                            
                        if(0 < $item['price_dp'] AND 0 < $item['price_vp'])
                            echo ' / '.$item['price_vp'].' VPoints';
                        else if(0 >= $item['price_dp'] AND 0 < $item['price_vp'])
                            echo $item['price_vp'].' VPoints';
                        ?>
                    </td>
                    <td class="right">
                        <?php
                        
                        if(0 < $item['price_dp'])
                            echo $item['price_dp']*$item['qty'].' Credits';
                            
                        if(0 < $item['price_dp'] AND 0 < $item['price_vp'])
                            echo ' / '.$item['price_vp']*$item['qty'].' VPoints';
                        else if(0 >= $item['price_dp'] AND 0 < $item['price_vp'])
                            echo $item['price_vp']*$item['qty'].' VPoints';
                        ?>
                    </td>
                </tr>    
                <?php endforeach; else: ?>
                <tr>
                    <td class="center">-</td>
                    <td colspan="4" class="center"><em>Your cart is empty!</em></td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="spacer"></div>
        <div class="right">
            <input type="submit" class="btn btn-primary" name="submit" value="Proceed to Checkout &raquo;"<?php if(null == $items){ echo " disabled"; } ?> />
        </div>
        </form>
    </div>
</div>
</div>