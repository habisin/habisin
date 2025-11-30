<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Shop;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // Create merchants
        $merchants = User::factory()
            ->count(5)
            ->state(['role' => 'merchant'])
            ->create();

        $merchants->each(function ($merchant) {
            // Create a shop for each merchant
            $shop = Shop::factory()->create([
                'user_id' => $merchant->id,
            ]);

            // Create products for each shop
            $products = Product::factory()->count(5)->create([
                'shop_id' => $shop->id,
            ]);

            // Create orders for random users
            User::factory()->state(['role'=> 'user'])->create()->each(function ($buyer) use ($shop, $products) {
                $order = Order::factory()->create([
                    'user_id' => $buyer->id,
                    'shop_id' => $shop->id,
                ]);

                $total = 0;

                foreach ($products->random(rand(1,4)) as $product) {
                    $quantity = rand(1, 3);
                    $price = $product->price; // Price at the time of order

                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $product->id,
                        'quantity' => $quantity,
                        'price' => $price,
                    ]);

                    // Calculate total cost for the order
                    $total += $price * $quantity;
                }

                $order->update(['total_cost' => $total]);
            });
        });
    }
}
