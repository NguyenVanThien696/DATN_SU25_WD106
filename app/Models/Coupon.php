<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'discount_percent',
        'expires_at',
    ];

    protected $dates = ['expires_at'];

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