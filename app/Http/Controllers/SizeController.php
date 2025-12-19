<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SizeController extends Controller
{
    public function index()
    {
        $sizes = \App\Models\Size::all();
        return view('sizes.index', compact('sizes'));
    }

    public function create()
    {
        return view('sizes.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255|unique:sizes']);
        \App\Models\Size::create($request->all());
        return redirect()->route('sizes.index')->with('success', 'Taille créée avec succès.');
    }

    public function show($id)
    {
        // Not needed for now
    }

    public function edit($id)
    {
        $size = \App\Models\Size::findOrFail($id);
        return view('sizes.edit', compact('size'));
    }

    public function update(Request $request, $id)
    {
        $size = \App\Models\Size::findOrFail($id);
        $request->validate(['name' => 'required|string|max:255|unique:sizes,name,'.$id]);
        $size->update($request->all());
        return redirect()->route('sizes.index')->with('success', 'Taille mise à jour avec succès.');
    }

    public function destroy($id)
    {
        $size = \App\Models\Size::findOrFail($id);
        $size->delete();
        return redirect()->route('sizes.index')->with('success', 'Taille supprimée avec succès.');
    }
}
