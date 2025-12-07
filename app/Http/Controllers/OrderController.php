<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    // List all orders for a shop
    public function shopOrders()
    {
        $shop = auth()->user()->shop;

        if (!$shop) {
            // User has no shop, redirect to onboarding
            return redirect()->route('merchant.onboarding');
        }

        $orders = $shop->orders()->where('status', '!=', 'pending')->get();
        return view('merchant.orders.index', compact('shop', 'orders'));
    }

    public function update(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|string|in:pending,processing,completed,cancelled',
        ]);

        // Valid transitions
        $allowedTransitions = [
            'pending' => ['processing', 'cancelled'],
            'processing' => ['completed', 'cancelled'],
            'completed' => [],
            'cancelled' => []
        ];

        $currentStatus = $order->status;
        $newStatus = $request->status;

        if (!isset($allowedTransitions[$currentStatus]) || !in_array($newStatus, $allowedTransitions[$currentStatus])) {
            return back()->withErrors(['status' => 'Invalid status transition']);
        }

        $order->update([
            'status' => $request->status
        ]);

        return back();
    }

    public function checkout(Request $request)
    {
        $user = auth()->user();

        // Ambil items yang quantitynya > 0
        $items = collect($request->items)
            ->filter(fn($qty) => $qty > 0);


        if ($items->isEmpty()) {
            return back()->withErrors(['msg' => 'Tidak ada produk yang dipilih']);
        }

        $productIds = $items->keys();
        $products = Product::whereIn('id', $productIds)->get()->keyBy('id');

        // Check product ada
        if ($products->count() !== count($productIds)) {
            return back()->withErrors(['msg' => 'Produk tidak valid']);
        }

        // Hitung total cost
        $totalCost = 0;
        foreach ($products as $product) {
            // totalCost += Price * Quantity
            $totalCost += $product->price * $items[$product->id];
        }

        // Buat order
        $order = Order::create([
            'user_id' => $user->id,
            'shop_id' => $products->first()->shop_id,
            'total_cost' => $totalCost,
            'order_type' => 'delivery', // TODO: buat opsi pickup buat pembeli
            'status' => 'pending',
            'payment_method' => 'midtrans',
            'payment_status' => 'pending',
            'delivery_address' => $request->delivery_address,
        ]);

        // Buat order items
        foreach ($products as $product) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $items[$product->id],
                'price' => $product->price
            ]);
        }

        // Kurangi stock produk
        foreach ($products as $product) {
            $qty = $items[$product->id];
            $product->decrement('stock', $qty);
        }

        // Payment gateway (Midtrans) configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $midtransParams = [
            'transaction_details' => [
                'order_id' => 'ORDER-' . $order->id,
                'gross_amount' => $totalCost,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
            ],
        ];

        try {
            $paymentUrl = Snap::createTransaction($midtransParams)->redirect_url;
        } catch (\Exception $e) {
            return back()->withErrors(['msg' => 'Terjadi kesalahan pada sistem pembayaran: ' . $e->getMessage()]);
        }

        // Store payment id
        $order->update([
            'payment_id' => $midtransParams['transaction_details']['order_id']
        ]);

        // Redirect ke Midtrans
        return redirect($paymentUrl);
    }
}
