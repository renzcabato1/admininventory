<?php

namespace App\Http\Controllers;
use App\Inventory;
use App\UnitOfMeasure;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class InventoryController extends Controller
{
    //
    public function inventories()
    {
        $inventories = Inventory::with('unit_of_measure_data')->get();
        $unitofmeasures = UnitOfMeasure::get();

        return view('inventories',array(
            'inventories' => $inventories,
            'unitofmeasures' => $unitofmeasures,
            'header' => "Inventories"
        ));

    }
    public function new_item(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'item_description' => 'unique:inventories|required',
            'measure' => 'required',
            // 'image' => 'required',
        ]);

        $item = new Inventory;
        $item->item_description = $request->item_description;
        $item->unit_of_measure = $request->measure;
        $item->ending_balance =  0;
        $item->save();

        Alert::success('Success created')->persistent('Dismiss');

        return back();

    }
}
