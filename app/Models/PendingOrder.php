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
        'discount',
        'shipping_fee',
        'order_code',
        'customer_name',
        'customer_email',
        'customer_phone',
        'customer_address',
    ];

    protected $casts = [
        'user_info' => 'array',
        'cart_items' => 'array',
    ];
}