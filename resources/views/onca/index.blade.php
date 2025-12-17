@extends('layouts.app')

@section('title', 'Gestion des documents ONCA - Co-op ERP')
@section('page-title', 'Gestion des documents ONCA')

@section('content')
<div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #1f2937;">Gestion des documents ONCA</h2>
    <p style="color: #6b7280; margin-bottom: 2rem;">Cette section contiendra la gestion des documents ONCA. Données par défaut pour l'instant.</p>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <div style="padding: 1.5rem; background: #f9fafb; border-radius: 0.5rem;">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Documents Totaux</div>
            <div style="font-size: 2rem; font-weight: 700; color: #1f2937;">48</div>
        </div>
        <div style="padding: 1.5rem; background: #f9fafb; border-radius: 0.5rem;">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">En Attente</div>
            <div style="font-size: 2rem; font-weight: 700; color: #f59e0b;">5</div>
        </div>
        <div style="padding: 1.5rem; background: #f9fafb; border-radius: 0.5rem;">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Approuvés</div>
            <div style="font-size: 2rem; font-weight: 700; color: #059669;">43</div>
        </div>
    </div>
</div>
@endsection

