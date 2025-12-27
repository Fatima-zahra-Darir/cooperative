@extends('layouts.app')

@section('title', 'Fournisseurs - Co-op ERP')
@section('page-title', 'Fournisseurs')

@section('content')
<div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">Fournisseurs</h2>
            <p style="color: #6b7280;">Gestion de vos fournisseurs.</p>
        </div>
        <a href="{{ route('fornisseurs.create') }}" style="background: #2d7a52; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 500; transition: background 0.2s;">
            + Nouveau Fournisseur
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
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Nom</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Téléphone</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Ville</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Spécialité</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($fornisseurs as $fornisseur)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 1rem; color: #1f2937; font-weight: 500;">{{ $fornisseur->name }}</td>
                    <td style="padding: 1rem; color: #4b5563;">{{ $fornisseur->phone_number ?? '-' }}</td>
                    <td style="padding: 1rem; color: #4b5563;">{{ $fornisseur->ville ?? '-' }}</td>
                    <td style="padding: 1rem; color: #4b5563;">{{ $fornisseur->specialite ?? '-' }}</td>
                    <td style="padding: 1rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <a href="{{ route('fornisseurs.edit', $fornisseur->id) }}" style="color: #4b5563; text-decoration: none; font-size: 0.875rem; padding: 0.25rem 0.5rem; border: 1px solid #e5e7eb; border-radius: 0.25rem;">Modifier</a>
                            <form action="{{ route('fornisseurs.destroy', $fornisseur->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #dc2626; background: none; border: 1px solid #fee2e2; border-radius: 0.25rem; font-size: 0.875rem; padding: 0.25rem 0.5rem; cursor: pointer;">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 2rem; text-align: center; color: #9ca3af;">Aucun fournisseur trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

