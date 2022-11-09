<div class="modal fade" id="deploy_item" tabindex="-1" role="dialog" aria-labelledby="deployedRequestData" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="deployedRequestData">Deployed Item</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form method='post' action='deployed-item' onsubmit='show();'  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    <div class="row mt-12">
                        <div class="col-md-12">
                            <label >Remarks</label>
                            <input type="hidden" name='dep_id' id='dep_id' class="form-control mb-2 mr-sm-2"  placeholder="department_data" required readonly>
                            <textarea   style="height: 85px;"  id='remarks' name='remarks'  name='remarks' class="form-control"  placeholder="Remarks" required>{{ old('remarks') }}</textarea>
                        </div>
                    </div>
                    <div class="row mt-12">
                        <div class="col-md-12">
                            <label >Price Per Qty</label>
                            <input id='price' type='number'  name='price' class="form-control" min='0.00' step=".01"  placeholder="Price Per Qty">
                        </div>
                    </div>
                    <div class="row mt-12">
                        <div class="col-md-12">
                            <label >Customer Name</label>
                            <input  name='customer_name' class="form-control" id='customer_name' placeholder="Customer Name" readonly required>
                        </div>
                    </div>
                    <div class="row mt-12">
                        <div class="col-md-12">
                            <label >Attachment</label>
                            <input id='attachment' name='attachment'  type='file' class="form-control"  placeholder="Attachment" required>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-sm-12'>
                            <button type="submit" class="btn btn-primary m-t-15 waves-effect float-right">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


