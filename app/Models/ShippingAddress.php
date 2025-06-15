<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $table = 'shipping_addresses';

    protected $fillable = [
        'order_id',
        'name',
        'phone',
        'email',
        'address',
        'note',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
