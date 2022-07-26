<?php

namespace App\Http\Controllers;
use App\Inventory;
use App\Delivery;
use App\DeliveryItem;
use App\DeliveryAttachment;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DeliveryController extends Controller
{
    //

    public function deliveries()
    {
        $inventories = Inventory::with('unit_of_measure_data')->get();
        $deliveries = Delivery::with('DeliveryItems.inventory.unit_of_measure_data')->get();

        return view('deliveries',array(
            'header' => "Deliveries",
            'inventories' => $inventories,
            'deliveries' => $deliveries

        ));
    }

    public function newStock (Request $request)
    {
        // dd($request->all());
        $delivery = new Delivery;
        $delivery->received_from = $request->vendor;
        $delivery->received_by = $request->employee_name;
        $delivery->reference_number = $request->reference_number;
        $delivery->date_received = $request->date_received;
        $delivery->remarks = $request->description;
        $delivery->encode_by = auth()->user()->id;
        $delivery->save();
        foreach($request->inventory as  $inventoryKey => $inventory)
        {
            $deliveryItem = new DeliveryItem;
            $deliveryItem->delivery_id = $delivery->id;
            $deliveryItem->inventory_id = $inventory;
            $deliveryItem->qty = $request->qty[$inventoryKey];
            $deliveryItem->price = $request->price_per_qty[$inventoryKey];
            $deliveryItem->total_price = $request->price_per_qty[$inventoryKey]*$request->qty[$inventoryKey];
            $deliveryItem->save();

            $inventory = Inventory::where('id',$inventory)->first();
            $inventory->ending_balance = $inventory->ending_balance + $request->qty[$inventoryKey];
            $inventory->save();
        }
        $files = $request->file('attachments');
        if($request->hasFile('attachments'))
        {
            foreach($files as $file)
            {
                // $attachment = $attachment->file('attachment');
                $original_name = $file->getClientOriginalName();
                $name = time().'_'.$file->getClientOriginalName();
                $file->move(public_path().'/attachments/', $name);
                $file_name = '/attachments/'.$name;
                $deliveryAttachment = new DeliveryAttachment;
                $deliveryAttachment->attachment_file = $file_name;
                $deliveryAttachment->file_name = $original_name;
                $deliveryAttachment->delivery_id = $delivery->id;
                $deliveryAttachment->save();

            }
        }

        Alert::success('Successfully Encoded')->persistent('Dismiss');
        return back();

    }
}
