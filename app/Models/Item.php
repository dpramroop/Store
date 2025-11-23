<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    //
     use HasFactory;
    protected $table = 'item';
        protected $fillable = [
        'name',
        'description',
        'brand',
        'category',
        'attributes',
        'stock_quantity',
    ];
        protected $casts = [
        'attributes' => 'array',
    ];

public function scopeSearch($query,$value)
    {
        $query->where('name','like',"%{$value}%")->orWhere('category','like',"%{$value}%");
    }


    public function orderSalesItems()
    {
        return $this->hasMany(OrderSalesItem::class, 'sales_item_id');
    }
}
