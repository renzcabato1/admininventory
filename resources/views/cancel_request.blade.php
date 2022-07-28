<div class="modal fade" id="cancelRequest" tabindex="-1" role="dialog" aria-labelledby="cancelRequestData" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="cancelRequestData">Cancel Request</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form method='post' action='cancel-request' onsubmit='show();'  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    
                    <div class="row mt-12">
                        <div class="col-md-12">
                            <label >Remarks</label>
                            <input type="hidden" name='cancel_id' id='cancel_id' class="form-control mb-2 mr-sm-2"  placeholder="department_data" required readonly>
                            <textarea   style="height: 85px;"  id='remarks' name='remarks'  name='remarks' class="form-control"  placeholder="Remarks" required>{{ old('remarks') }}</textarea>
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


