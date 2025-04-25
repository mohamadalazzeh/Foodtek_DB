<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'name',
        'order_id',
        'quantity',
        'price',
        'image',
    ];
    //
}
