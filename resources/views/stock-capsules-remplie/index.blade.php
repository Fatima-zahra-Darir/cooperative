@extends('layouts.app')

@section('title', 'Stock Capsules remplie - Co-op ERP')
@section('page-title', 'Stock Capsules remplie')

@push('styles')
<style>
    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0.375rem;
        border-radius: 0.25rem;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        position: relative;
    }

    .btn-icon svg {
        width: 18px;
        height: 18px;
    }

    .btn-icon-view {
        background: #2d7a52;
        color: white;
    }

    .btn-icon-view:hover {
        background: #256349;
    }

    .tooltip {
        position: relative;
    }

    .tooltip::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        margin-bottom: 5px;
        padding: 0.375rem 0.75rem;
        background: #1f2937;
        color: white;
        font-size: 0.75rem;
        border-radius: 0.25rem;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s;
        z-index: 1000;
    }

    .tooltip:hover::after {
        opacity: 1;
    }
</style>
@endpush

@section('content')
<div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">Stock Capsules remplie</h2>
            <p style="color: #6b7280;">Gestion du stock des capsules remplies par rangée (1 rangée = 420 capsules).</p>
        </div>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid #e5e7eb; text-align: left;">
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Carton d'origine</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Herbe utilisée</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Quantité de rangées remplies</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Quantité de capsules utilisée</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Date de remplissage</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Notes</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($filledCapsules as $filledCapsule)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 1rem; color: #1f2937; font-weight: 500;">{{ $filledCapsule->capsule->carton }}</td>
                    <td style="padding: 1rem; color: #4b5563;">
                        <span style="font-weight: 500;">{{ $filledCapsule->herb->name }}</span>
                        @if($filledCapsule->herb->source)
                            <br>
                            <small style="color: #6b7280;">Source: {{ $filledCapsule->herb->source }}</small>
                        @endif
                    </td>
                    <td style="padding: 1rem; color: #4b5563;">
                        <span style="background: #ecfdf5; color: #065f46; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.875rem; font-weight: 600;">
                            {{ $filledCapsule->quantity }} rangées
                        </span>
                    </td>
                    <td style="padding: 1rem; color: #4b5563;">
                        <span style="background: #dbeafe; color: #1e40af; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.875rem; font-weight: 600;">
                            {{ number_format($filledCapsule->capsules_used, 0) }} capsules
                        </span>
                    </td>
                    <td style="padding: 1rem; color: #4b5563;">{{ $filledCapsule->filled_date->format('d/m/Y') }}</td>
                    <td style="padding: 1rem; color: #4b5563;">{{ $filledCapsule->notes ?? '-' }}</td>
                    <td style="padding: 1rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <a href="{{ route('stock-capsules-remplie.show', $filledCapsule->id) }}" class="btn-icon btn-icon-view tooltip" data-tooltip="Voir">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 2rem; text-align: center; color: #9ca3af;">Aucune capsule remplie trouvée. Les capsules remplies apparaîtront ici après utilisation des capsules vides.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

