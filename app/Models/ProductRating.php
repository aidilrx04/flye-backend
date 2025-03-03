<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductRating extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'total_star',
        'total_rating'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
