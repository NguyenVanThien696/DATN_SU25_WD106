<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    protected $table = 'banners';

    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'position',
        'status',
    ];

    protected $casts = [
        'status' => 'string',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'visible');
    }

    // Scope theo vị trí
    public function scopePosition($query, $pos)
    {
        return $query->where('position', $pos);
    }

    public static function statuses()
    {
        return ['visible', 'hidden'];
    }
}
