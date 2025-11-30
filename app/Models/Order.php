<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'shop_id',
        'total_cost',
        'order_type',
        'status',
        'payment_method',
        'payment_status',
        'payment_id',
        'pickup_code',
        'delivery_address',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function shop() {
        return $this->belongsTo(Shop::class);
    }

    public function items() {
        return $this->hasMany(OrderItem::class);
    }
}
