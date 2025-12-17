@extends('layouts.app')

@section('title', $document->title)
@section('page-title', $document->title)

@section('content')
<div class="bg-white rounded-xl shadow-sm p-6 max-w-5xl mx-auto">
    <div class="mb-6 flex justify-between items-start">
        <div>
            <a href="{{ route('onca.index') }}" class="text-indigo-600 hover:text-indigo-800 flex items-center mb-2">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour à la liste
            </a>
            <h2 class="text-2xl font-bold text-gray-800">{{ $document->title }}</h2>
            <div class="flex items-center gap-4 mt-2 text-sm text-gray-600">
                <span class="bg-gray-100 px-2 py-1 rounded font-mono">{{ $document->reference }}</span>
                <span>Version: {{ $document->version }}</span>
                <span>Date: {{ $document->date->format('d/m/Y') }}</span>
                <span>Responsable: {{ $document->responsible }}</span>
            </div>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('onca.edit', $document) }}" class="bg-gray-100 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-200 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                Modifier
            </a>
            <a href="{{ route('onca.print', $document) }}" target="_blank" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Imprimer / Exporter
            </a>
        </div>
    </div>

    <div class="border-t border-gray-200 pt-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Aperçu du contenu</h3>
        
        <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 overflow-hidden">
             <!-- iframe to show the print view as preview -->
             <iframe src="{{ route('onca.print', $document) }}" class="w-full h-[600px] border bg-white" style="transform: scale(0.95); transform-origin: top center;"></iframe>
        </div>
    </div>
</div>
@endsection
