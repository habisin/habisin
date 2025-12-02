<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function onboarding()
    {
        // Check if the user already has a shop
        $shop = auth()->user()->shop;
        if ($shop) {
            return redirect()
                ->route('merchant.dashboard');
        }
        return view('merchant.onboarding');
    }

    public function store(Request $request)
    {
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
            'user_id' => auth()->id(),
            'name' => $request->name,
            'description' => $request->description,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'logo' => $logoPath,
            'is_active' => false,
            'balance' => 0,
        ]);

        return redirect()
            ->route('merchant.dashboard')
            ->with('success', 'Toko berhasil dibuat dan sudah aktif. Selamat berjualan 🎉');
    }

    function dashboard()
    {
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

    public function publicList(Request $request)
    {
        $query = Shop::where('is_active', true);

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Jika user mengirim lat/lng → hitung jarak di SQL
        if ($request->lat && $request->lng) {
            $lat = $request->lat;
            $lng = $request->lng;

            $query->selectRaw("
                id, name, logo, description, address, latitude, longitude,
                (
                    6371 * acos(
                        cos(radians(?)) *
                        cos(radians(latitude)) *
                        cos(radians(longitude) - radians(?)) +
                        sin(radians(?)) *
                        sin(radians(latitude))
                    )
                ) AS distance
            ", [$lat, $lng, $lat]);

            // Urutkan berdasarkan jarak terdekat
            $query->orderBy('distance', 'asc');
        }

        $shops = $query->paginate(10)->withQueryString();

        return view('buyer.shop.index', compact('shops'));
    }

    public function show($id)
    {
        $shop = Shop::with([
            'products' => function ($query) {
                // Hanya produk yang aktif dan tersedia
                $query->where('is_active', true)->where('stock', '>', 0);
            }
        ])->findOrFail($id);

        return view('buyer.shop.show', compact('shop'));
    }

    public function edit()
    {
        $shop = auth()->user()->shop;
        return view('merchant.shop.edit', compact('shop'));
    }

    public function update(Request $request)
    {
        $shop = auth()->user()->shop;

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'address' => 'required|string',
            'latitude' => 'required',
            'longitude' => 'required',
            'logo' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('shop_logos');
        }

        $data['is_active'] = $request->has('is_active');

        $shop->update($data);

        return redirect()
            ->route('merchant.dashboard')
            ->with('success', 'Toko berhasil diperbarui!');
    }

}