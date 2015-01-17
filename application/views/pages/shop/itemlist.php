<?php

$total_dp = 0;
$total_vp = 0;

?>
<table class="table table-striped">
    <thead>
        <tr>
            <th>Name</th>
            <th class="center">Quantity</th>
            <th class="right">Unit Price</th>
            <th class="right">Amount</th>
        </tr>
    </thead>
    <tbody id="checkout-itemlist-body">
        <?php foreach($items as $item): ?>
        <?php
        
        if('dp' == $pm) {
            if(0 < $item['price_dp'])
                echo '<tr>';
            else
                echo '<tr class="warning">';
        } else {
            if(0 < $item['price_vp'])
                echo '<tr>';
            else
                echo '<tr class="warning">';
        }
        
        ?>
            <td>
                <input type="hidden" name="item[]" value="<?php echo $item['item_id']; ?>" />
                <input type="hidden" name="qty[]" value="<?php echo $item['qty']; ?>" />
                <img src="http://localhost/tcp/www/ROChargen/item/<?php echo $item['item_id']; ?>" />&nbsp;<?php echo $item['name']; ?>
            </td>
            <td class="center">x<?php echo $item['qty']; ?></td>
            <td class="right">
            <?php
            
            if('dp' == $pm) {
                if(0 < $item['price_dp'])
                    echo $item['price_dp'].' Credits';
                else
                    echo $item['price_vp'].' VPoints';
            } else {
                if(0 < $item['price_vp'])
                    echo $item['price_vp'].' VPoints';
                else
                    echo $item['price_dp'].' Credits';
            }
            
            ?>
            </td>
            <td class="right">
            <?php
            
            if('dp' == $pm) {
                if(0 < $item['price_dp']) {
                    echo $item['price_dp']*$item['qty'].' Credits';
                    $total_dp += $item['price_dp']*$item['qty'];
                } else {
                    echo $item['price_vp']*$item['qty'].' VPoints';
                    $total_vp += $item['price_vp']*$item['qty'];
                }
            } else {
                if(0 < $item['price_vp']) {
                    echo $item['price_vp']*$item['qty'].' VPoints';
                    $total_vp += $item['price_vp']*$item['qty'];
                } else {
                    echo $item['price_dp']*$item['qty'].' Credits';
                    $total_dp += $item['price_dp']*$item['qty'];
                }
            }
            
            ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" class="right"><strong>TOTAL AMOUNT DUE</strong></td>
            <td class="right">
                <strong>
                <?php
                
                if(0 < $total_dp)
                    echo $total_dp.' Credits ';
                
                if(0 < $total_vp)
                    echo $total_vp.' VPoints';
                
                ?>
                </strong>
            </td>
        </tr>
    </tbody>
</table>