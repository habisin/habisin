<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'shop_id',
        'name',
        'description',
        'price',
        'stock',
        'image',
        'is_active',
    ];

    public function shop(): BelongsTo {
        return $this->belongsTo(Shop::class);
    }
}
