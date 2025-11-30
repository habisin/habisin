<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition()
    {
        return [
            'user_id' => User::factory()->state(['role' => 'user']),
            'shop_id' => Shop::factory(),
            'total_cost' => 0, // akan dihitung setelah order_items
            'order_type' => fake()->randomElement(['pickup', 'delivery']),
            'status' => fake()->randomElement(['pending','processing','completed']),
            'payment_method' => 'midtrans',
            'payment_status' => fake()->randomElement(['unpaid','paid']),
            'payment_id' => fake()->uuid(),
            'pickup_code' => fake()->randomNumber(5),
            'delivery_address' => fake()->address(),
        ];
    }
}
