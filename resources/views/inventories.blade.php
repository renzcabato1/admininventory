@extends('layouts.header')
@section('content')

<div class="main-content">
  <section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-3 col-md-4 col-lg-4">
                <form method='post' action='new-item' onsubmit='show();'  enctype="multipart/form-data">
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
                            <h4>New Inventory</h4>
                            </div>
                            <div class="card-body">
                                {{-- <label >Image</label>
                                <input type="file" class="form-control form-control mb-2 mr-sm-2" name='image' required> --}}
                                <label >Item Description</label>
                                <input type="text" name='item_description' class="form-control mb-2 mr-sm-2" value="{{ old('item_description') }}" placeholder="Item Description" required>
                                <label >Unit of Measure</label>
                                <select class="form-control select2" name='measure' style='width:100%' required >
                                    <option></option>
                                    @foreach($unitofmeasures as $measure)
                                    <option value='{{$measure->id}}'>{{$measure->name}} - {{$measure->name_description}}</option>
                                    @endforeach
                                </select>
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
                      <h4>Inventories </h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-hover " id="employees-table" style="width:100%;">
                          <thead>
                            <tr>
                              <th>Item Description</th>
                              <th>Unit of Measure</th>
                              <th>Ending Blanace</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                              @foreach($inventories as $inventory)
                              <tr>
                                <td>{{$inventory->item_description}}</td>
                                <td>{{$inventory->unit_of_measure_data->name}}</td>
                                <td>{{$inventory->ending_balance}}</td>
                                <td></td>
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
@endsection

