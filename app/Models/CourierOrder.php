<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourierOrder extends Model
{
    //
     protected $table = 'courierorder';
    protected $fillable = [
        'order_id',
        'courier_id',
        'status',
];
}
