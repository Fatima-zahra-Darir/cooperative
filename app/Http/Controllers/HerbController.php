<?php

namespace App\Http\Controllers;

use App\Models\Herb;
use Illuminate\Http\Request;

class HerbController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $herbs = Herb::all();
        return view('herbs.index', compact('herbs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('herbs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'source' => 'required|string|max:255',
        ]);

        Herb::create($request->only(['name', 'source']));

        return redirect()->route('herbs.index')->with('success', 'Herb créé avec succès.');
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
    public function edit(string $id)
    {
        $herb = Herb::findOrFail($id);
        return view('herbs.edit', compact('herb'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $herb = Herb::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'source' => 'required|string|max:255',
        ]);

        $herb->update($request->only(['name', 'source']));

        return redirect()->route('herbs.index')->with('success', 'Herb mis à jour avec succès.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $herb = Herb::findOrFail($id);
        $herb->delete();
        return redirect()->route('herbs.index')->with('success', 'Herb supprimé avec succès.');
    }
}
