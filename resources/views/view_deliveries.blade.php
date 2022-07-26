<div class="modal fade" id="viewDeliveries" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="formModal">Deliveries</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class='col-md-6'>
                        Received From : <span id="received_from_data"></span>
                    </div>
                    <div class='col-md-6'>
                        Received By : <span id="received_by_data"></span>
                    </div>
                </div>
                <div class="row">
                    <div class='col-md-6'>
                        Reference Number (DR/SI):  <span id="reference_number_data"></span>
                    </div>
                    <div class='col-md-6'>
                        Date Received : <span id="date_received_data"></span>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class='col-md-6'>
                        Remarks : <br> <span id='remarks_data'> </span>
                    </div>
                    <div class='col-md-6'>
                        Attachment/s : <br>
                    </div>
                </div>
                <div class="row">
                    <div class='col-md-12 border text-center'>
                       Items
                    </div>
                </div>
                <div class="row border text-center">
                    <div class='col-md-4 border'>
                       Description
                    </div>
                    <div class='col-md-1 border'>
                       UOM  
                    </div>
                    <div class='col-md-2 border'>
                       Qty
                    </div>
                    <div class='col-md-2 border'>
                       Price per Qty
                    </div>
                    <div class='col-md-3 border'>
                       Total Price
                    </div>
                </div>
                <div id='items_Config'>
                </div>
            </div>
        </div>
    </div>
</div>