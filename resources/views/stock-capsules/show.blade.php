@extends('layouts.app')

@section('title', 'Détails Stock Capsules vide - Co-op ERP')
@section('page-title', 'Détails Stock Capsules vide')

@section('content')
<div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">Détails du Stock Capsules vide</h2>
            <p style="color: #6b7280;">Informations complètes et historique des mouvements</p>
        </div>
        <a href="{{ route('stock-capsules.index') }}" style="background: #6b7280; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 500; transition: background 0.2s;">
            ← Retour
        </a>
    </div>

    <!-- Capsule Information -->
    <div style="background: #f9fafb; border-radius: 0.5rem; padding: 1.5rem; margin-bottom: 2rem;">
        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-bottom: 1.5rem;">Informations du Stock</h3>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem;">
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">Carton</label>
                <p style="font-size: 1rem; color: #1f2937; font-weight: 500;">{{ $capsule->carton }}</p>
            </div>
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">Quantité de Base</label>
                <p style="font-size: 1rem; color: #1f2937; font-weight: 500;">{{ $capsule->quantity }} cartons</p>
            </div>
            @php
                $globalQuantity = $capsule->global_quantity;
            @endphp
            <div>
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">Quantité Globale</label>
                <p style="font-size: 1rem; color: {{ $globalQuantity > 0 ? '#065f46' : '#991b1b' }}; font-weight: 600;">
                    <span style="background: {{ $globalQuantity > 0 ? '#ecfdf5' : '#fee2e2' }}; color: {{ $globalQuantity > 0 ? '#065f46' : '#991b1b' }}; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.875rem;">
                        {{ $globalQuantity }} cartons
                    </span>
                </p>
            </div>
            @if($capsule->notes)
            <div style="grid-column: 1 / -1;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 0.5rem;">Notes</label>
                <p style="font-size: 1rem; color: #1f2937;">{{ $capsule->notes }}</p>
            </div>
            @endif
        </div>
    </div>

    <!-- Movement History -->
    <div>
        <h3 style="font-size: 1.25rem; font-weight: 600; color: #1f2937; margin-bottom: 1.5rem;">Historique des Mouvements</h3>
        @if($capsule->movements->count() > 0)
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="border-bottom: 2px solid #e5e7eb; background: #f9fafb;">
                        <th style="padding: 1rem; color: #6b7280; font-weight: 500; text-align: left;">Type</th>
                        <th style="padding: 1rem; color: #6b7280; font-weight: 500; text-align: left;">Quantité</th>
                        <th style="padding: 1rem; color: #6b7280; font-weight: 500; text-align: left;">Herbe</th>
                        <th style="padding: 1rem; color: #6b7280; font-weight: 500; text-align: left;">Date</th>
                        <th style="padding: 1rem; color: #6b7280; font-weight: 500; text-align: left;">Notes</th>
                        <th style="padding: 1rem; color: #6b7280; font-weight: 500; text-align: left;">Date d'enregistrement</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($capsule->movements as $movement)
                    <tr style="border-bottom: 1px solid #f3f4f6;">
                        <td style="padding: 1rem;">
                            @if($movement->type == 'restock')
                                <span style="background: #dbeafe; color: #1e40af; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.875rem; font-weight: 500;">
                                    Réapprovisionnement
                                </span>
                            @else
                                <span style="background: #fef3c7; color: #92400e; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.875rem; font-weight: 500;">
                                    Utilisation
                                </span>
                            @endif
                        </td>
                        <td style="padding: 1rem; color: #1f2937; font-weight: 500;">
                            {{ $movement->quantity }} cartons
                        </td>
                        <td style="padding: 1rem; color: #4b5563;">
                            @if($movement->type == 'usage' && $movement->herb)
                                <div>
                                    <strong>{{ $movement->herb->name }}</strong>
                                    @if($movement->herb_quantity)
                                        <br>
                                        <small style="color: #6b7280;">Quantité: {{ number_format($movement->herb_quantity, 2) }}</small>
                                    @endif
                                </div>
                            @else
                                <span style="color: #9ca3af;">-</span>
                            @endif
                        </td>
                        <td style="padding: 1rem; color: #4b5563;">
                            {{ $movement->movement_date->format('d/m/Y') }}
                        </td>
                        <td style="padding: 1rem; color: #4b5563;">
                            {{ $movement->notes ?? '-' }}
                        </td>
                        <td style="padding: 1rem; color: #9ca3af; font-size: 0.875rem;">
                            {{ $movement->created_at->format('d/m/Y H:i') }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div style="background: #f9fafb; border-radius: 0.5rem; padding: 2rem; text-align: center; color: #9ca3af;">
            <p>Aucun mouvement enregistré pour ce stock.</p>
        </div>
        @endif
    </div>
</div>
@endsection

