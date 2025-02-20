<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'image_urls',
        'rating',
        'price',
        'description',
        'tagline'
    ];

    protected $casts = [
        'image_urls' => 'array'
    ];
}
