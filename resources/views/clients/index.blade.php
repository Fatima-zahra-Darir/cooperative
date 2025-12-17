@extends('layouts.app')

@section('title', 'Clients - Co-op ERP')
@section('page-title', 'Clients')

@section('content')
<div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #1f2937;">Clients</h2>
    <p style="color: #6b7280; margin-bottom: 2rem;">Cette section contiendra la gestion des clients. Données par défaut pour l'instant.</p>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
        <div style="padding: 1.5rem; background: #f9fafb; border-radius: 0.5rem;">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Total Clients</div>
            <div style="font-size: 2rem; font-weight: 700; color: #1f2937;">342</div>
        </div>
        <div style="padding: 1.5rem; background: #f9fafb; border-radius: 0.5rem;">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Actifs</div>
            <div style="font-size: 2rem; font-weight: 700; color: #059669;">298</div>
        </div>
        <div style="padding: 1.5rem; background: #f9fafb; border-radius: 0.5rem;">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Nouveaux (mois)</div>
            <div style="font-size: 2rem; font-weight: 700; color: #2563eb;">12</div>
        </div>
    </div>
</div>
@endsection

