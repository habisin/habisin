<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shop extends Model
{
    use HasFactory;
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

    public function orders() {
        return $this->hasMany(Order::class);
    }
}
