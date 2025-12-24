@extends('layouts.app')

@section('title', 'Stock Herb - Co-op ERP')
@section('page-title', 'Stock Herb')

@section('content')
<div style="background: white; border-radius: 0.5rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">Stock des Herbs</h2>
        <a href="{{ route('stock-herb.create') }}" style="background: #2d7a52; color: white; padding: 0.5rem 1rem; border-radius: 0.5rem; text-decoration: none; font-size: 0.875rem; font-weight: 500;">
            + Nouvelle entrée
        </a>
    </div>

    @if(session('success'))
        <div style="background: #d1fae5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    @if($herbs->count() > 0)
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f9fafb; border-bottom: 2px solid #e5e7eb;">
                    <th style="padding: 0.75rem; text-align: left; font-weight: 600; color: #374151;">Nom</th>
                    <th style="padding: 0.75rem; text-align: left; font-weight: 600; color: #374151;">Source</th>
                    <th style="padding: 0.75rem; text-align: right; font-weight: 600; color: #374151;">Stock disponible</th>
                    <th style="padding: 0.75rem; text-align: right; font-weight: 600; color: #374151;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($herbs as $herb)
                    @php
                        $stock = $herb->global_quantity;
                    @endphp
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 0.75rem; color: #1f2937; font-weight: 500;">{{ $herb->name }}</td>
                        <td style="padding: 0.75rem; color: #6b7280;">{{ $herb->source }}</td>
                        <td style="padding: 0.75rem; text-align: right;">
                            <span style="background: {{ $stock > 0 ? '#ecfdf5' : '#fee2e2' }}; color: {{ $stock > 0 ? '#065f46' : '#991b1b' }}; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.875rem; font-weight: 600;">
                                {{ $stock }}
                            </span>
                        </td>
                        <td style="padding: 0.75rem; text-align: right;">
                            <a href="{{ route('stock-herb.show', $herb->id) }}" style="color: #2d7a52; text-decoration: none; font-size: 0.875rem;">Voir détails</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div style="text-align: center; padding: 3rem; color: #6b7280;">
            <p>Aucun herb enregistré pour le moment.</p>
            <p style="margin-top: 0.5rem; font-size: 0.875rem;">Veuillez d'abord créer des herbs dans la section "Gestion Herb".</p>
        </div>
    @endif
</div>
@endsection

