<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'total_price',
        'shipping_fee',
        'status',
        'note',  
        'payment_method',
        'payment_status',       
        'discount',    
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Quan hệ với các order item
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress()
    {
    return $this->hasOne(ShippingAddress::class);
    }

    public function Coupons()
    {
        return $this->belongsTo(Coupon::class);
    }
}