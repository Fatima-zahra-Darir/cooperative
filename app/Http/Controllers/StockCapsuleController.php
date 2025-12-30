<?php

namespace App\Http\Controllers;

use App\Models\Capsule;
use App\Models\CapsuleStockMovement;
use App\Models\FilledCapsule;
use App\Models\Fornisseur;
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
        $fornisseurs = Fornisseur::where('specialite', 'capsule')->get();
        return view('stock-capsules.index', compact('capsules', 'herbs', 'fornisseurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fornisseurs = Fornisseur::where('specialite', 'capsule')->get();
        return view('stock-capsules.create', compact('fornisseurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'carton' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'fornisseur_id' => 'nullable|exists:fornisseurs,id',
            'notes' => 'nullable|string',
        ]);

        // Calculate nombre_capsules: quantity * 125000 (1 carton = 125,000 capsules)
        $nombreCapsules = $request->quantity * 125000;

        // Create capsule with quantity and nombre_capsules
        $capsule = Capsule::create([
            'carton' => $request->carton,
            'quantity' => $request->quantity,
            'nombre_capsules' => $nombreCapsules,
            'notes' => $request->notes,
        ]);

        // Create initial movement if quantity > 0
        if ($request->quantity > 0) {
            CapsuleStockMovement::create([
                'capsule_id' => $capsule->id,
                'fornisseur_id' => $request->fornisseur_id,
                'type' => 'restock',
                'quantity' => $request->quantity,
                'movement_date' => now(),
                'notes' => 'Stock initial',
            ]);
        }

        return redirect()->route('stock-capsules.index')->with('success', 'Stock capsule créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $capsule = Capsule::with(['movements' => function($query) {
            $query->with(['herb', 'fornisseur'])->orderBy('movement_date', 'desc')->orderBy('created_at', 'desc');
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
            'notes' => 'nullable|string',
        ]);

        // Only update carton and notes, not quantity (quantity is managed via movements)
        $capsule->update($request->only(['carton', 'notes']));

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
            'fornisseur_id' => 'nullable|exists:fornisseurs,id',
            'movement_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        // Add cartons to stock and update nombre_capsules
        $capsule->quantity += $request->quantity;
        $capsule->nombre_capsules += ($request->quantity * 125000);
        $capsule->save();

        // Create restock movement record
        CapsuleStockMovement::create([
            'capsule_id' => $capsule->id,
            'fornisseur_id' => $request->fornisseur_id,
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

        // quantity is now in RANGES (1 range = 420 capsules)
        $rangeCount = $request->quantity;
        $capsulesUsed = $rangeCount * 420;

        // Check if there's enough capsule stock
        if ($capsule->nombre_capsules < $capsulesUsed) {
            return back()->withErrors(['quantity' => 'Quantité insuffisante en stock. Capsules disponibles: ' . $capsule->nombre_capsules . ' (' . floor($capsule->nombre_capsules / 420) . ' rangées)'])->withInput();
        }

        // Check if there's enough herb stock
        $herb = Herb::findOrFail($request->herb_id);
        $herbGlobalQuantity = $herb->global_quantity;
        if ($request->herb_quantity > $herbGlobalQuantity) {
            return back()->withErrors(['herb_quantity' => 'Quantité d\'herbe insuffisante en stock. Stock disponible: ' . $herbGlobalQuantity])->withInput();
        }

        // Decrease nombre_capsules based on used ranges
        $capsule->nombre_capsules -= $capsulesUsed;
        
        // Recalculate remaining cartons: nombre_cartons = floor(nombre_capsules / 125000)
        $capsule->quantity = intval(floor($capsule->nombre_capsules / 125000));
        $capsule->save();

        // Create capsule stock movement
        $capsuleMovement = CapsuleStockMovement::create([
            'capsule_id' => $capsule->id,
            'herb_id' => $request->herb_id,
            'herb_quantity' => $request->herb_quantity,
            'type' => 'usage',
            'quantity' => $rangeCount, // Store as ranges
            'movement_date' => $request->movement_date,
            'notes' => $request->notes,
        ]);

        // Automatically create herb stock movement to deduct from herb stock
        HerbStockMovement::create([
            'herb_id' => $request->herb_id,
            'type' => 'usage',
            'quantity' => $request->herb_quantity,
            'movement_date' => $request->movement_date,
            'notes' => 'Utilisation via capsules: ' . $capsule->carton . ' (' . $rangeCount . ' rangées = ' . $capsulesUsed . ' capsules)',
        ]);

        // Create filled capsule record
        FilledCapsule::create([
            'capsule_id' => $capsule->id,
            'herb_id' => $request->herb_id,
            'quantity' => $rangeCount, // Store as ranges
            'herb_quantity' => $request->herb_quantity,
            'filled_date' => $request->movement_date,
            'capsule_movement_id' => $capsuleMovement->id,
            'notes' => $request->notes,
        ]);

        return redirect()->route('stock-capsules.index')->with('success', 'Utilisation enregistrée avec succès. Stock d\'herbe déduit automatiquement. Capsules remplies ajoutées au stock rempli.');
    }
}
