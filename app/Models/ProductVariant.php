<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

    protected $fillable = ['product_id', 'size_id', 'color_id', 'stock'];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class, 'size_id');
    }

    public function color()
    {
        return $this->belongsTo(Color::class, 'color_id');
    }
        public static function getSizesByProduct($productId)
    {
        return self::where('product_id', $productId)
            ->with('size')
            ->get()
            ->pluck('size')
            ->unique('id')
            ->values();
    }
    public static function getColorsByProduct($productId)
{
    return self::where('product_id', $productId)
        ->with('color')
        ->get()
        ->pluck('color')
        ->unique('id')
        ->values();
}

}