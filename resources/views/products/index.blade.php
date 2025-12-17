@extends('layouts.app')

@section('title', 'Produits - Co-op ERP')
@section('page-title', 'Produits')

@section('content')
<div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #1f2937;">Produits</h2>
    <p style="color: #6b7280; margin-bottom: 2rem;">Cette section contiendra la gestion des produits. Données par défaut pour l'instant.</p>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
        <div style="padding: 1.5rem; background: #f9fafb; border-radius: 0.5rem;">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Total Produits</div>
            <div style="font-size: 2rem; font-weight: 700; color: #1f2937;">156</div>
        </div>
        <div style="padding: 1.5rem; background: #f9fafb; border-radius: 0.5rem;">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Actifs</div>
            <div style="font-size: 2rem; font-weight: 700; color: #059669;">142</div>
        </div>
        <div style="padding: 1.5rem; background: #f9fafb; border-radius: 0.5rem;">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Inactifs</div>
            <div style="font-size: 2rem; font-weight: 700; color: #dc2626;">14</div>
        </div>
    </div>
</div>
@endsection

