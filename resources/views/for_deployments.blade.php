@extends('layouts.header')
@section('content')

<div class="main-content">
  <section class="section">
    
    <div class="section-body">
       
        <div class="row">
            <div class="col-12 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="card-body card-type-3">
                            <div class="row">
                                <div class="col">
                                <h6 class="text-muted mb-0">For Deployments</h6>
                                <span class="font-weight-bold mb-0">{{count($for_deployments->where('status','For Deployment'))}}</span>
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
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="card">
                        <div class="card-body card-type-3">
                        <div class="row">
                            <div class="col">
                            <h6 class="text-muted mb-0">Deployed Requests</h6>
                            <span class="font-weight-bold mb-0">{{count($for_deployments->where('status','Deployed'))}}</span>
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
            </div>
           
            <div class="row">
            <div class="col-md-12 col-sm-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <h4>For Deployments </h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-hover " id="employees-table" style="width:100%;">
                          <thead>
                            <tr>
                                
                              <th>Action</th>
                              <th>Request Number</th>
                              <th>Requestor</th>
                              <th>Item Description</th>
                              <th>Request Qty</th>
                              <th>Remarks</th>
                              <th>Attachment</th>
                            </tr>
                          </thead>
                          <tbody>
                           @foreach($for_deployments->where('status','For Deployment') as $for_deployment)
                            <tr>
                                <td>
                                    <a title='Deployed Item' href="#" class="btn btn-icon btn-info" data-toggle="modal" data-target="#deploy_item" onclick="deploy_item({{$for_deployment->id}})"><i class="fas fa-paper-plane"></i></a>
                                 </td>
                                <td>TR-{{str_pad($for_deployment->employee_request->id, 4, '0', STR_PAD_LEFT)}}</td>
                                <td>{{$for_deployment->employee_request->user_info->name}}</td>
                                <td>
                                   {{$for_deployment->inventory->item_description}}
                                </td>
                                <td>
                                    <span class="badge @if($for_deployment->inventory->ending_balance >= $for_deployment->request_qty) badge-success @else badge-danger  @endif">{{$for_deployment->inventory->ending_balance}}</span>  -  {{$for_deployment->request_qty}} 
                                </td>
                                <td><small>{!! nl2br(e($for_deployment->employee_request->remarks)) !!}</small></td>
                                <td><a href='{{asset($for_deployment->employee_request->attachment)}}' target='_blank' >Attachment</a></td>
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
@include('deployed_item')
<script type="text/javascript">
    var inventories = {!! json_encode($inventories->toArray()) !!};
    var for_deployments = {!! json_encode(($for_deployments)->toArray()) !!};

    function deploy_item(id)
    {
        var data = for_deployments.find(item => item.id === id);
        document.getElementById("dep_id").value = id;
        document.getElementById("price").value = data.price;
        document.getElementById("customer_name").value = data.employee_request.customer_name;
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

