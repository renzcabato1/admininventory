<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestHistory extends Model
{
    //

    public function user_info()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
