<?php

namespace App\Http\Controllers;

use App\Models\Fornisseur;
use Illuminate\Http\Request;

class FornisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fornisseurs = Fornisseur::latest()->get();
        return view('fornisseurs.index', compact('fornisseurs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('fornisseurs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
        ]);

        Fornisseur::create($request->all());

        return redirect()->route('fornisseurs.index')->with('success', 'Fournisseur créé avec succès.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Fornisseur $fornisseur)
    {
        return view('fornisseurs.edit', compact('fornisseur'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Fornisseur $fornisseur)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:255',
            'ville' => 'nullable|string|max:255',
        ]);

        $fornisseur->update($request->all());

        return redirect()->route('fornisseurs.index')->with('success', 'Fournisseur mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Fornisseur $fornisseur)
    {
        $fornisseur->delete();

        return redirect()->route('fornisseurs.index')->with('success', 'Fournisseur supprimé avec succès.');
    }
}
