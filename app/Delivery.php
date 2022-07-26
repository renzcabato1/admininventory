<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delivery extends Model
{
    //

    public function DeliveryItems()
    {
        return $this->hasMany(DeliveryItem::class);
    }
}
