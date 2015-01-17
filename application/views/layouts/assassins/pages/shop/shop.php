<?php

$active = 'Cash Shop';
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
        <?php $this->load->view('pages/shop/categories',array('type'=>'select')); ?>
        <div class="spacer"></div>
    </div>
    <div class="col-md-12">
        <div class="row">
            <?php if(0 < count($items)): foreach($items as $item): ?>
            <div class="col-md-6">
                <div class="item-box">
                    <img src="ROChargen/itemcollection/<?php echo $item->item_id; ?>" class="item-box-img pull-left" />
                    <h5>
                        <?php echo $item->name_japanese; ?>
                    </h5>
                    <div class="item-box-desc custom-scroll" data-id="<?php echo $item->item_id; ?>">
                        <div id="item-box-desc-content-<?php echo $item->item_id; ?>"><img src="img/loading.gif" height="25" width="25" /></div>
                    </div>
                </div>
                <div class="currency-info-box">
                    <div class="action pull-right">
                        <div class="btn-group">
                            <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                              <span class="glyphicon glyphicon-align-justify"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                              <li><a href="#" class="no-redirect shop-action-btn" data-toggle="modal" data-target=".bs-example-modal-sm" data-action="buy" data-itemid="<?php echo $item->item_id; ?>" data-itemname="<?php echo $item->name_japanese; ?>">Buy Now</a></li>
                              <li><a href="#" class="no-redirect shop-action-btn" data-toggle="modal" data-target=".bs-example-modal-sm" data-action="cart" data-itemid="<?php echo $item->item_id; ?>" data-itemname="<?php echo $item->name_japanese; ?>">Add to Cart</a></li>
                              <li><a href="#" class="no-redirect shop-action-btn" data-toggle="modal" data-target=".bs-example-modal-sm" data-action="gift" data-itemid="<?php echo $item->item_id; ?>" data-itemname="<?php echo $item->name_japanese; ?>">Send as Gift</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="currency-info">
                        <strong>Price:</strong>
                        <?php
                        
                        if(0 < $item->price_donate)
                            echo $item->price_donate.' Credits';
                            
                        if(0 < $item->price_donate AND 0 < $item->price_vote)
                            echo ' / '.$item->price_vote.' VPoints';
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
</div>

