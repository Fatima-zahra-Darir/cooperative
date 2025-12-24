<?php

namespace App\Http\Controllers;

use App\Models\Capsule;
use App\Models\CapsuleStockMovement;
use App\Models\Herb;
use App\Models\HerbStockMovement;
use Illuminate\Http\Request;

class StockCapsuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $capsules = Capsule::with('movements')->get();
        $herbs = Herb::all();
        return view('stock-capsules.index', compact('capsules', 'herbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('stock-capsules.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'carton' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        Capsule::create($request->only(['carton', 'quantity', 'notes']));

        return redirect()->route('stock-capsules.index')->with('success', 'Stock capsule créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $capsule = Capsule::with(['movements' => function($query) {
            $query->with('herb')->orderBy('movement_date', 'desc')->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        return view('stock-capsules.show', compact('capsule'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $capsule = Capsule::findOrFail($id);
        return view('stock-capsules.edit', compact('capsule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $capsule = Capsule::findOrFail($id);
        
        $request->validate([
            'carton' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'notes' => 'nullable|string',
        ]);

        $capsule->update($request->only(['carton', 'quantity', 'notes']));

        return redirect()->route('stock-capsules.index')->with('success', 'Stock capsule mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $capsule = Capsule::findOrFail($id);
        $capsule->delete();

        return redirect()->route('stock-capsules.index')->with('success', 'Stock capsule supprimé avec succès.');
    }

    /**
     * Restock a capsule
     */
    public function restock(Request $request, string $id)
    {
        $capsule = Capsule::findOrFail($id);
        
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'movement_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        CapsuleStockMovement::create([
            'capsule_id' => $capsule->id,
            'type' => 'restock',
            'quantity' => $request->quantity,
            'movement_date' => $request->movement_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('stock-capsules.index')->with('success', 'Stock réapprovisionné avec succès.');
    }

    /**
     * Record capsule usage
     */
    public function usage(Request $request, string $id)
    {
        $capsule = Capsule::findOrFail($id);
        
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'herb_id' => 'required|exists:herbs,id',
            'herb_quantity' => 'required|numeric|min:0.01',
            'movement_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Check if there's enough capsule stock
        $globalQuantity = $capsule->global_quantity;
        if ($request->quantity > $globalQuantity) {
            return back()->withErrors(['quantity' => 'Quantité insuffisante en stock. Stock disponible: ' . $globalQuantity])->withInput();
        }

        // Check if there's enough herb stock
        $herb = Herb::findOrFail($request->herb_id);
        $herbGlobalQuantity = $herb->global_quantity;
        if ($request->herb_quantity > $herbGlobalQuantity) {
            return back()->withErrors(['herb_quantity' => 'Quantité d\'herbe insuffisante en stock. Stock disponible: ' . $herbGlobalQuantity])->withInput();
        }

        // Create capsule stock movement
        CapsuleStockMovement::create([
            'capsule_id' => $capsule->id,
            'herb_id' => $request->herb_id,
            'herb_quantity' => $request->herb_quantity,
            'type' => 'usage',
            'quantity' => $request->quantity,
            'movement_date' => $request->movement_date,
            'notes' => $request->notes,
        ]);

        // Automatically create herb stock movement to deduct from herb stock
        HerbStockMovement::create([
            'herb_id' => $request->herb_id,
            'type' => 'usage',
            'quantity' => $request->herb_quantity,
            'movement_date' => $request->movement_date,
            'notes' => 'Utilisation via capsules: ' . $capsule->carton . ' (' . $request->quantity . ' cartons)',
        ]);

        return redirect()->route('stock-capsules.index')->with('success', 'Utilisation enregistrée avec succès. Stock d\'herbe déduit automatiquement.');
    }
}
