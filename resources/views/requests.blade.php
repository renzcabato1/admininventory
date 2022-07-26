@extends('layouts.header')
@section('content')

<div class="main-content">
  <section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-3 col-md-4 col-lg-4">
                <form method='post' action='new-requests' onsubmit='show();'  enctype="multipart/form-data">
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
                            <h4>New Request</h4>
                            </div>
                            <div class="card-body">
                                {{-- <label >Image</label>
                                <input type="file" class="form-control form-control mb-2 mr-sm-2" name='image' required> --}}
                                <div class="row">
                                    <div class="col-md-12">
                                        <label >Inventories</label>
                                        <select class="form-control select2" onchange="get_inventory(this.value)" name='inventory' style='width:100%' required >
                                            <option></option>
                                            @foreach($inventories->where('ending_balance','>',0) as $inventory)
                                            <option value='{{$inventory->id}}'>{{$inventory->item_description}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label >Available Quantity</label>
                                        <input type="number" name='available_quantity' id='available_quantity' class="form-control mb-2 mr-sm-2" value="{{ old('available_quantity') }}"  readonly>
                                    </div>
                                    <div class="col-md-6">
                                        <label >Unit of Measure</label>
                                        <input type="text" name='unit_of_measure' id='unit_of_measure' class="form-control mb-2 mr-sm-2" value="{{ old('unit_of_measure') }}" placeholder="" readonly>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label >Request Quantity</label>
                                        <input type="number" name='request_quantity' oninvalid="this.setCustomValidity('Available Qty : '+this.max)"  oninput="this.setCustomValidity('')"  id='request_quantity' class="form-control mb-2 mr-sm-2" value="{{ old('request_quantity') }}" placeholder="" min='1' step="1" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label >Remarks</label>
                                        <textarea   style="height: 85px;"  id='description' name='description'  name='remarks' class="form-control"  placeholder="Remarks" required>{{ old('remarks') }}</textarea>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class='col-sm-12'>
                                       Attachment  (<i><small>Optional</small></i> )
                                        <input type="file" class="form-control form-control mb-2 mr-sm-2" name='attachment' >
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-right">
                                <button class="btn btn-primary mr-1" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
            </div>
            <div class="col-12 col-md-8 col-lg-8">
                <div class="card">
                    <div class="card-header">
                      <h4>Request </h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-hover " id="employees-table" style="width:100%;">
                          <thead>
                            <tr>
                              <th>Item Description</th>
                              <th>Unit of Measure</th>
                              <th>Request Quantity</th>
                              <th>Remarks</th>
                              <th>Status</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                           
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

<script type="text/javascript">
    var inventories = {!! json_encode($inventories->toArray()) !!};
    function get_inventory(data)
    {
        
        var inventory_id = parseInt(data);
        var inventory = inventories.find(item => item.id === inventory_id);

        document.getElementById("unit_of_measure").value = inventory.unit_of_measure_data.name;
        document.getElementById("available_quantity").value = inventory.ending_balance;
        document.getElementById("request_quantity").max = inventory.ending_balance;
    }
</script>
@endsection

