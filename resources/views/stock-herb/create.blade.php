@extends('layouts.app')

@section('title', 'Ajouter Entrée Stock Herb - Co-op ERP')
@section('page-title', 'Ajouter Entrée Stock Herb')

@section('content')
<div style="max-width: 600px;">
    <div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #1f2937;">Nouvelle entrée de stock</h2>
        
        <form action="{{ route('stock-herb.store') }}" method="POST">
            @csrf
            <div style="margin-bottom: 1.5rem;">
                <label for="herb_id" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Herb</label>
                <select name="herb_id" id="herb_id" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none; transition: border-color 0.2s;">
                    <option value="">Sélectionner un herb</option>
                    @foreach($herbs as $herb)
                        <option value="{{ $herb->id }}" {{ old('herb_id') == $herb->id ? 'selected' : '' }}>
                            {{ $herb->name }} ({{ $herb->source }})
                        </option>
                    @endforeach
                </select>
                @error('herb_id')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="quantity" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Quantité</label>
                <input type="number" name="quantity" id="quantity" required min="1" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none; transition: border-color 0.2s;" placeholder="0" value="{{ old('quantity') }}">
                @error('quantity')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="movement_date" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Date d'entrée</label>
                <input type="date" name="movement_date" id="movement_date" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none; transition: border-color 0.2s;" value="{{ old('movement_date', date('Y-m-d')) }}">
                @error('movement_date')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="notes" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Notes (optionnel)</label>
                <textarea name="notes" id="notes" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none; resize: vertical;">{{ old('notes') }}</textarea>
                @error('notes')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; border-top: 1px solid #e5e7eb; padding-top: 1.5rem;">
                <button type="submit" style="background: #2d7a52; color: white; padding: 0.75rem 2rem; border-radius: 0.5rem; border: none; font-weight: 500; cursor: pointer; transition: background 0.2s;">
                    Enregistrer l'entrée
                </button>
                <a href="{{ route('stock-herb.index') }}" style="background: white; color: #4b5563; padding: 0.75rem 2rem; border-radius: 0.5rem; border: 1px solid #d1d5db; text-decoration: none; font-weight: 500; text-align: center;">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

