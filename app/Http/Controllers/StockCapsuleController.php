<?php

namespace App\Http\Controllers;

use App\Models\Capsule;
use Illuminate\Http\Request;

class StockCapsuleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $capsules = Capsule::all();
        return view('stock-capsules.index', compact('capsules'));
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
        $capsule = Capsule::findOrFail($id);
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
}
