<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shop extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'logo',
        'description',
        'address',
        'latitude',
        'longitude',
        'is_active',
        'balance',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class);
    }

    public function products() {
        return $this->hasMany(Product::class);
    }
}
