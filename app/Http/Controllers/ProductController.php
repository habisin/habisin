<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function create()
    {
        return view('merchant.products.create');
    }

    public function store(Request $request)
    {
        // Validate and store the product
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        // Store the product
        $product = Product::create([
            'shop_id' => auth()->user()->shop->id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $request->hasFile('image') ? $request->file('image')->store('product_images') : null,
            'is_active' => true,
        ]);
        return redirect()->route('merchant.dashboard')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        // Check product ownership
        if ($product->shop_id != auth()->user()->shop->id) {
            abort(403, 'Unauthorized action.');
        }
        return view('merchant.products.edit', compact('product'));
    }

    public function update(Request $request, Product $product)
    {
        // Check product ownership
        if ($product->shop_id != auth()->user()->shop->id) {
            abort(403, 'Unauthorized action.');
        }

        // Validate and update the product
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048',
        ]);

        $product->update([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
        ]);

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('product_images');
            $product->save();
        }

        return redirect()->route('merchant.dashboard')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Check product ownership
        if ($product->shop_id != auth()->user()->shop->id) {
            abort(403, 'Unauthorized action.');
        }
        
        $product->delete();
        return redirect()->route('merchant.dashboard')->with('success', 'Product deleted successfully.');
    }
}