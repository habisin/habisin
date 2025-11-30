<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // List all orders for a shop
    public function shopOrders() {
        $shop = auth()->user()->shop;

        if (!$shop) {
            // User has no shop, redirect to onboarding
            return redirect()->route('merchant.onboarding');
        }

        $orders = $shop->orders;
        return view('merchant.orders.index', compact('shop', 'orders'));
    }

    public function update(Request $request, Order $order) {
        $request->validate([
            'status' => 'required|string|in:pending,processing,completed,cancelled',
        ]);

        $order->update([
            'status'=> $request->status
        ]);

        return back();
    }
}
