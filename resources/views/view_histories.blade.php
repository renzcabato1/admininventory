<div class="modal fade" id="viewHistory" tabindex="-1" role="dialog" aria-labelledby="viewHistoryData" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="viewHistoryData">View Request</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                    <div class="row mt-12">
                        <div class="col-md-12">
                            <div class='row mb-4'>
                                <div class='col-sm-12'>
                                   Approver : <span id='approver'></span>
                                </div>
                            </div>
                            <div class='row mb-4'>
                                <div class='col-sm-12'>
                                   Transaction Number : <span id='transaction_number'></span>
                                </div>
                            </div>
                            <div class='row mb-4'>
                                <div class='col-sm-6'>
                                   Name : <span id='name'></span>
                                </div>
                                <div class='col-sm-6'>
                                   Department : <span id='department'></span>
                                </div>
                            </div>
                            <hr>
                            <div class='row border'>
                                <div class='col-sm-12  border text-center'>
                                    <h2 class=' mt-2'>Inventories </h2>
                                </div>
                            </div>
                                <div class='row border'>
                                    <div class='col-sm-6 border'>
                                    Inventory 
                                    </div>
                                    <div class='col-sm-6 border'>
                                    Request Qty 
                                    </div>
                                </div>
                                <div class='data_d'>
                                </div>

                                <hr>

                                <div class='row border'>
                                    <div class='col-sm-12  border text-center'>
                                        <h2 class=' mt-2'>Histories </h2>
                                    </div>
                                </div>
                                <div class='row border'>
                                    <div class='col-sm-3 border text-center'>
                                        Name 
                                    </div>
                                    <div class='col-sm-3 border text-center'>
                                        Remarks 
                                    </div>
                                    <div class='col-sm-3 border text-center'>
                                        Action 
                                    </div>
                                    <div class='col-sm-3 border text-center'>
                                        Date 
                                    </div>
                                </div>

                                <div class='histories'>
                                </div>
                       </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>

function nl2br (str, is_xhtml) {
    if (typeof str === 'undefined' || str === null) {
        return '';
    }
    var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
    return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
}
</script>

