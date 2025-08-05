<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;
use App\Models\User;

class RefundRequest extends Model
{
    protected $table = 'refund_requests';

    protected $fillable = [
        'user_id',
        'order_id',
        'reason',
        'image',
        'original_bank_name',
        'original_account_number',
        'original_account_name',
        'status',
    ];

    protected $casts = [
        'order_id' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
