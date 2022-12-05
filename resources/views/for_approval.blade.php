@extends('layouts.header')
@section('content')

<div class="main-content">
  <section class="section">
    
    <div class="section-body">
       
        <div class="row">
            
            <div class="col-8 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header">
                      <h4>For Appoval </h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-hover " id="employees-table" style="width:100%;">
                          <thead>
                            <tr>
                              <th>Request Number</th>
                              <th>Requestor</th>
                              <th>Customer Name</th>
                              <th>Item Description - Request Qty</th>
                              <th>Remarks</th>
                              <th>Attachment</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                           @foreach($request_inventory->where('status','Pending') as $req)
                                <tr>
                                    <td>TR-{{str_pad($req->id, 4, '0', STR_PAD_LEFT)}}</td>
                                    <td>{{$req->user_info->name}}</td>
                                    <td>{{$req->customer_name}}</td>
                                    <td>
                                        @foreach($req->inventory as $info)
                                        {{$info->inventory->item_description}} - {{$info->request_qty}} <br>
                                        @endforeach
                                    </td>
                                    <td><small>{!! nl2br(e($req->remarks)) !!}</small></td>
                                    <td><a href='{{asset($req->attachment)}}' target='_blank' >Attachment</a></td>
                                    <td>
                                        <a title='View History' href="#" class="btn btn-icon btn-info" data-toggle="modal" data-target="#viewHistory" onclick="view_request({{$req->id}})"><i class="fas fa-info-circle"></i></a>
                                        <a title='Approved Request' href="#" class="btn btn-icon btn-success" data-toggle="modal" data-target="#approveRequest" onclick="approvedRequest({{$req->id}})"><i class="fas fa-check"></i></a>
                                        <a title='Cancel' href="#" class="btn btn-icon btn-danger" data-toggle="modal" data-target="#declineRequest" onclick="declined_request({{$req->id}})"><i class="fas fa-times"></i></a>
                                    </td>
                                </tr>
                           @endforeach
                          </tbody>
                        </table>
                      </div>
                    </div>
                </div>
            </div>
            <div class="col-4 col-md-4 col-lg-4">
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-body card-type-3">
                            <div class="row">
                                <div class="col">
                                <h6 class="text-muted mb-0">For Approval</h6>
                                <span class="font-weight-bold mb-0">{{count($request_inventory->where('status','Pending'))}}</span>
                                </div>
                                <div class="col-auto">
                                <div class="card-circle l-bg-cyan text-white">
                                    <i class="fa fa-sticky-note"></i>
                                </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-nowrap">as of this {{date('F Y')}}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-body card-type-3">
                        <div class="row">
                            <div class="col">
                            <h6 class="text-muted mb-0">Approved Requests</h6>
                            <span class="font-weight-bold mb-0">{{count($request_inventory->where('status','Approved'))}}</span>
                            </div>
                            <div class="col-auto">
                            <div class="card-circle l-bg-purple text-white">
                                <i class="fas fa-paper-plane"></i>
                            </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="text-nowrap">as of this {{date('F Y')}}</span>
                        </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-12 col-lg-12">
                    <div class="card">
                        <div class="card-body card-type-3">
                        <div class="row">
                            <div class="col">
                            <h6 class="text-muted mb-0">Declined Requests</h6>
                            <span class="font-weight-bold mb-0">{{count($request_inventory->where('status','Declined'))}}</span>
                            </div>
                            <div class="col-auto">
                            <div class="card-circle l-bg-orange-dark text-white">
                                <i class="far fa-window-close"></i>
                            </div>
                            </div>
                        </div>
                        <p class="mt-3 mb-0 text-muted text-sm">
                            <span class="text-nowrap">as of this {{date('F Y')}}</span>
                        </p>
                        </div>
                    </div>
                </div>
                </div>
           
          </div>
        </section>
      </div>
  </div>
@include('declined_request')
@include('approved_request')
@include('view_histories')
<script type="text/javascript">
    var inventories = {!! json_encode($inventories->toArray()) !!};
    var requests = {!! json_encode($request_inventory->toArray()) !!};
    function get_inventory(data,id_def)
    {
        
        var inventory_id = parseInt(data);
        var inventory = inventories.find(item => item.id === inventory_id);
        document.getElementById("available_quantity_"+id_def).value = inventory.ending_balance;
        document.getElementById("request_quantity_"+id_def).max = inventory.ending_balance;
    }
    function view_request(id_def)
    {
        
        var request_id = parseInt(id_def);
        var request_datas = requests.find(item => item.id === request_id);
        document.getElementById("approver").innerHTML = request_datas.approver.name;
        document.getElementById("name").innerHTML = request_datas.user_info.name;
        document.getElementById("department").innerHTML = request_datas.employee_info.department;
        document.getElementById("transaction_number").innerHTML = "TR-"+pad("0000",request_datas.id,true);;
        
        console.log(request_datas);
        var request_inventories = request_datas.inventory;
        var request_histories = request_datas.histories;
        $('.data_d').empty();
        $('.histories').empty();
        for (var i = 0; i < request_inventories.length; i++) {
            if(request_inventories[i].price == null)
            {
                var price = 0.00;
                    price = parseFloat(price).toFixed(2);
            }
            else
            {
                var price = parseFloat(request_inventories[i].price).toFixed(2);
            }
            var dataAssets = "<div class='row  border'>";
                dataAssets += "<div class='col-sm-4 border'>";    
                dataAssets += request_inventories[i].inventory.item_description;      
                dataAssets += "</div>";    
                dataAssets += "<div class='col-sm-4 border'>";    
                dataAssets += request_inventories[i].request_qty;    
                dataAssets += "</div>";    
                dataAssets += "<div class='col-sm-4 border'>";    
                dataAssets += price.toLocaleString();    
                dataAssets += "</div>";    
                dataAssets += "</div>";    
                $('.data_d').append(dataAssets);
        }
        for (var i = 0; i < request_histories.length; i++) {

            var dataAssets = "<div class='row  border'>";
                dataAssets += "<div class='col-sm-4 border'>";    
                dataAssets += request_histories[i].user_info.name;      
                dataAssets += "</div>";    
                dataAssets += "<div class='col-sm-4 border'>";    
                dataAssets += request_histories[i].action;    
                dataAssets += "</div>";    
                dataAssets += "<div class='col-sm-4 border'>";    
                dataAssets += request_histories[i].created_at;    
                dataAssets += "</div>";    
                dataAssets += "</div>";    
                $('.histories').append(dataAssets);
        }
    }

    function declined_request(id)
    {
        document.getElementById("cancel_id").value = id;
    }
    function approvedRequest(id)
    {
        document.getElementById("approved_id").value = id;
    }

    function pad(pad, str, padLeft) {
    if (typeof str === 'undefined') 
        return pad;
    if (padLeft) {
        return (pad + str).slice(-pad.length);
    } else {
        return (str + pad).substring(0, pad.length);
    }
    }
</script>
@endsection

