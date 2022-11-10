<div class="modal fade" id="newRequests" tabindex="-1" role="dialog" aria-labelledby="request" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="request">New Request</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <div class="modal-body">
                <form method='post' action='new-requests' onsubmit='show();'  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <div class='row mb-4'>
                        <div class='col-sm-12'>
                           Approver : {{$approver->name}}
                        </div>
                    </div>
                    
                    <div id='dataAssets' class='items'>
                        <div class="row " id='item_1'>
                            <div class="col-md-4 ">
                                <label >Inventory</label>
                                <select class="form-control m-2 select2" onchange="get_inventory(this.value,1)" name='inventory[]' style='width:100%' required >
                                    <option></option>
                                    @foreach($inventories->where('ending_balance','>',0) as $inventory)
                                    <option value='{{$inventory->id}}'>{{$inventory->item_description}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 ">
                                <label >Available Qty</label>
                                
                                <input type="number" name='available_quantity[]' id='available_quantity_1' class="form-control " value="{{ old('available_quantity') }}"  readonly>
                            </div>
                            <div class="col-md-2 ">
                                <label >Request Qty</label>
                                <input type="number" name='request_quantity[]' oninvalid="this.setCustomValidity('Available Qty : '+this.max)"  oninput="this.setCustomValidity('')"  id='request_quantity_1' class="form-control " value="{{ old('request_quantity') }}" placeholder="" min='1' step="1" required>
                            </div>
                            <div class="col-md-3 ">
                                <label >Price</label>
                                <input type="number" name='price[]' class="form-control " value="{{ old('price') }}" placeholder="" min='.01' step=".01" >
                            </div>
                            <div class="col-md-1  ">
                                <label >&nbsp;</label>
                                <a href="#" onclick="add_inventory();" class="btn btn-info"><i class="fas fa-plus"></i></a>
                            </div>
                        </div>
                     </div>
                     <hr>
                    <div class="row mt-4">
                        <div class="col-md-8">
                            <label >Customer Name</label>
                            <input  name='customer_name' class="form-control" value="{{ old('customer_name') }}" placeholder="Customer Name" required>
                            <label >Remarks</label>
                            <textarea   style="height: 85px;"  id='remarks'   name='remarks' class="form-control"  placeholder="Remarks" required>{{ old('remarks') }}</textarea>
                            
                        </div>
                        <div class="col-md-4">
                            <label >Attachment <i>(optional)</i></label>
                            <input type="file" name='attachment'  class="form-control " multiple value="{{ old('attachment') }}"  >
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
<script>
function add_inventory()
    {
        var lastItemID = $('.items').children().last().attr('id');
        var last_id = lastItemID.split("_");
        finalLastId = parseInt(last_id[1]) + 1;
        // alert(finalLastId);
                                    
        var item = "<div class='row ' id='item_"+finalLastId+"'>";
            item+= "<div class='col-md-4 '>";
            item+= "<label >Inventory</label>";
            item+= "<select class='form-control m-2 select2' onchange='get_inventory(this.value,"+finalLastId+")'' name='inventory[]' style='width:100%' required >";
            item+= "<option></option>";
            item+= "@foreach($inventories->where('ending_balance','>',0) as $inventory)";
            item+= "<option value='{{$inventory->id}}'>{{$inventory->item_description}}</option>";
            item+= "@endforeach";
            item+= "</select>";
            item+= "</div>";
            item+= "<div class='col-md-2 '>";
            item+= "<label >Available Qty</label>";
            item+= "<input type='number' name='available_quantity[]' id='available_quantity_"+finalLastId+"' class='form-control ' value='{{ old('available_quantity') }}'  readonly>";
            item+= "</div>";
            item+= "<div class='col-md-2 '>";
            item+= "<label >Request Qty</label>";
            item+= "<input type='number' name='request_quantity[]' oninvalid='this.setCustomValidity(Available Qty : '+this.max)'  oninput='this.setCustomValidity()'  id='request_quantity_"+finalLastId+"' class='form-control ' value='{{ old('request_quantity') }}'' placeholder=''' min='1' step='1' required>";
            item+= "</div>";
            item+= "<div class='col-md-3 '>";
            item+= "<label >Price</label>";
            item+= "<input type='number' name='price[]' class='form-control ' placeholder='' min='.01' step='.01' >";
            item+= "</div>";
            item+= "<div class='col-md-1 '>";
            item+= "<label >&nbsp;</label>";
            item+= "<label onclick='remove_item("+finalLastId+")' class='btn btn-icon btn-danger'><i class='fas fa-times'></i></label>";
            item+= " </div>";
            item+= "</div>";
           
            $(".items").append(item);
            $(".select2").select2();
    }
    function remove_item(id)
    {
        $("#item_"+id).remove();
    }
</script>

