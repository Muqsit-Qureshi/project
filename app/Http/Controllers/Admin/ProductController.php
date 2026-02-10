<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductImage;

class ProductController extends Controller
{
     public function index()
    {
        $products = Product::with('images')->latest()->get();
        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

     public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'images' => 'required',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp'
        ]);
        $product = Product::create([
            'name'  => $request->name,
            'price' => $request->price
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }

        return redirect()->route('admin.products.index')
            ->with('success', 'Product added successfully');
    }


      public function show(Product $product)
    {
        $product->load('images');
        return view('admin.products.show', compact('product'));
    }

    
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Product deleted successfully');
    }
}
