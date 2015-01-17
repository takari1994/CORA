<?php

$active = "Items";
breadcrumb($crumbs,$active);

?>
<div class="container-fluid v4p-container">
    <div class="row">
        <div class="col-md-12">
            <form action="database" method="post" class="form-inline">
                <select class="form-control" name="tbl">
                    <option value="item" selected>Item</option>
                    <option value="mob">Monster</option>
                </select>
                <input type="text" class="form-control" name="query" required />
                <input type="submit" class="btn btn-primary" name="submit" value="Search" />
            </form>
            <div class="spacer"></div>
            <?php if(null != $items): foreach($items as $item): ?>
            <table class="table table-bordered">
                <tr>
                    <td colspan="4">
                        <img src="<?php echo base_url().'ROChargen/item/'.$item->id; ?>" />
                        <strong><?php echo $item->name_japanese; ?></strong>
                    </td>
                </tr>
                <tr>
                    <td style="width:25%; vertical-align: top !important;"><strong>Description</strong></td>
                    <td style="max-width: 1px;" colspan="3"><?php echo file_get_contents(base_url().'ROChargen/itemdesc/'.$item->id); ?></td>
                </tr>
                <tr>
                    <td style="width:25%"><strong>ID</strong></td>
                    <td style="width:25%"><?php echo $item->id; ?></td>
                    <td style="width:25%"><strong>Buy</strong></td>
                    <td style="width:25%"><?php echo ($item->price_buy ? $item->price_buy.' z':'<em>NULL</em>'); ?></td>
                </tr>
                <tr>
                    <td style="width:25%"><strong>Weight</strong></td>
                    <td style="width:25%"><?php echo $item->weight; ?></td>
                    <td style="width:25%"><strong>Sell</strong></td>
                    <td style="width:25%"><?php echo ($item->price_sell ? $item->price_sell.' z':'<em>NULL</em>'); ?></td>
                </tr>
            </table>
            <?php endforeach; else: ?>
            <em>No result found!</em>
            <?php endif; ?>
            <div class="spacer"></div>
            <?php
            
            if(null != $items) {
                $curpage = (isset($_GET['page'])?$_GET['page']:1);
                //Pagination
                pagination(current_url(),$tp,5,PAGINATION_LPP,$curpage,'left');
            }
            
            ?>
        </div>
    </div>
</div>