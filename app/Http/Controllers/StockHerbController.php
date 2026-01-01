<?php

namespace App\Http\Controllers;

use App\Models\Herb;
use App\Models\HerbStockMovement;
use App\Models\Fornisseur;
use Illuminate\Http\Request;

class StockHerbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $herbs = Herb::with(['movements.fornisseur'])->get();
        $fornisseurs = Fornisseur::whereHas('specialites', function ($query) {
            $query->where('specialite', 'herb');
        })->get();
        return view('stock-herb.index', compact('herbs', 'fornisseurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $herbs = Herb::all();
        $fornisseurs = Fornisseur::whereHas('specialites', function ($query) {
            $query->where('specialite', 'herb');
        })->get();
        return view('stock-herb.create', compact('herbs', 'fornisseurs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'herb_id' => 'required|exists:herbs,id',
            'fornisseur_id' => 'nullable|exists:fornisseurs,id',
            'quantity' => 'required|integer|min:1',
            'movement_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        HerbStockMovement::create([
            'herb_id' => $request->herb_id,
            'fornisseur_id' => $request->fornisseur_id,
            'type' => 'entry',
            'quantity' => $request->quantity,
            'movement_date' => $request->movement_date,
            'notes' => $request->notes,
        ]);

        return redirect()->route('stock-herb.index')->with('success', 'Entrée de stock enregistrée avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $herb = Herb::with(['movements' => function($query) {
            $query->with('fornisseur')->orderBy('movement_date', 'desc')->orderBy('created_at', 'desc');
        }])->findOrFail($id);
        return view('stock-herb.show', compact('herb'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Not used for stock entries
        abort(404);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Not used for stock entries
        abort(404);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Not used for stock entries
        abort(404);
    }
}

