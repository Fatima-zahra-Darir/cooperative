@extends('layouts.app')

@section('title', 'Modifier Fournisseur - Co-op ERP')
@section('page-title', 'Modifier un Fournisseur')

@section('content')
<div style="max-width: 800px;">
    <div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #1f2937;">Modifier les informations du fournisseur</h2>
        
        <form action="{{ route('fornisseurs.update', $fornisseur->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1.5rem;">
                <label for="name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Nom <span style="color: #dc2626;">*</span></label>
                <input type="text" name="name" id="name" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;" placeholder="ex: Fournisseur ABC" value="{{ old('name', $fornisseur->name) }}">
                @error('name')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="phone_number" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Numéro de téléphone</label>
                <input type="text" name="phone_number" id="phone_number" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;" placeholder="ex: +33 6 12 34 56 78" value="{{ old('phone_number', $fornisseur->phone_number) }}">
                @error('phone_number')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 2rem;">
                <label for="ville" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Ville</label>
                <input type="text" name="ville" id="ville" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;" placeholder="ex: Paris" value="{{ old('ville', $fornisseur->ville) }}">
                @error('ville')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 2rem;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.75rem;">Spécialité</label>
                @php
                    $selectedSpecialites = $fornisseur->specialites->pluck('specialite')->toArray();
                    if (old('specialites')) {
                        $selectedSpecialites = old('specialites');
                    }
                    $specialitesOptions = [
                        ['value' => 'embalage', 'label' => 'Emballage', 'icon' => '📦'],
                        ['value' => 'capsule', 'label' => 'Capsule', 'icon' => '💊'],
                        ['value' => 'herb', 'label' => 'Herbe', 'icon' => '🌿'],
                    ];
                @endphp
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(140px, 1fr)); gap: 0.75rem;">
                    @foreach($specialitesOptions as $option)
                        <label style="display: flex; align-items: center; gap: 0.75rem; padding: 1rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; cursor: pointer; transition: all 0.3s ease; background-color: {{ in_array($option['value'], $selectedSpecialites) ? '#ecf5f1' : 'white' }}; border-color: {{ in_array($option['value'], $selectedSpecialites) ? '#2d7a52' : '#e5e7eb' }};" onchange="this.style.borderColor = this.querySelector('input').checked ? '#2d7a52' : '#e5e7eb'; this.style.backgroundColor = this.querySelector('input').checked ? '#ecf5f1' : 'white';">
                            <input type="checkbox" name="specialites[]" value="{{ $option['value'] }}" {{ in_array($option['value'], $selectedSpecialites) ? 'checked' : '' }} style="width: 18px; height: 18px; cursor: pointer; accent-color: #2d7a52;">
                            <span style="flex: 1; font-size: 0.875rem; color: #374151; font-weight: 500;">{{ $option['icon'] }} {{ $option['label'] }}</span>
                        </label>
                    @endforeach
                </div>
                @error('specialites')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
                @error('specialites.*')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.5rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; border-top: 1px solid #e5e7eb; padding-top: 1.5rem;">
                <button type="submit" style="background: #2d7a52; color: white; padding: 0.75rem 2rem; border-radius: 0.5rem; border: none; font-weight: 500; cursor: pointer;">
                    Mettre à jour le fournisseur
                </button>
                <a href="{{ route('fornisseurs.index') }}" style="background: white; color: #4b5563; padding: 0.75rem 2rem; border-radius: 0.5rem; border: 1px solid #d1d5db; text-decoration: none; font-weight: 500; text-align: center;">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

