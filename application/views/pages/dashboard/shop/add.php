<ul class="nav nav-pills pull-right">
    <li><a href="dashboard/shop">Shop Items</a></li>
    <li class="active"><a href="dashboard/shop/add">New Item</a></li>
</ul>
<h1 class="dash-title spacer"><?php $title = explode(' | ',$template['title']); echo $title[0]; ?></h1>
<div class="hr"></div>
<?php

if(isset($_GET['msgcode'])) {
    echo parse_msgcode($_GET['msgcode']);
}

?>
<div class="row">
    <div class="col-md-4">
        <div class="center">
            <img src="" class="shop-item-img" />
        </div>
        <div class="shop-item-name">
        </div>
        <div class="spacer"></div>
        <div class="shop-item-desc">
        </div>
    </div>
    <div class="col-md-8">
        <form action="shop/add" method="POST">
            <div class="form-group">
                <label>Item ID</label>
                <input type="text" class="form-control" name="id" id="item-id" value=0 required />
                <span class="help-block">ID of the item you wish to add to the cash shop.</span>
            </div>
            <div class="form-group">
                <label>Price (Donation Points)</label>
                <input type="text" class="form-control" name="price_donate" value=0 required />
                <span class="help-block">Use 0 to disable this payment via donation points. Specifying 0 for both DP and VP is <strong>not allowed</strong>.</span>
            </div>
            <div class="form-group">
                <label>Price (Vote Points)</label>
                <input type="text" class="form-control" name="price_vote" value=0 required />
                <span class="help-block">Use 0 to disable this payment via vote points. Specifying 0 for both DP and VP is <strong>not allowed</strong>.</span>
            </div>
            <div class="spacer-lg"></div>
            <div class="right">
                <input type="submit" class="btn btn-primary" name="submit" value="Add Item" />
                <a href="dashboard/shop" class="btn btn-default">Cancel</a>
            </div>
        </form>
    </div>
</div>
<script type="text/javascript">
    $('#item-id').change(function() {
        var val = $(this).val();
        if (val.length > 0) {
            $('.shop-item-img').attr('src','ROChargen/itemcollection/'+val);
            $.post('ROChargen/itemdesc/'+val, function(data) {
                $('.shop-item-desc').html('<strong>Description</strong><br />'+data);
            });
            $.post('database/get_item_info/'+val, {func: "getItemInfo"}, function(data) {
                $('.shop-item-name').html('<strong>Item Name</strong><br />'+data.name_japanese);    
            },"json");
        } else {
            $('.shop-item-img').attr('src','');
        }
    });
</script>