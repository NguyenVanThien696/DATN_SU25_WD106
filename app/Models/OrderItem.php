<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'product_variant_id', // <-- đúng tên cột của bạn
        'quantity',
        'price',
        'note',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    public function productVariant()
    {
        return $this->belongsTo(ProductVariant::class, 'product_variant_id'); // <-- chỉ rõ FK
    }
}
