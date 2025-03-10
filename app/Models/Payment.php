<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'amount',
        'method',
        'url',
        'status',
        'valid_until'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
