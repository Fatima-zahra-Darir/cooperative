@extends('layouts.app')

@section('title', isset($document) ? 'Éditer Document' : 'Nouveau Document')
@section('page-title', isset($document) ? 'Éditer Document' : 'Nouveau Document')

@push('styles')
<style>
    .onca-form-container {
        background: white;
        border-radius: 0.75rem;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        padding: 1.5rem;
        max-width: 64rem;
        margin: 0 auto;
    }
    
    .onca-form-header {
        margin-bottom: 1.5rem;
    }
    
    .onca-back-link {
        color: #4f46e5;
        text-decoration: none;
        display: flex;
        align-items: center;
        margin-bottom: 0.5rem;
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
    
    .onca-form-title {
        font-size: 1.25rem;
        font-weight: 700;
        color: #1f2937;
    }
    
    .onca-form-meta {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-top: 0.25rem;
    }
    
    .onca-form-ref {
        background: #f3f4f6;
        color: #374151;
        padding: 0.25rem 0.5rem;
        border-radius: 0.25rem;
        font-size: 0.875rem;
        font-family: monospace;
    }
    
    .onca-form-version {
        color: #6b7280;
        font-size: 0.875rem;
    }
    
    .onca-form-common {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.5rem;
        margin-bottom: 2rem;
        background: #f9fafb;
        padding: 1rem;
        border-radius: 0.5rem;
        border: 1px solid #f3f4f6;
    }
    
    @media (min-width: 768px) {
        .onca-form-common {
            grid-template-columns: repeat(2, 1fr);
        }
    }
    
    .onca-form-field {
        margin-bottom: 1.5rem;
    }
    
    .onca-form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 500;
        color: #374151;
        margin-bottom: 0.25rem;
    }
    
    .onca-form-input {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    
    .onca-form-input:focus {
        outline: none;
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    }
    
    .onca-form-textarea {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-family: inherit;
        resize: vertical;
        min-height: 100px;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    
    .onca-form-textarea:focus {
        outline: none;
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    }
    
    .onca-form-select {
        width: 100%;
        padding: 0.5rem 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        background: white;
        transition: border-color 0.2s, box-shadow 0.2s;
    }
    
    .onca-form-select:focus {
        outline: none;
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.1);
    }
    
    .onca-form-section {
        margin-bottom: 2rem;
    }
    
    .onca-form-section-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: #111827;
        margin-bottom: 1rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e5e7eb;
    }
    
    .onca-form-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 1rem;
    }
    
    .onca-form-table thead {
        background: #f9fafb;
    }
    
    .onca-form-table th {
        padding: 0.75rem;
        text-align: left;
        font-size: 0.875rem;
        font-weight: 600;
        color: #374151;
        border-bottom: 1px solid #e5e7eb;
    }
    
    .onca-form-table td {
        padding: 0.75rem;
        border-bottom: 1px solid #f3f4f6;
    }
    
    .onca-form-table input,
    .onca-form-table select,
    .onca-form-table textarea {
        width: 100%;
        padding: 0.375rem 0.5rem;
        border: 1px solid #d1d5db;
        border-radius: 0.25rem;
        font-size: 0.875rem;
    }
    
    .onca-form-table input:focus,
    .onca-form-table select:focus,
    .onca-form-table textarea:focus {
        outline: none;
        border-color: #16a34a;
        box-shadow: 0 0 0 2px rgba(22, 163, 74, 0.1);
    }
    
    .onca-btn-add {
        background: #16a34a;
        color: white;
        padding: 0.5rem 1rem;
        border: none;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s;
        margin-bottom: 1rem;
    }
    
    .onca-btn-add:hover {
        background: #15803d;
    }
    
    .onca-btn-remove {
        background: #dc2626;
        color: white;
        padding: 0.375rem 0.75rem;
        border: none;
        border-radius: 0.25rem;
        font-size: 0.75rem;
        cursor: pointer;
        transition: background 0.2s;
    }
    
    .onca-btn-remove:hover {
        background: #b91c1c;
    }
    
    .onca-form-footer {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        justify-content: flex-end;
    }
    
    .onca-btn-submit {
        background: #16a34a;
        color: white;
        padding: 0.5rem 1.5rem;
        border: none;
        border-radius: 0.5rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        transition: background 0.2s, box-shadow 0.2s;
    }
    
    .onca-btn-submit:hover {
        background: #15803d;
    }
    
    .onca-btn-submit:focus {
        outline: none;
        box-shadow: 0 0 0 4px rgba(22, 163, 74, 0.2);
    }
</style>
@endpush

@section('content')
<div class="onca-form-container">
    <div class="onca-form-header">
        <a href="{{ route('onca.index') }}" class="onca-back-link">
            <svg class="onca-back-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Retour
        </a>
        <h2 class="onca-form-title">{{ $meta['title'] }}</h2>
        <div class="onca-form-meta">
            <span class="onca-form-ref">{{ $meta['ref'] }}</span>
            <span class="onca-form-version">Version: {{ $meta['ver'] }}</span>
        </div>
    </div>

    <form action="{{ isset($document) ? route('onca.update', $document) : route('onca.store') }}" method="POST" id="docForm">
        @csrf
        @if(isset($document))
            @method('PUT')
        @else
            <input type="hidden" name="type" value="{{ $type }}">
            <input type="hidden" name="reference" value="{{ $meta['ref'] }}">
            <input type="hidden" name="title" value="{{ $meta['title'] }}">
            <input type="hidden" name="version" value="{{ $meta['ver'] }}">
        @endif

        <!-- Common Fields -->
        <div class="onca-form-common">
            <div class="onca-form-field">
                <label class="onca-form-label">Date</label>
                <input type="date" name="date" required 
                    value="{{ old('date', isset($document) ? $document->date->format('Y-m-d') : date('Y-m-d')) }}"
                    class="onca-form-input">
            </div>
            <div class="onca-form-field">
                <label class="onca-form-label">Responsable</label>
                <input type="text" name="responsible" 
                    value="{{ old('responsible', isset($document) ? $document->responsible : Auth::user()->name) }}"
                    class="onca-form-input">
            </div>
        </div>

        <div style="margin-bottom: 2rem;">
            @php
                $content = isset($document) ? $document->content : [];
            @endphp

            @if($type === 'health')
                @include('onca.forms.health')
            @elseif($type === 'pest')
                @include('onca.forms.pest')
            @elseif($type === 'cleaning')
                @include('onca.forms.cleaning')
            @elseif($type === 'batch')
                @include('onca.forms.batch')
            @elseif($type === 'storage')
                @include('onca.forms.storage')
            @endif
        </div>

        <div class="onca-form-footer">
            <button type="submit" class="onca-btn-submit">
                Enregistrer le Document
            </button>
        </div>
    </form>
</div>

<script>
    // Simple helper to add rows
    function addRow(tableId, templateId) {
        const table = document.getElementById(tableId).querySelector('tbody');
        const template = document.getElementById(templateId).innerHTML;
        const index = table.querySelectorAll('tr').length;
        // Replace {index} placeholder if needed, though simple append matches array syntax usually
        // Using array name="content[section][]" logic
        
        const tr = document.createElement('tr');
        tr.innerHTML = template.replace(/{index}/g, index);
        table.appendChild(tr);
    }

    function removeRow(btn) {
        btn.closest('tr').remove();
    }
</script>
@endsection
