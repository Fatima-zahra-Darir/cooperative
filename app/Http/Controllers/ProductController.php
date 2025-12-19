<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = \App\Models\Product::with(['categories', 'colors', 'sizes'])->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all();
        $colors = \App\Models\Color::all();
        $sizes = \App\Models\Size::all();
        return view('products.create', compact('categories', 'colors', 'sizes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'colors' => 'required|array',
            'colors.*' => 'exists:colors,id',
            'sizes' => 'required|array',
            'sizes.*' => 'exists:sizes,id',
        ]);

        $product = \App\Models\Product::create($request->only('name'));
        $product->categories()->sync($request->categories);
        $product->colors()->sync($request->colors);
        $product->sizes()->sync($request->sizes);

        return redirect()->route('products.index')->with('success', 'Produit créé avec succès.');
    }

    public function edit($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $categories = \App\Models\Category::all();
        $colors = \App\Models\Color::all();
        $sizes = \App\Models\Size::all();
        return view('products.edit', compact('product', 'categories', 'colors', 'sizes'));
    }

    public function update(Request $request, $id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'categories' => 'required|array',
            'categories.*' => 'exists:categories,id',
            'colors' => 'required|array',
            'colors.*' => 'exists:colors,id',
            'sizes' => 'required|array',
            'sizes.*' => 'exists:sizes,id',
        ]);

        $product->update($request->only('name'));
        $product->categories()->sync($request->categories);
        $product->colors()->sync($request->colors);
        $product->sizes()->sync($request->sizes);

        return redirect()->route('products.index')->with('success', 'Produit mis à jour avec succès.');
    }

    public function destroy($id)
    {
        $product = \App\Models\Product::findOrFail($id);
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produit supprimé avec succès.');
    }
}

