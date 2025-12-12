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

public function order()
{
    return $this->belongsTo(Order::class, 'order_id');
}

public function courier()
{
    return $this->belongsTo(Courier::class, 'courier_id');


}
}
