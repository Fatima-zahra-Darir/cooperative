<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductStock;
use App\Models\Category;
use App\Models\Color;
use App\Models\Size;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class StockProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = ProductStock::with(['product', 'category', 'color', 'size', 'movements'])->get();
        return view('stock-produit.index', compact('stocks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $products = Product::all();
        return view('stock-produit.create', compact('products'));
    }

    /**
     * Get product attributes (categories, colors, sizes) for a given product
     */
    public function getProductAttributes($productId)
    {
        $product = Product::with(['categories', 'colors', 'sizes'])->findOrFail($productId);
        
        return response()->json([
            'categories' => $product->categories,
            'colors' => $product->colors,
            'sizes' => $product->sizes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'category_id' => 'nullable|exists:categories,id',
            'color_id' => 'nullable|exists:colors,id',
            'size_id' => 'nullable|exists:sizes,id',
            'quantity' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        // Verify that the selected attributes belong to the product
        $product = Product::with(['categories', 'colors', 'sizes'])->findOrFail($request->product_id);
        
        if ($request->category_id && !$product->categories->contains('id', $request->category_id)) {
            return back()->withErrors(['category_id' => 'La catégorie sélectionnée n\'appartient pas à ce produit.'])->withInput();
        }
        
        if ($request->color_id && !$product->colors->contains('id', $request->color_id)) {
            return back()->withErrors(['color_id' => 'La couleur sélectionnée n\'appartient pas à ce produit.'])->withInput();
        }
        
        if ($request->size_id && !$product->sizes->contains('id', $request->size_id)) {
            return back()->withErrors(['size_id' => 'La taille sélectionnée n\'appartient pas à ce produit.'])->withInput();
        }

        ProductStock::create($request->only(['product_id', 'category_id', 'color_id', 'size_id', 'quantity', 'notes']));

        return redirect()->route('stock-produit.index')->with('success', 'Stock produit créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stock = ProductStock::with(['product', 'category', 'color', 'size', 'movements' => function($query) {
            $query->orderBy('movement_date', 'desc')->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        return view('stock-produit.show', compact('stock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $stock = ProductStock::with(['product', 'category', 'color', 'size'])->findOrFail($id);
        $products = Product::all();
        return view('stock-produit.edit', compact('stock', 'products'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $stock = ProductStock::findOrFail($id);
        
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'category_id' => 'nullable|exists:categories,id',
            'color_id' => 'nullable|exists:colors,id',
            'size_id' => 'nullable|exists:sizes,id',
            'quantity' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        // Verify that the selected attributes belong to the product
        $product = Product::with(['categories', 'colors', 'sizes'])->findOrFail($request->product_id);
        
        if ($request->category_id && !$product->categories->contains('id', $request->category_id)) {
            return back()->withErrors(['category_id' => 'La catégorie sélectionnée n\'appartient pas à ce produit.'])->withInput();
        }
        
        if ($request->color_id && !$product->colors->contains('id', $request->color_id)) {
            return back()->withErrors(['color_id' => 'La couleur sélectionnée n\'appartient pas à ce produit.'])->withInput();
        }
        
        if ($request->size_id && !$product->sizes->contains('id', $request->size_id)) {
            return back()->withErrors(['size_id' => 'La taille sélectionnée n\'appartient pas à ce produit.'])->withInput();
        }

        $stock->update($request->only(['product_id', 'category_id', 'color_id', 'size_id', 'quantity', 'notes']));

        return redirect()->route('stock-produit.index')->with('success', 'Stock produit mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stock = ProductStock::findOrFail($id);
        $stock->delete();

        return redirect()->route('stock-produit.index')->with('success', 'Stock produit supprimé avec succès.');
    }

    /**
     * Restock a product
     */
    public function restock(Request $request, string $id)
    {
        $stock = ProductStock::findOrFail($id);
        
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'movement_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        StockMovement::create([
            'product_stock_id' => $stock->id,
            'type' => 'restock',
            'quantity' => $request->quantity,
            'movement_date' => $request->movement_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('stock-produit.index')->with('success', 'Stock réapprovisionné avec succès.');
    }

    /**
     * Record product usage
     */
    public function usage(Request $request, string $id)
    {
        $stock = ProductStock::findOrFail($id);
        
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'movement_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Check if there's enough stock
        $globalQuantity = $stock->global_quantity;
        if ($request->quantity > $globalQuantity) {
            return back()->withErrors(['quantity' => 'Quantité insuffisante en stock. Stock disponible: ' . $globalQuantity])->withInput();
        }

        StockMovement::create([
            'product_stock_id' => $stock->id,
            'type' => 'usage',
            'quantity' => $request->quantity,
            'movement_date' => $request->movement_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('stock-produit.index')->with('success', 'Utilisation enregistrée avec succès.');
    }
}
