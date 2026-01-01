<?php

namespace App\Http\Controllers;

use App\Models\Fornisseur;
use App\Models\FornisseurSpecialite;
use Illuminate\Http\Request;

class FornisseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Fornisseur::with('specialites');

        // Search by name, phone, ville, or specialite
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('phone_number', 'like', '%' . $search . '%')
                  ->orWhere('ville', 'like', '%' . $search . '%')
                  ->orWhereHas('specialites', function ($subQ) use ($search) {
                      $subQ->where('specialite', 'like', '%' . $search . '%');
                  });
            });
        }

        $fornisseurs = $query->latest()->get();
        $search = $request->search ?? '';
        
        return view('fornisseurs.index', compact('fornisseurs', 'search'));
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
            'specialites' => 'nullable|array',
            'specialites.*' => 'string|in:embalage,capsule,herb',
        ]);

        $fornisseur = Fornisseur::create($request->only('name', 'phone_number', 'ville'));

        // Save specialites
        if ($request->has('specialites') && is_array($request->input('specialites'))) {
            foreach ($request->input('specialites') as $specialite) {
                FornisseurSpecialite::create([
                    'fornisseur_id' => $fornisseur->id,
                    'specialite' => $specialite,
                ]);
            }
        }

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
        $fornisseur->load('specialites');
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
            'specialites' => 'nullable|array',
            'specialites.*' => 'string|in:embalage,capsule,herb',
        ]);

        $fornisseur->update($request->only('name', 'phone_number', 'ville'));

        // Delete existing specialites
        FornisseurSpecialite::where('fornisseur_id', $fornisseur->id)->delete();

        // Save new specialites
        if ($request->has('specialites') && is_array($request->input('specialites'))) {
            foreach ($request->input('specialites') as $specialite) {
                FornisseurSpecialite::create([
                    'fornisseur_id' => $fornisseur->id,
                    'specialite' => $specialite,
                ]);
            }
        }

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
