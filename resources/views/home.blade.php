@extends('layouts.header')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-xl-3 col-lg-6">
                    <div class="card">
                        <div class="card-body card-type-3">
                        <div class="row">
                            <div class="col">
                            <h6 class="text-muted mb-0">New Requests</h6>
                            <span class="font-weight-bold mb-0">{{count($request_inventory->where('status','Pending')->where('date_created','date("y-m-d")'))}}</span>
                            </div>
                            <div class="col-auto">
                            <div class="card-circle l-bg-orange text-white">
                                <i class="fas fa-plus"></i>
                            </div>
                            </div>
                        </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-nowrap">as of {{date('F d, Y')}}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                    <div class="card">
                        <div class="card-body card-type-3">
                            <div class="row">
                                <div class="col">
                                <h6 class="text-muted mb-0">Pending Requests</h6>
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
                <div class="col-xl-3 col-lg-6">
                <div class="card">
                    <div class="card-body card-type-3">
                    <div class="row">
                        <div class="col">
                        <h6 class="text-muted mb-0">Need for delivery</h6>
                        <span class="font-weight-bold mb-0">{{count($inventories->where('ending_balance','<=',10))}}</span>
                        </div>
                        <div class="col-auto">
                        <div class="card-circle l-bg-green text-white">
                            <i class="fas fa-truck"></i>
                        </div>
                        </div>
                    </div>
                    <p class="mt-3 mb-0 text-muted text-sm">
                        <span class="text-nowrap">as of today {{date('F d Y')}}</span>
                    </p>
                    </div>
                </div>
                </div>
                <div class="col-xl-3 col-lg-6">
                <div class="card">
                    <div class="card-body card-type-3">
                    <div class="row">
                        <div class="col">
                        <h6 class="text-muted mb-0">For Deployment</h6>
                        <span class="font-weight-bold mb-0">{{count($for_deployment->where('status','For Deployment'))}}</span>
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
            <div class='row'>
                <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                </div>
                <div class="col-sm-12 col-md-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                          <h4>High Stock </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover employees-table"  style="width:100%;">
                              <thead class='border'>
                                <tr>
                                  <th>Item Description</th>
                                  <th>Unit of Measure</th>
                                  <th>Available Qty.</th>
                                </tr>
                              </thead>
                              <tbody class='border'>
                                @foreach($inventories->where('ending_balance','>',20) as $inventory)
                                 <tr>
                                    <td>{{$inventory->item_description}}</td>
                                    <td>{{$inventory->unit_of_measure_data->name_description}}</td>
                                    <td>{{$inventory->ending_balance}}</td>
                                 </tr>
                                 @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-4">
                    <div class="card">
                        <div class="card-header">
                          <h4>Low Stock </h4>
                        </div>
                        <div class="card-body">
                            <table class="table table-hover employees-table"  style="width:100%;">
                              <thead class='border'>
                                <tr>
                                  <th>Item Description</th>
                                  <th>Unit of Measure</th>
                                  <th>Available Qty.</th>
                                </tr>
                              </thead>
                              <tbody class='border'>
                                @foreach($inventories->where('ending_balance','<=',10) as $inventory)
                                 <tr>
                                    <td>{{$inventory->item_description}}</td>
                                    <td>{{$inventory->unit_of_measure_data->name_description}}</td>
                                    <td>{{$inventory->ending_balance}}</td>
                                 </tr>
                                 @endforeach
                              </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

@endsection
