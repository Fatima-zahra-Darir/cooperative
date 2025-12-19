<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductStock;
use Illuminate\Http\Request;

class StockProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $stocks = ProductStock::with('product')->get();
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        ProductStock::create($request->only(['product_id', 'quantity', 'notes']));

        return redirect()->route('stock-produit.index')->with('success', 'Stock produit créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $stock = ProductStock::with('product')->findOrFail($id);
        return view('stock-produit.show', compact('stock'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $stock = ProductStock::with('product')->findOrFail($id);
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
            'quantity' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $stock->update($request->only(['product_id', 'quantity', 'notes']));

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
}
