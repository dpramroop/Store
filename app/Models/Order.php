<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    //
      use HasFactory;
        protected $table = 'order';
        protected $fillable = [
          'customer_id',
          'totalprice',
          'status'
    ];


    public function orderSalesItems()
    {
        return $this->hasMany(OrderSalesItem::class, 'order_id');
    }

        public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function courierOrder()
    {
        return $this->hasMany(CourierOrder::class, 'order_id');
    }
}
