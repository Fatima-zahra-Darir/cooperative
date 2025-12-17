@extends('layouts.app')

@section('title', 'Nouveau Document ONCA')
@section('page-title', 'Nouveau Document ONCA')

@push('styles')
<style>
    .onca-create-container {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        max-width: 56rem;
        margin: 0 auto;
    }
    
    .onca-create-header {
        margin-bottom: 1.5rem;
    }
    
    .onca-back-link {
        color: #4f46e5;
        text-decoration: none;
        display: flex;
        align-items: center;
        transition: color 0.2s;
    }
    
    .onca-back-link:hover {
        color: #4338ca;
    }
    
    .onca-back-icon {
        width: 1rem;
        height: 1rem;
        margin-right: 0.25rem;
    }
    
    .onca-create-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
        margin-top: 1rem;
    }
    
    .onca-doc-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    @media (min-width: 768px) {
        .onca-doc-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    .onca-doc-card {
        display: block;
        padding: 1.5rem;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        text-decoration: none;
        transition: all 0.2s;
    }
    
    .onca-doc-card:hover {
        border-color: #16a34a;
        background: #f0fdf4;
    }
    
    .onca-doc-content {
        display: flex;
        align-items: flex-start;
    }
    
    .onca-doc-icon-wrapper {
        flex-shrink: 0;
        padding: 0.75rem;
        border-radius: 0.375rem;
        font-size: 1.5rem;
    }
    
    .onca-doc-icon-health {
        background: #dcfce7;
    }
    
    .onca-doc-card:hover .onca-doc-icon-health {
        background: #bbf7d0;
    }
    
    .onca-doc-icon-pest {
        background: #fee2e2;
    }
    
    .onca-doc-card:hover .onca-doc-icon-pest {
        background: #fecaca;
    }
    
    .onca-doc-icon-cleaning {
        background: #dbeafe;
    }
    
    .onca-doc-card:hover .onca-doc-icon-cleaning {
        background: #bfdbfe;
    }
    
    .onca-doc-icon-batch {
        background: #fef3c7;
    }
    
    .onca-doc-card:hover .onca-doc-icon-batch {
        background: #fde68a;
    }
    
    .onca-doc-icon-storage {
        background: #e9d5ff;
    }
    
    .onca-doc-card:hover .onca-doc-icon-storage {
        background: #ddd6fe;
    }
    
    .onca-doc-info {
        margin-left: 1rem;
        flex: 1;
    }
    
    .onca-doc-name {
        font-size: 1.125rem;
        font-weight: 500;
        color: #111827;
        margin-bottom: 0.25rem;
    }
    
    .onca-doc-card:hover .onca-doc-name {
        color: #15803d;
    }
    
    .onca-doc-description {
        margin-top: 0.25rem;
        font-size: 0.875rem;
        color: #6b7280;
    }
    
    .onca-doc-code {
        display: inline-block;
        margin-top: 0.5rem;
        font-size: 0.75rem;
        font-family: monospace;
        background: #f3f4f6;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
    }
</style>
@endpush

@section('content')
<div class="onca-create-container">
    <div class="onca-create-header">
        <a href="{{ route('onca.index') }}" class="onca-back-link">
            <svg class="onca-back-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour à la liste
        </a>
        <h2 class="onca-create-title">Sélectionnez le type de document à créer</h2>
    </div>

    <div class="onca-doc-grid">
        <!-- Document 1: Health -->
        <a href="{{ route('onca.create-form', 'health') }}" class="onca-doc-card">
            <div class="onca-doc-content">
                <div class="onca-doc-icon-wrapper onca-doc-icon-health">
                    <span>👨‍⚕️</span>
                </div>
                <div class="onca-doc-info">
                    <h3 class="onca-doc-name">Surveillance Santé & Hygiène</h3>
                    <p class="onca-doc-description">Mains, tenues, comportement et santé.</p>
                    <span class="onca-doc-code">PR-S-EN1</span>
                </div>
            </div>
        </a>

        <!-- Document 2: Pest -->
        <a href="{{ route('onca.create-form', 'pest') }}" class="onca-doc-card">
            <div class="onca-doc-content">
                <div class="onca-doc-icon-wrapper onca-doc-icon-pest">
                    <span>🐀</span>
                </div>
                <div class="onca-doc-info">
                    <h3 class="onca-doc-name">Lutte contre les Nuisibles</h3>
                    <p class="onca-doc-description">Contrôle préventif et curatif.</p>
                    <span class="onca-doc-code">PR-V-EN1</span>
                </div>
            </div>
        </a>

        <!-- Document 3: Cleaning -->
        <a href="{{ route('onca.create-form', 'cleaning') }}" class="onca-doc-card">
            <div class="onca-doc-content">
                <div class="onca-doc-icon-wrapper onca-doc-icon-cleaning">
                    <span>🧹</span>
                </div>
                <div class="onca-doc-info">
                    <h3 class="onca-doc-name">Nettoyage et Désinfection</h3>
                    <p class="onca-doc-description">Locaux, équipements, sanitaires.</p>
                    <span class="onca-doc-code">PR-N-EN1</span>
                </div>
            </div>
        </a>

        <!-- Document 4: Batch -->
        <a href="{{ route('onca.create-form', 'batch') }}" class="onca-doc-card">
            <div class="onca-doc-content">
                <div class="onca-doc-icon-wrapper onca-doc-icon-batch">
                    <span>🏷️</span>
                </div>
                <div class="onca-doc-info">
                    <h3 class="onca-doc-name">Codification des Lots</h3>
                    <p class="onca-doc-description">Traçabilité des matières premières reçues.</p>
                    <span class="onca-doc-code">PR-T-EN2</span>
                </div>
            </div>
        </a>

        <!-- Document 5: Storage -->
        <a href="{{ route('onca.create-form', 'storage') }}" class="onca-doc-card">
            <div class="onca-doc-content">
                <div class="onca-doc-icon-wrapper onca-doc-icon-storage">
                    <span>📦</span>
                </div>
                <div class="onca-doc-info">
                    <h3 class="onca-doc-name">Fiche de Stock</h3>
                    <p class="onca-doc-description">Entrées, sorties et solde.</p>
                    <span class="onca-doc-code">PR-T-EN4</span>
                </div>
            </div>
        </a>
    </div>
</div>
@endsection
