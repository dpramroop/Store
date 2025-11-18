<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderSalesItem extends Model
{
    //
         use HasFactory;
        protected $table = 'order_sales_item';
        protected $fillable = [
            'order_id',
            'sales_item_id',
            'quantity',
            'cost',
    ];


    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function Item()
    {
        return $this->belongsTo(Item::class, 'sales_item_id');
    }

}
