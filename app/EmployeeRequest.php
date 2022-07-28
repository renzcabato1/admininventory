<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EmployeeRequest extends Model
{
    //

    public function inventory()
    {
        return $this->hasMany(RequestInventory::class,'request_id','id');
    }
    public function histories()
    {
        return $this->hasMany(RequestHistory::class,'employee_request_id','id');
    }

    public function approver()
    {
        return $this->hasOne(User::class,'id','approver_id');
    }
    public function user_info()
    {
        return $this->hasOne(User::class,'id','user_id');
    }
    public function employee_info()
    {
        return $this->hasOne(Employee::class,'user_id','user_id');
    }
}
