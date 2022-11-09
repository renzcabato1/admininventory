<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->
<head>
  <meta charset="UTF-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title>{{ config('app.name', 'Laravel') }}</title>
  <!-- General CSS Files -->
  <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
  <link rel="shortcut icon" href="{{asset('images/icon.png')}}">
  <!-- Template CSS -->
  
  <link rel="stylesheet" href="{{asset('assets/bundles/select2/dist/css/select2.min.css')}}"> 
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
  <!-- Custom style CSS -->
  <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
  
  <style>
    .zoom:hover {
      transform: scale(1.5); /* (150% zoom - Note: if the zoom is too large, it will go outside of the viewport) */
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    .pointer {cursor: pointer;}
    
    /* Firefox */
    input[type=number] {
        -moz-appearance:textfield;
    }
    .loader {
        position: fixed;
        left: 0px;
        top: 0px;
        width: 100%;
        height: 100%;
        z-index: 9999;
        background: url("{{ asset('/images/3.gif')}}") 50% 50% no-repeat rgb(249,249,249) ;
        opacity: .8;
        background-size:120px 120px;
    }
    @media (min-width: 768px) {
        .modal-xl {
            width: 100%;
            max-width:1700px;
        }
    }
    #employees-table_filter
    {
      text-align: right;
    }
    #employees-table_filter label
    {
      text-align: left;
    }
    #transaction-table_filter
    {
      text-align: right;
    }
    #transaction-table_filter label
    {
      text-align: left;
    }
    #accountability-table_filter
    {
      text-align: right;
    }
    #accountability-table_filter label
    {
      text-align: left;
    }
    .dataTables_paginate
    {
      float: right !important;
    }

</style>
</head>

<body>
  <div id = "myDiv" class="loader"></div>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">
      <div class="navbar-bg"></div>
      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li>
                <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg collapse-btn"> <i data-feather="align-justify"></i></a>
            </li>
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
         
       
          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image" src="{{'images/no_image.png'}}" class="user-img-radious-style"> <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Hello {{auth()->user()->name}}</div>
              {{-- <a href="profile.html" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> Profile
              </a>  --}}
              <div class="dropdown-divider"></div>
              <a href="{{ route('logout') }}"  onclick="logout(); show();" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                Logout
              </a>
              <form id="logout-form"  action="{{ route('logout') }}"  method="POST" style="display: none;">
                {{ csrf_field() }}
            </form>
            </div>
          </li>
        </ul>
      </nav>
      <div class="main-sidebar sidebar-style-2">
        <aside id="sidebar-wrapper">
          <div class="sidebar-brand">
            <a href="{{url('/')}}"> <img alt="image" src="{{asset('images/icon.png')}}" class="header-logo" /> <span
                class="logo-name">IMS</span>
            </a>
          </div>
            <ul class="sidebar-menu">
              <li class="menu-header">Transactions</li>
              {{-- @if((auth()->user()->role == "Admin") || (auth()->user()->role == "Approver") ||) --}}
              <li class="dropdown  @if($header == "Dashboard") active @endif">
                <a href="{{ url('/') }}" class="nav-link" onclick='show();'><i data-feather="monitor"></i><span>Dashboard</span></a>
              </li>
              {{-- @endif --}}
              @if((auth()->user()->role == "User") ||(auth()->user()->role == "Admin"))
              <li class="dropdown  @if($header == "Requests") active @endif">
                <a href="{{ url('/requests') }}" class="nav-link" onclick='show();'><i data-feather="database"></i><span>Requests</span></a>
              </li> 
              @endif
              @if((auth()->user()->role == "Admin") || (auth()->user()->role == "Approver"))
              <li class="dropdown  @if($header == "Deliveries") active @endif">
                <a href="{{ url('/deliveries') }}" class="nav-link" onclick='show();'><i data-feather="truck"></i><span>Deliveries</span></a>
              </li>
              @endif
              @if(auth()->user()->role == "Approver")
              <li class="dropdown  @if($header == "For Approval") active @endif">
                <a href="{{ url('/for-approval') }}" class="nav-link" onclick='show();'><i data-feather="check-square"></i><span>For Approval</span></a>
              </li>
              @endif
              @if((auth()->user()->role == "Admin") || (auth()->user()->role == "Approver"))
              <li class="dropdown  @if($header == "For Deployments") active @endif">
                <a href="{{ url('/for-deployments') }}" class="nav-link" onclick='show();'><i data-feather="send"></i><span>For Deployment</span></a>
              </li>
              <li class="menu-header">Settings</li>
                <li class="dropdown @if($header == "Inventories") active @endif">
                    <a href="{{ url('/inventories') }}" class="nav-link" onclick='show();'><i data-feather="list"></i><span>Inventory</span></a>
                </li>
                <li class="dropdown @if($header == "Employees") active @endif">
                    <a href="{{ url('/employees') }}" class="nav-link" onclick='show();'><i data-feather="users"></i><span>Employees</span></a>
                </li>
                @endif
            </ul>
        </aside>
      </div>
      <!-- Main Content -->
          @yield('content')
         
    
    </div>
  </div>
  <script type="text/javascript">
    function show()
    {
        document.getElementById("myDiv").style.display="block";
    }
    function logout()
    {
        event.preventDefault();
        document.getElementById('logout-form').submit();
    }
    function inventory(data)
    {
        alert(data);
    }
</script>
  <!-- General JS Scripts -->
  <script src="{{ asset('assets/js/app.min.js') }}"></script>
  <!-- JS Libraies -->
  {{-- <script src="{{ asset('assets/bundles/apexcharts/apexcharts.min.js') }}"></script> --}}
  <!-- Page Specific JS File -->
  {{-- <script src="{{ asset('assets/js/page/index.js') }}"></script> --}}
  <!-- Template JS File -->
  <script src="{{ asset('assets/js/scripts.js') }}"></script>
  <!-- Custom JS File -->
  <script src="{{ asset('assets/js/custom.js') }}"></script>

  <script src="{{ asset('assets/bundles/select2/dist/js/select2.full.min.js') }}"></script>
  <script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
  <script src="{{ asset('assets/bundles/sweetalert/sweetalert.min.js') }}"></script>
  <script src="{{ asset('assets/js/page/sweetalert.js') }}"></script>
  <script src="{{ asset('assets/js/page/datatables.js') }}"></script>
  @include('sweetalert::alert')
</body>
</html>