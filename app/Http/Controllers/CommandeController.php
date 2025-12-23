<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Client;
use App\Models\ProductStock;
use App\Models\StockMovement;
use Illuminate\Http\Request;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandes = Commande::with(['client', 'productStock.product', 'productStock.category', 'productStock.color', 'productStock.size'])
            ->latest()
            ->get();
        return view('commandes.index', compact('commandes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        $productStocks = ProductStock::with(['product', 'category', 'color', 'size', 'movements'])->get();
        return view('commandes.create', compact('clients', 'productStocks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'product_stock_id' => 'required|exists:product_stock,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $productStock = ProductStock::findOrFail($request->product_stock_id);
        
        // Check if there's enough stock
        $globalQuantity = $productStock->global_quantity;
        if ($request->quantity > $globalQuantity) {
            return back()->withErrors(['quantity' => 'Quantité insuffisante en stock. Stock disponible: ' . $globalQuantity])->withInput();
        }

        $commande = Commande::create([
            'client_id' => $request->client_id,
            'product_stock_id' => $request->product_stock_id,
            'quantity' => $request->quantity,
            'status' => 'en attente',
            'notes' => $request->notes,
        ]);

        // Create stock movement to deduct from stock
        StockMovement::create([
            'product_stock_id' => $productStock->id,
            'type' => 'usage',
            'quantity' => $request->quantity,
            'movement_date' => now(),
            'notes' => 'Commande #' . $commande->id . ' - ' . ($request->notes ?? ''),
        ]);

        return redirect()->route('commandes.index')->with('success', 'Commande créée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Commande $commande)
    {
        $commande->load(['client', 'productStock.product', 'productStock.category', 'productStock.color', 'productStock.size']);
        return view('commandes.show', compact('commande'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commande $commande)
    {
        $commande->load(['client', 'productStock.product', 'productStock.category', 'productStock.color', 'productStock.size']);
        $clients = Client::orderBy('name')->get();
        $productStocks = ProductStock::with(['product', 'category', 'color', 'size', 'movements'])->get();
        return view('commandes.edit', compact('commande', 'clients', 'productStocks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commande $commande)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'product_stock_id' => 'required|exists:product_stock,id',
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        $oldQuantity = $commande->quantity;
        $newQuantity = $request->quantity;
        $oldProductStockId = $commande->product_stock_id;
        $newProductStockId = $request->product_stock_id;
        $isCancelled = $commande->status === 'annulé';

        // Only adjust stock if order is not cancelled
        if (!$isCancelled && ($oldProductStockId != $newProductStockId || $oldQuantity != $newQuantity)) {
            // Restore old stock (create restock movement for old quantity on old product)
            StockMovement::create([
                'product_stock_id' => $oldProductStockId,
                'type' => 'restock',
                'quantity' => $oldQuantity,
                'movement_date' => now(),
                'notes' => 'Commande #' . $commande->id . ' modifiée - quantité/produit changé',
            ]);

            // Check new stock availability
            $newProductStock = ProductStock::findOrFail($newProductStockId);
            $globalQuantity = $newProductStock->global_quantity;
            
            // If same product stock, add back the old quantity
            $availableQuantity = $oldProductStockId == $newProductStockId 
                ? $globalQuantity + $oldQuantity 
                : $globalQuantity;
            
            if ($newQuantity > $availableQuantity) {
                return back()->withErrors(['quantity' => 'Quantité insuffisante en stock. Stock disponible: ' . $availableQuantity])->withInput();
            }

            // Deduct new stock (create usage movement for new quantity on new product)
            StockMovement::create([
                'product_stock_id' => $newProductStockId,
                'type' => 'usage',
                'quantity' => $newQuantity,
                'movement_date' => now(),
                'notes' => 'Commande #' . $commande->id . ' - ' . ($request->notes ?? ''),
            ]);
        }

        $commande->update($request->only(['client_id', 'product_stock_id', 'quantity', 'notes']));

        return redirect()->route('commandes.index')->with('success', 'Commande mise à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande)
    {
        // Restore stock when deleting order
        StockMovement::create([
            'product_stock_id' => $commande->product_stock_id,
            'type' => 'restock',
            'quantity' => $commande->quantity,
            'movement_date' => now(),
            'notes' => 'Commande #' . $commande->id . ' supprimée',
        ]);

        $commande->delete();

        return redirect()->route('commandes.index')->with('success', 'Commande supprimée avec succès.');
    }

    /**
     * Update commande status via AJAX
     */
    public function updateStatus(Request $request, Commande $commande)
    {
        try {
            $request->validate([
                'status' => 'required|in:en attente,en cours,livré,annulé',
            ]);

            $commande->load('productStock.movements');
            $oldStatus = $commande->status;
            $newStatus = $request->status;

            // If changing from cancelled to not cancelled, deduct stock again
            if ($oldStatus === 'annulé' && $newStatus !== 'annulé') {
                $productStock = $commande->productStock;
                $globalQuantity = $productStock->global_quantity;
                
                if ($commande->quantity > $globalQuantity) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Quantité insuffisante en stock. Stock disponible: ' . $globalQuantity
                    ], 400);
                }

                StockMovement::create([
                    'product_stock_id' => $commande->product_stock_id,
                    'type' => 'usage',
                    'quantity' => $commande->quantity,
                    'movement_date' => now(),
                    'notes' => 'Commande #' . $commande->id . ' - statut changé de annulé à ' . $newStatus,
                ]);
            }
            
            // If changing to cancelled, restore stock
            if ($oldStatus !== 'annulé' && $newStatus === 'annulé') {
                StockMovement::create([
                    'product_stock_id' => $commande->product_stock_id,
                    'type' => 'restock',
                    'quantity' => $commande->quantity,
                    'movement_date' => now(),
                    'notes' => 'Commande #' . $commande->id . ' - annulée',
                ]);
            }

            $commande->update(['status' => $newStatus]);

            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès.',
                'status' => $newStatus
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue: ' . $e->getMessage()
            ], 500);
        }
    }
}
