<?php

namespace App\Http\Controllers;
use App\Inventory;
use App\UnitOfMeasure;
use Illuminate\Http\Request;

class RequestController extends Controller
{
    //
    public function requests (Request $request)
    {
        $inventories = Inventory::with('unit_of_measure_data')->get();
        return view('requests',array(
            'header' => "Requests",
            'inventories' => $inventories
        ));
    }
    public function newRequest(Request $request)
    {
        dd($request->all());
    }
}
