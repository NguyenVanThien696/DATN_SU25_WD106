<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'category_id',
        'brand_id',
        'tag_id',
        'name',
        'description',
        'price',
        'image',
        
    ];


        public function category(){
        return $this->belongsTo(Category::class, 'category_id');
    }
        public function brand(){
        return $this->belongsTo(Brand::class, 'brand_id');
    }
        public function tag(){
        return $this->belongsTo(Tag::class, 'tag_id');
    }
        public function variants() {
        return $this->hasMany(ProductVariant::class);
    }
}