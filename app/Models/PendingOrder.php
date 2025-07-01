<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PendingOrder extends Model
{
        protected $fillable = [
        'txn_ref',
        'user_id',
        'total_price',
        'note',
        'user_info',
        'cart_items',
    ];

    protected $casts = [
        'user_info' => 'array',
        'cart_items' => 'array',
    ];
}