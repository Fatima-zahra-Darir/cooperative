@extends('layouts.app')

@section('title', 'Stock Produit - Co-op ERP')
@section('page-title', 'Stock Produit')

@section('content')
<div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">Stock Produit</h2>
            <p style="color: #6b7280;">Gestion du stock pour les produits existants.</p>
        </div>
        <a href="{{ route('stock-produit.create') }}" style="background: #2d7a52; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 500; transition: background 0.2s;">
            + Ajouter Stock
        </a>
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
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Produit</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Quantité</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Notes</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stocks as $stock)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 1rem; color: #1f2937; font-weight: 500;">{{ $stock->product->name }}</td>
                    <td style="padding: 1rem; color: #4b5563;">
                        <span style="background: {{ $stock->quantity > 0 ? '#ecfdf5' : '#fee2e2' }}; color: {{ $stock->quantity > 0 ? '#065f46' : '#991b1b' }}; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.875rem; font-weight: 600;">
                            {{ $stock->quantity }} unités
                        </span>
                    </td>
                    <td style="padding: 1rem; color: #4b5563;">{{ $stock->notes ?? '-' }}</td>
                    <td style="padding: 1rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <a href="{{ route('stock-produit.edit', $stock->id) }}" style="color: #4b5563; text-decoration: none; font-size: 0.875rem; padding: 0.25rem 0.5rem; border: 1px solid #e5e7eb; border-radius: 0.25rem;">Modifier</a>
                            <form action="{{ route('stock-produit.destroy', $stock->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #dc2626; background: none; border: 1px solid #fee2e2; border-radius: 0.25rem; font-size: 0.875rem; padding: 0.25rem 0.5rem; cursor: pointer;">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 2rem; text-align: center; color: #9ca3af;">Aucun stock produit trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

