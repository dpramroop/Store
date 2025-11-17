<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleModel extends Model
{
    //
    use HasFactory;
    protected $table = 'sale_item';
    protected $fillable = [
    'name',
    'description',
    'category',
    'price',
    ];
         protected $casts = [
        'item_list' => 'array',
    ];
}
