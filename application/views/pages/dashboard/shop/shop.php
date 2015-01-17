<ul class="nav nav-pills pull-right">
    <li class="active"><a href="dashboard/shop">Shop Items</a></li>
    <li><a href="dashboard/shop/add">New Item</a></li>
</ul>
<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
<div class="hr"></div>
<?php

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<div class="spacer"></div>
<div class="row">
    <div class="col-md-3">
        <?php $this->load->view('pages/shop/categories',array('type'=>'list')); ?>
    </div>
    <div class="col-md-9">
        <div class="row">
            <?php if(0 < count($items)): foreach($items as $item): ?>
            <div class="col-md-6">
                <div class="item-box">
                    <img src="ROChargen/itemcollection/<?php echo $item->item_id; ?>" class="item-box-img pull-left" />
                    <h5>
                        <?php echo $item->name_japanese; ?>
                        <div class="pull-right">
                            <a href="dashboard/shop/edit?id=<?php echo $item->item_id; ?>" class="anchor-btn"><span class="glyphicon glyphicon-pencil"></span></a>
                            <a href="#" class="anchor-btn no-redirect" onclick="deleteObject('shop-item',<?php echo $item->shop_id; ?>);"><span class="glyphicon glyphicon-trash"></span></a>
                        </div>
                    </h5>
                    <div class="item-box-desc custom-scroll" data-id="<?php echo $item->item_id; ?>">
                        <div id="item-box-desc-content-<?php echo $item->item_id; ?>"><img src="img/loading.gif" height="25" width="25" /></div>
                    </div>
                </div>
                <div class="currency-info-box">
                    <div class="action pull-right">
                        <button class="btn btn-xs btn-success shop-action-btn" data-toggle="modal" data-target=".bs-example-modal-sm" data-action="buy" data-itemid="<?php echo $item->item_id; ?>" data-itemname="<?php echo $item->name_japanese; ?>"><span class="glyphicon glyphicon-credit-card"></span></button>
                        <button class="btn btn-xs btn-success shop-action-btn" data-toggle="modal" data-target=".bs-example-modal-sm" data-action="cart" data-itemid="<?php echo $item->item_id; ?>" data-itemname="<?php echo $item->name_japanese; ?>"><span class="glyphicon glyphicon-shopping-cart"></span></button>
                        <button class="btn btn-xs btn-success shop-action-btn" data-toggle="modal" data-target=".bs-example-modal-sm" data-action="gift" data-itemid="<?php echo $item->item_id; ?>" data-itemname="<?php echo $item->name_japanese; ?>"><span class="glyphicon glyphicon-gift"></span></button>
                    </div>
                    <div class="currency-info">
                        <strong>Price:</strong>
                        <?php
                        
                        if(0 < $item->price_donate)
                            echo $item->price_donate.' credits';
                            
                        if(0 < $item->price_donate AND 0 < $item->price_vote)
                            echo ' / '.$item->price_vote.' VP';
                        else if(0 >= $item->price_donate AND 0 < $item->price_vote)
                            echo $item->price_vote.' VP';
                        ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php $this->load->view('pages/shop/shopmodal'); ?>
            <?php else: ?>
            <div class="col-md-12">
                <em>No result found!</em>
            </div>
            <?php endif; ?>
        </div>
        <?php
            
        if(null != $items) {
            $curpage = (isset($_GET['page'])?$_GET['page']:1);
            //Pagination
            pagination(current_url(),$tp,10,PAGINATION_LPP,$curpage,'center');
        }
        
        ?>
    </div>
</div>

