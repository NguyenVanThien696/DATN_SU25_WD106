<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_type',
        'discount_percent',
        'max_discount_amount',
        'min_order_amount',
        'discount_amount',
        'expires_at',
        'start_at',
        'end_at',
        'usage_limit',
        'used',
        'status',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    public function isValid(): bool
    {
        return $this->expires_at === null || $this->expires_at->isFuture();
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_coupons')
                    ->withPivot('used_at')
                    ->withTimestamps();
    } 
}