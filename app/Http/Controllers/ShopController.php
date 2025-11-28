<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function onboarding() {
        // Check if the user already has a shop
        $shop = auth()->user()->shop;
        if ($shop) {
            return redirect()
                ->route('merchant.dashboard');
        }
        return view('merchant.onboarding');
    }

    public function store(Request $request) {
        // Validate and store shop data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'logo' => 'nullable|image|max:2048',
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('shop_logos');
        }

        $shop = Shop::create([
            'user_id'       => auth()->id(),
            'name'          => $request->name,
            'description'   => $request->description,
            'address'       => $request->address,
            'latitude'      => $request->latitude,
            'longitude'     => $request->longitude,
            'logo'          => $logoPath,
            'is_active'     => false,
            'balance'       => 0,
        ]);

        return redirect()
            ->route('merchant.dashboard')
            ->with('success','Toko berhasil dibuat dan sudah aktif. Selamat berjualan 🎉');
    }

    function dashboard() {
        $shop = auth()->user()->shop;

        if (!$shop) {
            // User has no shop, redirect to onboarding
            return redirect()->route('merchant.onboarding');
        }

        // Shop statistics
        $totalProducts = $shop->products()->count();
        $totalSales = 0; // TODO: Implement sales calculation
        $totalRevenue = 0; // TODO: Implement revenue calculation

        return view('merchant.dashboard', compact('shop', 'totalProducts', 'totalSales', 'totalRevenue'));
    }
}
