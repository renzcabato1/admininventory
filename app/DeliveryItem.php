<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeliveryItem extends Model
{
    //
    public function inventory()
    {
        return $this->belongsTo(Inventory::class);
    }
}
