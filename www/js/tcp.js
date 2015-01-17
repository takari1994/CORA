$('.no-redirect').click(function(e) {e.preventDefault();})
    
$('#check-all').change(function() {
    if (this.checked) {
        $('[name="ids[]"]').prop('checked', true);
    } else {
        $('[name="ids[]"]').prop('checked', false);
    }
});

$('.check-action').click(function() {
    var id = $(this).attr("id");
    switch(id) {
        case 'del-submit':
            var conf = confirm('Are you sure you want to delete all selected?');
            if(conf) {
                var form_action = $(this).attr('data-form-action');
                $('#list-form').attr('action',form_action);
            } else {
                exit();
            }
            break;
        case 'ban-submit':
            var action = $(this).attr('data-form-action');
            $('#list-form').attr('action',action);
            $('#action').val('ban');
            break;
        case 'unban-submit':
            var action = $(this).attr('data-form-action');
            $('#list-form').attr('action',action);
            $('#action').val('unban');
            break;
    }
    $('#list-form').submit();
});
    
function deleteObject(object,id) {
    var conf = window.confirm("Are you sure you want to delete this?");
    
    if (conf) {
        switch(object) {
            case 'post':
                document.location = 'post/delete?ids%5B%5D='+id; break;
            case 'page':
                document.location = 'page/delete?ids%5B%5D='+id; break;
            case 'nav':
                document.location = 'navigation/delete?ids%5B%5D='+id; break;
            case 'user':
                document.location = 'account/delete?mode=user&ids%5B%5D='+id; break;
            case 'char':
                document.location = 'account/delete?mode=char&ids%5B%5D='+id; break;
            case 'ipban':
                document.location = 'account/delete?mode=ipban&ids%5B%5D='+id; break;
            case 'v4p':
                document.location = 'v4p/delete?ids%5B%5D='+id; break;
            case 'donate':
                document.location = 'donate/delete?ids%5B%5D='+id; break;
            case 'shop-item':
                document.location = 'shop/delete?ids%5B%5D='+id; break;
            case 'cart-item':
                document.location = 'shop/del_cart_item?ids%5B%5D='+id;
        }
    }
}

function selectText(element) {
    var doc = document
        , text = doc.getElementById(element)
        , range, selection
    ;    
    if (doc.body.createTextRange) {
        range = document.body.createTextRange();
        range.moveToElementText(text);
        range.select();
    } else if (window.getSelection) {
        selection = window.getSelection();        
        range = document.createRange();
        range.selectNodeContents(text);
        selection.removeAllRanges();
        selection.addRange(range);
    }
}

// ----------------------------- Cash shop javascript -----------------------------
// --------------------------------------------------------------------------------
$('.shop-action-btn').click(function() {
    var itemQtySubmitVal;
    var action   = $(this).attr("data-action");
    var itemid   = $(this).attr("data-itemid");
    var itemname = $(this).attr("data-itemname");
    
    $('#myModalLabel').html(itemname);
    
    switch(action) {
        case 'buy':  itemQtySubmitVal = 'Buy Now'; break;
        case 'cart': itemQtySubmitVal = 'Add to Cart'; break;
        case 'gift': itemQtySubmitVal = 'Send Gift';
    }
    
    $('#itemID').val(itemid);
    $('#itemQtySubmit').val(itemQtySubmitVal);
});

$('#shopModalPopupForm').submit(function(e) {
    var action   = $('#itemQtySubmit').val();
    var itemid   = $('#itemID').val();
    var qtyInput = $('#itemQty').val();
    var qty;
    
    if (qtyInput > 0 && qtyInput != null) { qty = qtyInput } else { qty = 1; }
    
    switch(action) {
        case "Buy Now":
            $('#transactionType').val("buy");
            $('#shopModalPopupForm').attr("action","shop/checkout");
            break;
        case "Add to Cart":
            var postdata = $('#shopModalPopupForm').serialize();
            //$('#shopModalPopup').html('<div class="progress"><div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"><span>Loading...</span></div></div>');
            $('#shopModalPopupForm').hide();
            $('.shop-modal-progress').show();
            $.post('shop/add_cart_item', postdata, function(data) {
                if (data.success == '1') {
                    $('.cart-item-count-badge').html(data.cart_item_count);
                    $('#shopModal').modal('hide');
                    $('#itemQty').val('');
                    $('.shop-modal-progress').hide();
                    $('#shopModalPopupForm').show();
                } else {
                    $('#shopModalPopup').html('<div class="alert alert-danger">Oops! Something went wrong.</div>');
                }
            }, "json");
            e.preventDefault();
            break;
        case 'Send Gift':
            $('#transactionType').val("gift");
            $('#shopModalPopupForm').attr("action","shop/checkout");
    }
});

$('#formCatSelect').change(function() {
    var val = $(this).val();
    document.location = val;
});

$('#shopModal').modal({show: false});

$(window).load(function() {
    $('.item-box-desc').each(function(index) {
        var item_id = $(this).attr('data-id');
        $.post('ROChargen/itemdesc/'+item_id, function(data) {
            $('#item-box-desc-content-'+item_id).html(data);
        });
    });
});