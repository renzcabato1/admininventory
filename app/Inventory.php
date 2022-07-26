<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    //

    public function unit_of_measure_data()
    {
        return $this->belongsTo(UnitOfMeasure::class,'unit_of_measure','id');
    }
}
