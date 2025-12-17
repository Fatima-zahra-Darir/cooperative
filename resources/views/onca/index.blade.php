@extends('layouts.app')

@section('title', 'Gestion des documents ONCA - Co-op ERP')
@section('page-title', 'Gestion des documents ONCA')

@push('styles')
<style>
    .onca-container {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        border: 1px solid #e5e7eb;
        overflow: hidden;
    }
    
    .onca-header {
        padding: 1.25rem 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .onca-header-content {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    
    @media (min-width: 640px) {
        .onca-header-content {
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
        }
    }
    
    .onca-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.25rem;
    }
    
    .onca-subtitle {
        font-size: 0.875rem;
        color: #4b5563;
    }
    
    .onca-btn-new {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #16a34a;
        color: white;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.2s;
    }
    
    .onca-btn-new:hover {
        background: #15803d;
    }
    
    .onca-table-wrapper {
        overflow-x: auto;
    }
    
    .onca-table {
        width: 100%;
    }
    
    .onca-table thead {
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .onca-table th {
        padding: 0.75rem 1.5rem;
        text-align: left;
        font-size: 0.75rem;
        font-weight: 600;
        color: #6b7280;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    
    .onca-table th:last-child {
        text-align: right;
    }
    
    .onca-table-header-content {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .onca-table tbody {
        background: white;
    }
    
    .onca-table tbody tr {
        border-bottom: 1px solid #f3f4f6;
        transition: background 0.15s;
    }
    
    .onca-table tbody tr:hover {
        background: #f9fafb;
    }
    
    .onca-table td {
        padding: 1rem 1.5rem;
        white-space: nowrap;
    }
    
    .onca-table td:last-child {
        text-align: right;
    }
    
    .type-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.375rem 0.75rem;
        border-radius: 0.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }
    .type-health { background: #dbeafe; color: #1e40af; }
    .type-pest { background: #fef3c7; color: #92400e; }
    .type-cleaning { background: #d1fae5; color: #065f46; }
    .type-batch { background: #e9d5ff; color: #6b21a8; }
    .type-storage { background: #fed7aa; color: #9a3412; }
    
    .onca-reference {
        display: inline-flex;
        align-items: center;
        padding: 0.25rem 0.75rem;
        border-radius: 0.375rem;
        background: #f3f4f6;
        color: #1f2937;
        font-size: 0.875rem;
        font-family: monospace;
        font-weight: 500;
    }
    
    .onca-title-cell {
        font-size: 0.875rem;
        font-weight: 500;
        color: #111827;
    }
    
    .onca-version {
        font-size: 0.75rem;
        color: #6b7280;
        margin-top: 0.25rem;
    }
    
    .onca-responsible {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }
    
    .onca-avatar {
        width: 2rem;
        height: 2rem;
        border-radius: 50%;
        background: linear-gradient(135deg, #4ade80 0%, #16a34a 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 0.75rem;
        font-weight: 600;
    }
    
    .onca-responsible-name {
        font-size: 0.875rem;
        color: #111827;
    }
    
    .onca-date {
        font-size: 0.875rem;
        font-weight: 500;
        color: #111827;
    }
    
    .onca-date-relative {
        font-size: 0.75rem;
        color: #6b7280;
    }
    
    .onca-actions {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 0.5rem;
    }
    
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        border-radius: 0.5rem;
        transition: all 0.2s;
        cursor: pointer;
        border: none;
        text-decoration: none;
    }
    .action-btn:hover {
        transform: translateY(-1px);
    }
    .action-edit {
        background: #eef2ff;
        color: #4f46e5;
    }
    .action-edit:hover {
        background: #4f46e5;
        color: white;
    }
    .action-print {
        background: #f0f9ff;
        color: #0284c7;
    }
    .action-print:hover {
        background: #0284c7;
        color: white;
    }
    .action-delete {
        background: #fef2f2;
        color: #dc2626;
    }
    .action-delete:hover {
        background: #dc2626;
        color: white;
    }
    
    .onca-empty {
        padding: 4rem 1.5rem;
        text-align: center;
    }
    
    .onca-empty-icon {
        width: 4rem;
        height: 4rem;
        color: #d1d5db;
        margin: 0 auto 1rem;
    }
    
    .onca-empty-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 0.5rem;
    }
    
    .onca-empty-text {
        font-size: 0.875rem;
        color: #6b7280;
        margin-bottom: 1rem;
    }
    
    .onca-btn-create {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.5rem 1rem;
        background: #16a34a;
        color: white;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.2s;
    }
    
    .onca-btn-create:hover {
        background: #15803d;
    }
    
    .onca-success {
        margin: 1rem 1.5rem;
        padding: 1rem;
        background: #dcfce7;
        color: #166534;
        border-radius: 0.5rem;
    }
</style>
@endpush

@section('content')
<div class="onca-container">
    <!-- Header Section -->
    <div class="onca-header">
        <div class="onca-header-content">
            <div>
                <h2 class="onca-title">Documents ONCA</h2>
                <p class="onca-subtitle">Gérez tous vos documents de conformité ONCA</p>
            </div>
            <a href="{{ route('onca.create') }}" class="onca-btn-new">
                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Nouveau Document
            </a>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="onca-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Table Section -->
    <div class="onca-table-wrapper">
        <table class="onca-table">
            <thead>
                <tr>
                    <th>
                        <div class="onca-table-header-content">
                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Type
                        </div>
                    </th>
                    <th>
                        <div class="onca-table-header-content">
                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Référence
                        </div>
                    </th>
                    <th>Titre</th>
                    <th>
                        <div class="onca-table-header-content">
                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            Responsable
                        </div>
                    </th>
                    <th>
                        <div class="onca-table-header-content">
                            <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Date
                        </div>
                    </th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($documents as $doc)
                <tr>
                    <td>
                        @php
                            $typeClasses = [
                                'health' => 'type-health',
                                'pest' => 'type-pest',
                                'cleaning' => 'type-cleaning',
                                'batch' => 'type-batch',
                                'storage' => 'type-storage',
                            ];
                            $typeLabels = [
                                'health' => 'Santé',
                                'pest' => 'Ravageurs',
                                'cleaning' => 'Nettoyage',
                                'batch' => 'Lot',
                                'storage' => 'Stockage',
                            ];
                            $typeClass = $typeClasses[$doc->type] ?? 'type-health';
                            $typeLabel = $typeLabels[$doc->type] ?? ucfirst($doc->type);
                        @endphp
                        <span class="type-badge {{ $typeClass }}">
                            {{ $typeLabel }}
                        </span>
                    </td>
                    <td>
                        <span class="onca-reference">{{ $doc->reference }}</span>
                    </td>
                    <td style="white-space: normal;">
                        <div class="onca-title-cell">{{ $doc->title }}</div>
                        @if($doc->version)
                        <div class="onca-version">Version {{ $doc->version }}</div>
                        @endif
                    </td>
                    <td>
                        <div class="onca-responsible">
                            <div class="onca-avatar">
                                {{ strtoupper(substr($doc->responsible ?? 'N', 0, 1)) }}
                            </div>
                            <span class="onca-responsible-name">{{ $doc->responsible ?? 'Non assigné' }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="onca-date">{{ $doc->date->format('d/m/Y') }}</div>
                        <div class="onca-date-relative">{{ $doc->date->diffForHumans() }}</div>
                    </td>
                    <td>
                        <div class="onca-actions">
                            <a href="{{ route('onca.edit', $doc) }}" class="action-btn action-edit" title="Éditer">
                                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <a href="{{ route('onca.print', $doc) }}" target="_blank" class="action-btn action-print" title="Imprimer">
                                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('onca.destroy', $doc) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce document ?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn action-delete" title="Supprimer">
                                    <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="onca-empty">
                        <svg class="onca-empty-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <h3 class="onca-empty-title">Aucun document</h3>
                        <p class="onca-empty-text">Il n'y a pas encore de documents ici. Commencez par créer votre premier document ONCA.</p>
                        <a href="{{ route('onca.create') }}" class="onca-btn-create">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            Créer un document
                        </a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
