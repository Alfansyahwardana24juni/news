<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class BannerAdvertisement extends Model
{
    use HasFactory;

    protected $fillable = [
        'link',
        'is_active',
        'type',
        'thumbnail'
    ];

    public $casts = [
        'is_active' => 'string',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', 'active');
    }
}
