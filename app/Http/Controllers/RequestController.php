<?php

namespace App\Http\Controllers;
use App\Inventory;
use App\UnitOfMeasure;
use App\User;
use App\RequestInventory;
use App\EmployeeRequest;
use App\RequestHistory;
use Illuminate\Http\Request;
use App\Notifications\ForApproval;
use App\Notifications\ApproveRequest;
use App\Notifications\DeclinedRequest;
use App\Notifications\ForDeployment;
use RealRashid\SweetAlert\Facades\Alert;
class RequestController extends Controller
{
    //
    public function requests (Request $request)
    {
        $approver = User::where('role','Approver')->first();
        $inventories = Inventory::with('unit_of_measure_data')->get();
        $request_inventory = EmployeeRequest::with('inventory','approver','histories.user_info','user_info','employee_info')->where('user_id',auth()->user()->id)->orderBy('id','desc')->get();
        $deployed_requests = EmployeeRequest::with('inventory')->where('status','Approved')
        ->where('user_id',auth()->user()->id)
        ->whereDoesntHave('inventory', function ($query) {
            $query->where('status','For Deployment');
        })->count();
        return view('requests',array(
            'header' => "Requests",
            'inventories' => $inventories,
            'request_inventory' => $request_inventory,
            'approver' => $approver,
            'deployed_requests' => $deployed_requests,
        ));
    }
    public function newRequest(Request $request)
    {
        $approver = User::where('role','Approver')->first();

        $requestInventory = new EmployeeRequest;
        $requestInventory->user_id = auth()->user()->id;
        $requestInventory->approver_id = $approver->id;
        $requestInventory->remarks = $request->remarks;
        $requestInventory->status = "Pending";
        if($request->hasFile('attachment'))
        {
            $attachment = $request->file('attachment');
            $original_name = $attachment->getClientOriginalName();
            $name = time().'_'.$attachment->getClientOriginalName();
            $attachment->move(public_path().'/transac/', $name);
            $file_name = '/transac/'.$name;
            $requestInventory->attachment = $file_name;
        }
        $requestInventory->save();


        foreach($request->inventory as $key => $inventory)
        {
            $reqInt = new RequestInventory;
            $reqInt->inventory_id = $inventory;
            $reqInt->request_qty = $request->request_quantity[$key];
            $reqInt->request_id = $requestInventory->id;
            $reqInt->status = "For Deployment";
            $reqInt->save();
            
        }

        $history = new RequestHistory;
        $history->employee_request_id = $requestInventory->id;
        $history->action = "Created";
        $history->user_id = auth()->user()->id;
        $history->save();
        $requestor = auth()->user()->name;
        $approver->notify(new ForApproval($requestInventory,$requestor));
        Alert::success('Successfully created.')->persistent('Dismiss');
        return back();
  
    }

    public function cancelRequest(Request $request)
    {
        // dd($request->all());

        $data_request = EmployeeRequest::findOrfail($request->cancel_id);
        // dd($data_request);
        $data_request->status = "Cancelled";
        $data_request->save();

        $history = new RequestHistory;
        $history->employee_request_id = $request->cancel_id;
        $history->action = "Cancelled";
        $history->remarks = $request->remarks;
        $history->user_id = auth()->user()->id;
        $history->save();

        Alert::success('Successfully Cancelled.')->persistent('Dismiss');
        return back();
        
    }
    public function for_approval(Request $request)
    {
        $approver = User::where('role','Approver')->first();
        $inventories = Inventory::with('unit_of_measure_data')->get();
        $request_inventory = EmployeeRequest::with('inventory','approver','histories.user_info','user_info','employee_info')->get();
        

        return view('for_approval',array(
            'header' => "For Approval",
            'inventories' => $inventories,
            'request_inventory' => $request_inventory,
            'approver' => $approver
        ));
    }

    public function declinedRequest(Request $request)
    {
        // dd($request->all());

        $data_request = EmployeeRequest::findOrfail($request->cancel_id);
        // dd($data_request);
        $data_request->status = "Declined";
        $data_request->save();
        $requestor = User::findOrfail($data_request->user_id);
        $history = new RequestHistory;
        $history->employee_request_id = $request->cancel_id;
        $history->action = "Declined";
        $history->remarks = $request->remarks;
        $history->user_id = auth()->user()->id;
        $history->save();
        $approver = auth()->user()->name;
        $requestor->notify(new DeclinedRequest($data_request,$approver));
        Alert::success('Successfully Declined.')->persistent('Dismiss');
        return back();
        
    }
    public function approvedRequest(Request $request)
    {
        // dd($request->all());

        $data_request = EmployeeRequest::findOrfail($request->approved_id);
        // dd($data_request);
        $data_request->status = "Approved";
        $data_request->save();

        $requestor = User::findOrfail($data_request->user_id);
        $history = new RequestHistory;
        $history->employee_request_id = $request->approved_id;
        $history->action = "Approved";
        $history->remarks = $request->remarks;
        $history->user_id = auth()->user()->id;
        $history->save();
        $approver = auth()->user()->name;
        $requestor->notify(new ApproveRequest($data_request,$approver));
        Alert::success('Successfully Approved.')->persistent('Dismiss');
        return back();
        
    }

    public function for_deployments(Request $request)
    {
        $approver = User::where('role','Approver')->first();
        $inventories = Inventory::with('unit_of_measure_data')->get();

        $for_deployments = RequestInventory::whereHas('employee_request',function ( $query) {
            $query->where('status', 'Approved');
        })->with('employee_request.user_info','inventory')->get();


        return view('for_deployments',array(
            'header' => "For Deployments",
            'inventories' => $inventories,
            'for_deployments' => $for_deployments,
        ));
    }
    public function deployed_item(Request $request)
    {
        // dd($request->all());

        $for_deployments = RequestInventory::findOrfail($request->dep_id);
        $for_deployments->status = "Deployed";
        $for_deployments->price = $request->price;

       
        $inventory = Inventory::where('id',$for_deployments->inventory_id)->first();
        // dd($for_deployments->request_qty);
        if($inventory->ending_balance < $for_deployments->request_qty)
        {
            Alert::error('Insufficient Inventory.')->persistent('Dismiss');
            return back();
        }
        $inventory->ending_balance = $inventory->ending_balance-$for_deployments->request_qty;
        $inventory->save();
        if($request->hasFile('attachment'))
        {
            $attachment = $request->file('attachment');
            $original_name = $attachment->getClientOriginalName();
            $name = time().'_'.$attachment->getClientOriginalName();
            $attachment->move(public_path().'/transac/', $name);
            $file_name = '/transac/'.$name;
            $for_deployments->attachment = $file_name;
        }

        $for_deployments->remarks = $request->remarks;
        $for_deployments->save();

        $history = new RequestHistory;
        $history->employee_request_id = $for_deployments->request_id;
        $history->action = "Deployed Item";
        $history->remarks = "Item : ".$inventory->item_description." \n Qty : ".$for_deployments->request_qty;
        $history->user_id = auth()->user()->id;
        $history->save();

        Alert::success('Successfully Deployed.')->persistent('Dismiss');
        return back();
    }
}
