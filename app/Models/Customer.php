<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //
use HasFactory;
    protected $table = 'customer';
    protected $fillable = [
        'fname',
        'lname',
        'email',
        'contact_no',
        'address',
        'city',
        'direction'
    ];

    public function scopeSearch($query,$value)
    {
        $query->where('name','like',"%{$value}%")->orWhere('contact_no','like',"%{$value}%");
    }

}
