@extends('layouts.header')
@section('content')

<div class="main-content">
  <section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-6 col-md-6 col-lg-6">
                <form method='post' action='new-stock' onsubmit='show();'  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    @if(session()->has('status'))
                        <div class="alert alert-success alert-dismissable">
                            {{-- <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button> --}}
                            {{session()->get('status')}}
                        </div>
                    @endif
                    @include('error')
                        <div class="card">
                            <div class="card-header">
                            <h4>New Stocks</h4>
                            </div>
                            <div class="card-body">
                                {{-- <label >Image</label>
                                <input type="file" class="form-control form-control mb-2 mr-sm-2" name='image' required> --}}
                                <h4><strong>Information</strong></h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label >Received from</label>
                                       <input class='form-control' name='vendor' placeholder="Company / Vendor" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label >Received By</label>
                                       <input class='form-control' name='employee_name' placeholder="Employee Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label >Reference Number (DR/SI) :</label>
                                       <input class='form-control' name='reference_number' required>
                                    </div>
                                    <div class="col-md-6">
                                        <label >Date Received :</label>
                                       <input type='date' class='form-control' name='date_received' max='{{date('Y-m-d')}}' required>
                                    </div>
                                    <div class="col-md-12">
                                        <label >Remarks</label>
                                        <textarea   style="height: 85px;"  id='description' name='description'  name='remarks' class="form-control"  placeholder="Remarks" required>{{ old('remarks') }}</textarea>
                                    </div>
                                </div>
                                <hr>
                                <h4><strong>Items <a href="#" onclick="add_item();" class="btn btn-info"><i class="fas fa-plus"></i></a></strong></h4>
                                <div class='items-d'>
                                    <div class="row" id='item_1'>
                                        <div class="col-md-4">
                                            <label >Inventory</label>
                                            <select class="form-control select2" name='inventory[]' style='width:100%' required >
                                                <option></option>
                                                @foreach($inventories as $inventory)
                                                <option value='{{$inventory->id}}'>{{$inventory->item_description}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-md-2">
                                            <label >Qty</label>
                                            <input type="number" name='qty[]' class="form-control" placeholder="" min="1" step="1" required>
                                        </div>
                                        <div class="col-md-5">
                                            <label >Price per Qty</label>
                                            <input type="number" name='price_per_qty[]' class="form-control" placeholder="" min='0.00' step=".01" required>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <h4><strong>Attachment</strong></h4>
                                <div class='row'>
                                    <div class='col-sm-12'>
                                       Attachment (<i><small>optional</small></i>)
                                        <input type="file" class="form-control form-control mb-2 mr-sm-2" name='attachments[]' multiple >
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary mr-1" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
            </div>
            <div class="col-6 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                      <h4>Deliveries </h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-hover " id="employees-table" style="width:100%;">
                          <thead>
                            <tr>
                              <th>Received From</th>
                              <th>Received By</th>
                              <th>Reference Number</th>
                              <th>Date Received</th>
                              <th>Remarks</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($deliveries as $delivery)
                            <tr class="pe auto" data-toggle="modal" data-target="#viewDeliveries" href="#" onclick='delivery_details({{$delivery}});' >
                                <td>{{$delivery->received_from}}</td>
                                <td>{{$delivery->received_by}}</td>
                                <td>{{$delivery->reference_number}}</td>
                                <td>{{date('M d, Y',strtotime($delivery->date_received))}}</td>
                                <td><small>{!! nl2br(e($delivery->reference_number)) !!}</small></td>
                                {{-- <td></td> --}}
                              </tr>
                            @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
            </div>
          </div>
        </section>
      </div>
  </div>
  @include('view_deliveries');
  <script>
    function add_item()
    {
        var lastItemID = $('.items-d').children().last().attr('id');
        var last_id = lastItemID.split("_");
        finalLastId = parseInt(last_id[1]) + 1;
        // alert(finalLastId);
                                    
        var item = "<div class='row' id='item_"+finalLastId+"'>";
            item+= "<div class='col-md-4'>";
            item+= "<label >Inventory</label>";
            item+= "<select class='form-control select2' name='inventory[]' style='width:100%' required >";
            item+= "<option></option>";
            item+= "@foreach($inventories as $inventory)";
            item+= "<option value='{{$inventory->id}}'>{{$inventory->item_description}}</option>";
            item+= "@endforeach";
            item+= "</select>";
            item+= "</div>";
            item+= "<div class='col-md-2'>";
            item+= "<label >Qty</label>";
            item+= "<input type='number' name='qty[]' class='form-control' placeholder='' step='1' min=1 required>";
            item+= "</div>";
            item+= "<div class='col-md-5'>";
            item+= "<label >Price per Qty</label>";
            item+= "<input type='number' name='price_per_qty[]' class='form-control' placeholder='' min='0.00' step='.01' required>";
            item+= " </div>";
            item+= "<div class='col-md-1'>";
            item+= "<label >&nbsp;</label>";
            item+= "<label onclick='remove_item("+finalLastId+")' class='btn btn-icon btn-danger'><i class='fas fa-times'></i></label>";
            item+= " </div>";
            item+= "</div>";
           
            $(".items-d").append(item);
            $(".select2").select2();
    }
    function remove_item(id)
    {
        $("#item_"+id).remove();
    }
    function delivery_details(id)
    {
        var items = id.delivery_items;
        var options = {  year: 'numeric', month: 'long', day: 'numeric' };
        var date_received  = new Date(id.date_received);
        document.getElementById('received_from_data').innerHTML = id.received_from;
        document.getElementById('reference_number_data').innerHTML = id.reference_number;
        document.getElementById('received_by_data').innerHTML = id.received_by;
        document.getElementById('date_received_data').innerHTML = date_received.toLocaleDateString("en-US", options);
        document.getElementById('remarks_data').innerHTML = id.remarks;

        document.querySelectorAll('.items').forEach(e => e.remove());

        var sum = 0;

        for(var i = 0;i < items.length;i++)
        {
            sum = sum + items[i].total_price;
            
            
            var itemDescription = "<div class='row border text-center items'>";
                itemDescription += "<div class='col-md-4 border'>";
                itemDescription += items[i].inventory.item_description;
                itemDescription += "</div>";
                itemDescription += "<div class='col-md-1 border'>";
                itemDescription += items[i].inventory.unit_of_measure_data.name;
                itemDescription += "</div>";
                itemDescription += "<div class='col-md-2 border'>";
                itemDescription += items[i].qty;
                itemDescription += "</div>";
                itemDescription += "<div class='col-md-2 border'>";
                itemDescription += items[i].price;
                itemDescription += "</div>";
                itemDescription += "<div class='col-md-3 border text-right'>";
                itemDescription += Number(items[i].total_price).toLocaleString('en');
                itemDescription += " </div>";
                itemDescription += " </div>";
                var items_Config = document.getElementById('items_Config');
                items_Config.insertAdjacentHTML('beforeend',itemDescription);
            //    console.log(sum);
               
        }

               var itemfooter = "<div class='row border text-center items'>";
                itemfooter += "<div class='col-md-9 border'>";
                    itemfooter += "</div>";
                    itemfooter += "<div class='col-md-3 border text-right'>";
                        itemfooter += Number(sum).toLocaleString('en');
                        itemfooter += " </div>";
                        itemfooter += " </div>";

        var items_Config = document.getElementById('items_Config');
        items_Config.insertAdjacentHTML('beforeend',itemfooter);



    }
  </script>
@endsection

