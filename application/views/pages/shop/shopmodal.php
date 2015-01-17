<div class="modal fade bs-example-modal-sm tcp-modal" id="shopModal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title" id="myModalLabel">Item Name</h4>
        </div>
        <div class="modal-body" id="shopModalPopup">
            <div class="shop-modal-progress">
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                        <span>Loading...</span>
                    </div>
                </div>
            </div>
            <form method="get" class="form-inline center" id="shopModalPopupForm">
                <input type="hidden" name="transaction_type" id="transactionType" />
                <input type="hidden" name="item[]" id="itemID" />
                <input type="text" class="form-control input-sm" name="qty[]" id="itemQty" placeholder="Enter Quantity" required />
                <input type="submit" class="btn btn-primary btn-sm" id="itemQtySubmit">
            </form>
        </div>
      </div>
    </div>
</div>