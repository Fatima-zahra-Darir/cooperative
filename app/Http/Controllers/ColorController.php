<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ColorController extends Controller
{
    public function index()
    {
        $colors = \App\Models\Color::all();
        return view('colors.index', compact('colors'));
    }

    public function create()
    {
        return view('colors.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:colors']);
        \App\Models\Color::create($request->all());
        return redirect()->route('colors.index')->with('success', 'Couleur créée avec succès.');
    }

    public function show($id)
    {
        // Not needed for now
    }

    public function edit($id)
    {
        $color = \App\Models\Color::findOrFail($id);
        return view('colors.edit', compact('color'));
    }

    public function update(Request $request, $id)
    {
        $color = \App\Models\Color::findOrFail($id);
        $request->validate(['name' => 'required|string|max:255|unique:colors,name,'.$id]);
        $color->update($request->all());
        return redirect()->route('colors.index')->with('success', 'Couleur mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $color = \App\Models\Color::findOrFail($id);
        $color->delete();
        return redirect()->route('colors.index')->with('success', 'Couleur supprimée avec succès.');
    }
}
