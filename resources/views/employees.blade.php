@extends('layouts.header')
@section('content')

<div class="main-content">
  <section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                      <h4>Employees <a href="{{url('generate-employees')}}" class="btn btn-primary" onclick='show()' title='Generate Employee' > Generate/Sync</a></h4>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-hover " id="employees-table" style="width:100%;">
                          <thead>
                            <tr>
                              <th>Name</th>
                              <th>Emp Code</th>
                              <th>Department</th>
                              <th>Position</th>
                              <th>Emplooyee Type</th>
                              <th>Email</th>
                              <th>Status</th>
                              <th>Role</th>
                              <th>Action</th>
                            </tr>
                          </thead>
                          <tbody>
                            @foreach($employees as $employee)
                                <tr>
                                    <td>{{$employee->name}}</td>
                                    <td>{{$employee->emp_code}}</td>
                                    <td>{{$employee->department}}</td>
                                    <td>{{$employee->position}}</td>
                                    <td>{{$employee->emp_type}}</td>
                                    <td>{{$employee->user->email}}</td>
                                    <td>
                                      @if($employee->user->status == "Active")
                                      <small class="label label-primary">Active</small>
                                      @else
                                      <small class='label label-danger'>Inactive</small> 
                                      @endif
                                    </td>
                                    <td>{{$employee->user->role}}</td>
                                    <td>
                                      @if($employee->user->status == "Active")
                                      <a href="#" title='Change Role' class="btn btn-icon btn-info btn-sm" onclick='changerole({{$employee->id}})' data-toggle="modal" data-target="#changerole"><i class="fas fa-user-tag"></i></a>
                                      @endif
                                    </td>
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
@include('changeRole');
<script>
   var employeeInventories = {!! json_encode($employees->toArray()) !!};
   console.log(employeeInventories);
  function changerole(id)
    {
      var idSample = parseInt(id);

      var item = employeeInventories.find(item => item.id === idSample);
      document.getElementById("name").innerHTML = item.name;
      document.getElementById("employee_id").value = item.user.id;
      document.getElementById("role").value = item.user.role;
      
      
    }
</script>
@endsection

