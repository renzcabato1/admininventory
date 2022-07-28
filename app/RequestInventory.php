<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestInventory extends Model
{
    //

    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
    public function employee_request()
    {
        return $this->belongsTo(EmployeeRequest::class,'request_id','id');
    }
}
