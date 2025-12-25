@extends('layouts.app')

@section('title', 'Détails Stock Capsules remplie - Co-op ERP')
@section('page-title', 'Détails Stock Capsules remplie')

@section('content')
<div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">Détails du Stock Capsules remplie</h2>
            <p style="color: #6b7280;">Informations complètes sur les capsules remplies</p>
        </div>
        <a href="{{ route('stock-capsules-remplie.index') }}" style="background: #6b7280; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 500; transition: background 0.2s;">
            ← Retour
        </a>
    </div>

    <!-- Filled Capsule Information -->
    <div style="background: #f9fafb; border-radius: 0.5rem; padding: 1.5rem; margin-bottom: 2rem;">
        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-bottom: 1.5rem;">Informations du Stock Rempli</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">Carton d'origine</label>
                <p style="font-size: 1rem; color: #1f2937; font-weight: 500;">{{ $filledCapsule->capsule->carton }}</p>
                <a href="{{ route('stock-capsules.show', $filledCapsule->capsule->id) }}" style="color: #2d7a52; font-size: 0.875rem; text-decoration: none; margin-top: 0.25rem; display: inline-block;">
                    Voir le stock vide →
                </a>
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">Herbe utilisée</label>
                <p style="font-size: 1rem; color: #1f2937; font-weight: 500;">{{ $filledCapsule->herb->name }}</p>
                @if($filledCapsule->herb->source)
                    <p style="font-size: 0.875rem; color: #6b7280; margin-top: 0.25rem;">Source: {{ $filledCapsule->herb->source }}</p>
                @endif
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">Quantité de cartons remplis</label>
                <p style="font-size: 1rem; color: #1f2937; font-weight: 600;">
                    <span style="background: #ecfdf5; color: #065f46; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.875rem;">
                        {{ $filledCapsule->quantity }} cartons
                    </span>
                </p>
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">Quantité d'herbe utilisée</label>
                <p style="font-size: 1rem; color: #1f2937; font-weight: 500;">{{ number_format($filledCapsule->herb_quantity, 2) }}</p>
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">Date de remplissage</label>
                <p style="font-size: 1rem; color: #1f2937; font-weight: 500;">{{ $filledCapsule->filled_date->format('d/m/Y') }}</p>
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">Date d'enregistrement</label>
                <p style="font-size: 1rem; color: #1f2937; font-weight: 500;">{{ $filledCapsule->created_at->format('d/m/Y H:i') }}</p>
            </div>
            @if($filledCapsule->notes)
            <div style="grid-column: 1 / -1;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">Notes</label>
                <p style="font-size: 1rem; color: #1f2937;">{{ $filledCapsule->notes }}</p>
            </div>
            @endif
            @if($filledCapsule->capsuleMovement)
            <div style="grid-column: 1 / -1;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">Mouvement d'origine</label>
                <p style="font-size: 0.875rem; color: #6b7280;">
                    Créé à partir du mouvement du {{ $filledCapsule->capsuleMovement->movement_date->format('d/m/Y') }}
                    @if($filledCapsule->capsuleMovement->notes)
                        - {{ $filledCapsule->capsuleMovement->notes }}
                    @endif
                </p>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

