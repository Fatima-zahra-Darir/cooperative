@extends('layouts.app')

@section('title', 'Paramètres - Co-op ERP')
@section('page-title', 'Paramètres')

@section('content')
<div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 1rem; color: #1f2937;">Paramètres</h2>
    <p style="color: #6b7280; margin-bottom: 2rem;">Cette section contiendra les paramètres de l'application. Données par défaut pour l'instant.</p>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1rem;">
        <div style="padding: 1.5rem; background: #f9fafb; border-radius: 0.5rem; border-left: 4px solid #2563eb;">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Utilisateurs</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">24</div>
        </div>
        <div style="padding: 1.5rem; background: #f9fafb; border-radius: 0.5rem; border-left: 4px solid #059669;">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Rôles</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">5</div>
        </div>
        <div style="padding: 1.5rem; background: #f9fafb; border-radius: 0.5rem; border-left: 4px solid #8b5cf6;">
            <div style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Modules Actifs</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: #1f2937;">8</div>
        </div>
    </div>
</div>
@endsection

