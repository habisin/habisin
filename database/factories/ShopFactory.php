<?php

namespace Database\Factories;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Shop>
 */
class ShopFactory extends Factory
{
    protected $model = Shop::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::factory()->state(['role' => 'merchant']),
            'name' => fake()->company(),
            'logo' => null,
            'description' => fake()->sentence(),
            'address' => fake()->address(),
            'latitude' => fake()->latitude(-6.3, -6.1),
            'longitude' => fake()->longitude(106.7, 107.0),
            'is_active' => true,
            'balance' => fake()->numberBetween(0, 100000),
        ];
    }
}
