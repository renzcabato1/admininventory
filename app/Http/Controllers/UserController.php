<?php

namespace App\Http\Controllers;
use RealRashid\SweetAlert\Facades\Alert;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function changeRole(Request $request)
    {
      
        $user = User::findOrfail($request->employee_id);
      
        $user->role = $request->role;
        $user->save();
        Alert::success('Successfully Change Role.')->persistent('Dismiss');
        return back();
    }
}
