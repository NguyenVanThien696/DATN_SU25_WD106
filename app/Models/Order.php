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
        'order_code',  
        'coupon_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'customer_address',
    ];

    // Quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
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

    public function coupons()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id');
    }


}