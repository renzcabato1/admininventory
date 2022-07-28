<?php

namespace App\Http\Controllers;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use App\Inventory;
use App\RequestInventory;
use App\EmployeeRequest;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //   Alert::success('Success Login', 'Welcome to Asset Inventory Management System '.auth()->user()->name)->persistent('Dismiss');
        $request_inventory = EmployeeRequest::get();
        $for_deployment = RequestInventory::whereHas('employee_request',function ( $query) {
            $query->where('status', 'Approved');
        })->get();
        $inventories = Inventory::with('unit_of_measure_data')->orderBy('ending_balance','desc')->get();
        return view('home',
        array(
            'header' => 'Dashboard',
            'inventories' => $inventories,
            'request_inventory' => $request_inventory,
            'for_deployment' => $for_deployment
        )
    );
    }
}
