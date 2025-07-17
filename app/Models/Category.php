<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
];

public function products(){
    return $this->hasMany(Product::class);
}

public function parent(){
    return $this->belongsTo(Category::class, 'parent_id');
}

public function children(){
    return $this->manyHas(Category::class, 'parent_id');
}

public function getCategory(){
    $breadcrumbs = collect();
    $category = $this;

    while($category){
        $breadcrumbs->prepend($category);
        $category = $category->parent;
    }
    return $breadcrumbs;
}
}
