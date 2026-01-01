@extends('layouts.app')

@section('title', 'Commandes - Co-op ERP')
@section('page-title', 'Gestion des Commandes')

@section('content')
<div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">Commandes</h2>
            <p style="color: #6b7280;">Gestion de vos commandes clients.</p>
        </div>
        <a href="{{ route('commandes.create') }}" style="background: #2d7a52; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 500; transition: background 0.2s;">
            + Nouvelle Commande
        </a>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('error') }}
        </div>
    @endif

    <div style="display: grid; gap: 1rem;">
        @forelse($commandes as $commande)
        <div style="background: #ffffff; border: 2px solid #e5e7eb; border-radius: 0.75rem; padding: 0; overflow: hidden; transition: all 0.3s; box-shadow: 0 1px 3px rgba(0,0,0,0.1);" onmouseover="this.style.boxShadow='0 6px 12px rgba(0,0,0,0.1)'; this.style.borderColor='#2d7a52';" onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'; this.style.borderColor='#e5e7eb';">
            
            <!-- Header Section -->
            <div style="background: linear-gradient(135deg, #2d7a52 0%, #236844 100%); padding: 1rem 1.5rem; color: white;">
                <div style="display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.25rem;">Commande #{{ $commande->id }}</div>
                        <div style="display: flex; align-items: center; gap: 1rem; opacity: 0.95; font-size: 0.875rem;">
                            <span style="display: flex; align-items: center; gap: 0.375rem;">
                                <span style="font-size: 1rem;">👤</span>
                                <span style="font-weight: 500;">{{ $commande->client->name }}</span>
                            </span>
                            <span style="opacity: 0.7;">•</span>
                            <span style="display: flex; align-items: center; gap: 0.375rem;">
                                <span style="font-size: 1rem;">📅</span>
                                <span>{{ $commande->created_at->format('d/m/Y à H:i') }}</span>
                            </span>
                        </div>
                    </div>
                    <div>
                        @php
                            $statusClass = str_replace([' ', 'é', 'à', 'è'], ['-', 'e', 'a', 'e'], strtolower($commande->status));
                        @endphp
                        <button class="status-button status-{{ $statusClass }}" type="button" data-commande-id="{{ $commande->id }}" data-current-status="{{ $commande->status }}" style="background: white; border: none; padding: 0.5rem 1rem; border-radius: 2rem; cursor: pointer; font-size: 0.875rem; font-weight: 600; transition: all 0.2s; box-shadow: 0 2px 4px rgba(0,0,0,0.15);">
                            {{ ucfirst($commande->status) }}
                        </button>
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div style="padding: 1.25rem 1.5rem;">
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                    
                    <!-- Emballages Section -->
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem; padding-bottom: 0.375rem; border-bottom: 2px solid #e5e7eb;">
                            <span style="font-size: 1.125rem;">📦</span>
                            <h3 style="margin: 0; font-size: 0.9375rem; font-weight: 700; color: #1f2937;">Emballages</h3>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.625rem;">
                            @foreach($commande->emballages as $emballage)
                            <div style="display: flex; align-items: center; gap: 0.75rem; padding: 0.75rem; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); border: 1px solid #e5e7eb; border-radius: 0.5rem; transition: all 0.2s;" onmouseover="this.style.transform='translateX(4px)'; this.style.borderColor='#2d7a52';" onmouseout="this.style.transform='translateX(0)'; this.style.borderColor='#e5e7eb';">
                                <div style="width: 36px; height: 36px; background: white; border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700; color: #2d7a52; box-shadow: 0 1px 3px rgba(0,0,0,0.1); text-transform: uppercase; letter-spacing: 0.025em;">
                                    @if($emballage->productStock->product->type_emballage === 'PILULIER')
                                        PIL
                                    @elseif($emballage->productStock->product->type_emballage === 'BOUCHON')
                                        BOU
                                    @endif
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <div style="font-weight: 600; color: #1f2937; font-size: 0.875rem; margin-bottom: 0.125rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $emballage->productStock->product->name }}</div>
                                    <div style="display: inline-block; background: #e5e7eb; color: #4b5563; padding: 0.0625rem 0.5rem; border-radius: 0.25rem; font-size: 0.6875rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.025em;">
                                        {{ $emballage->productStock->product->type_emballage }}
                                    </div>
                                </div>
                                <div style="background: linear-gradient(135deg, #2d7a52 0%, #236844 100%); color: white; padding: 0.375rem 0.75rem; border-radius: 0.5rem; font-size: 0.9375rem; font-weight: 700; min-width: 48px; text-align: center; box-shadow: 0 2px 4px rgba(45,122,82,0.3);">
                                    ×{{ $emballage->quantity }}
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Capsules Section -->
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem; padding-bottom: 0.375rem; border-bottom: 2px solid #e5e7eb;">
                            <span style="font-size: 1.125rem;">💊</span>
                            <h3 style="margin: 0; font-size: 0.9375rem; font-weight: 700; color: #1f2937;">Capsules Remplies</h3>
                        </div>
                        @if($commande->filledCapsules->isNotEmpty())
                            @foreach($commande->filledCapsules as $capsule)
                            <div style="padding: 0.875rem; background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 2px solid #86efac; border-radius: 0.5rem;">
                                <div style="display: flex; align-items: center; gap: 0.625rem; margin-bottom: 0.75rem;">
                                    <div style="width: 32px; height: 32px; background: white; border-radius: 0.375rem; display: flex; align-items: center; justify-content: center; font-size: 1.125rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
                                        🌿
                                    </div>
                                    <div style="flex: 1; min-width: 0;">
                                        <div style="font-weight: 700; color: #166534; font-size: 0.9375rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                            {{ $capsule->filledCapsule->herb->name ?? 'Herbe inconnue' }}
                                        </div>
                                    </div>
                                </div>
                                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.5rem;">
                                    <div style="background: white; padding: 0.5rem; border-radius: 0.375rem; border: 1px solid #86efac;">
                                        <div style="font-size: 0.625rem; color: #166534; font-weight: 600; text-transform: uppercase; letter-spacing: 0.025em; margin-bottom: 0.125rem;">Quantité</div>
                                        <div style="font-size: 1.125rem; font-weight: 700; color: #166534;">{{ $capsule->quantity }}</div>
                                        <div style="font-size: 0.625rem; color: #16a34a;">capsules</div>
                                    </div>
                                    <div style="background: white; padding: 0.5rem; border-radius: 0.375rem; border: 1px solid #86efac;">
                                        <div style="font-size: 0.625rem; color: #166534; font-weight: 600; text-transform: uppercase; letter-spacing: 0.025em; margin-bottom: 0.125rem;">Par unité</div>
                                        <div style="font-size: 1.125rem; font-weight: 700; color: #166534;">{{ $commande->capsules_per_unit }}</div>
                                        <div style="font-size: 0.625rem; color: #16a34a;">caps/unité</div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @else
                            <div style="text-align: center; padding: 1.5rem; color: #9ca3af; font-style: italic; background: #f9fafb; border-radius: 0.5rem; border: 2px dashed #e5e7eb; font-size: 0.875rem;">
                                <div style="font-size: 1.5rem; margin-bottom: 0.375rem;">💊</div>
                                <div>Aucune capsule</div>
                            </div>
                        @endif
                    </div>

                    <!-- Summary Section -->
                    <div>
                        <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.75rem; padding-bottom: 0.375rem; border-bottom: 2px solid #e5e7eb;">
                            <span style="font-size: 1.125rem;">📊</span>
                            <h3 style="margin: 0; font-size: 0.9375rem; font-weight: 700; color: #1f2937;">Résumé</h3>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 0.625rem;">
                            <div style="background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); padding: 0.75rem; border-radius: 0.5rem; border: 2px solid #60a5fa;">
                                <div style="font-size: 0.625rem; color: #1e40af; font-weight: 600; text-transform: uppercase; letter-spacing: 0.025em; margin-bottom: 0.25rem;">Quantité Totale</div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: #1e40af;">{{ $commande->quantity }}</div>
                                <div style="font-size: 0.75rem; color: #1e40af; font-weight: 500;">unités commandées</div>
                            </div>
                            <div style="background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); padding: 0.75rem; border-radius: 0.5rem; border: 2px solid #34d399;">
                                <div style="font-size: 0.625rem; color: #065f46; font-weight: 600; text-transform: uppercase; letter-spacing: 0.025em; margin-bottom: 0.25rem;">Total Capsules</div>
                                <div style="font-size: 1.5rem; font-weight: 700; color: #065f46;">{{ $commande->quantity * $commande->capsules_per_unit }}</div>
                                <div style="font-size: 0.75rem; color: #065f46; font-weight: 500;">{{ $commande->quantity }} × {{ $commande->capsules_per_unit }}</div>
                            </div>
                            @if($commande->notes)
                            <div style="padding: 0.75rem; background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%); border: 2px solid #fbbf24; border-radius: 0.5rem;">
                                <div style="display: flex; align-items: center; gap: 0.375rem; margin-bottom: 0.375rem;">
                                    <span style="font-size: 0.9375rem;">📝</span>
                                    <div style="font-size: 0.625rem; color: #92400e; font-weight: 600; text-transform: uppercase; letter-spacing: 0.025em;">Notes</div>
                                </div>
                                <div style="font-size: 0.8125rem; color: #78350f; line-height: 1.4;">{{ $commande->notes }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Footer -->
            <div style="background: #f9fafb; border-top: 2px solid #e5e7eb; padding: 0.875rem 1.5rem; display: flex; justify-content: flex-end; gap: 0.625rem;">
                <a href="{{ route('commandes.edit', $commande->id) }}" style="display: inline-flex; align-items: center; gap: 0.375rem; color: #4b5563; text-decoration: none; font-size: 0.875rem; padding: 0.625rem 1.25rem; border: 2px solid #d1d5db; border-radius: 0.5rem; background: white; transition: all 0.2s; font-weight: 600;" onmouseover="this.style.borderColor='#2d7a52'; this.style.color='#2d7a52'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 6px rgba(0,0,0,0.1)';" onmouseout="this.style.borderColor='#d1d5db'; this.style.color='#4b5563'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                    <span style="font-size: 1rem;">✏️</span>
                    <span>Modifier</span>
                </a>
                <form action="{{ route('commandes.destroy', $commande->id) }}" method="POST" onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cette commande ?\n\nCette action est irréversible.')" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="display: inline-flex; align-items: center; gap: 0.375rem; color: #dc2626; background: white; border: 2px solid #fecaca; border-radius: 0.5rem; font-size: 0.875rem; padding: 0.625rem 1.25rem; cursor: pointer; font-weight: 600; transition: all 0.2s;" onmouseover="this.style.background='#dc2626'; this.style.color='white'; this.style.borderColor='#dc2626'; this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 6px rgba(220,38,38,0.3)';" onmouseout="this.style.background='white'; this.style.color='#dc2626'; this.style.borderColor='#fecaca'; this.style.transform='translateY(0)'; this.style.boxShadow='none';">
                        <span style="font-size: 1rem;">🗑️</span>
                        <span>Supprimer</span>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div style="padding: 4rem 2rem; text-align: center; background: linear-gradient(135deg, #f9fafb 0%, #f3f4f6 100%); border-radius: 1rem; border: 3px dashed #d1d5db;">
            <div style="font-size: 5rem; margin-bottom: 1rem; opacity: 0.5;">📦</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: #4b5563; margin-bottom: 0.75rem;">Aucune commande trouvée</div>
            <div style="font-size: 1rem; color: #6b7280; margin-bottom: 2rem;">Créez votre première commande pour commencer.</div>
            <a href="{{ route('commandes.create') }}" style="display: inline-flex; align-items: center; gap: 0.5rem; background: linear-gradient(135deg, #2d7a52 0%, #236844 100%); color: white; padding: 1rem 2rem; border-radius: 0.75rem; text-decoration: none; font-weight: 600; font-size: 1rem; transition: all 0.3s; box-shadow: 0 4px 6px rgba(45,122,82,0.3);" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 12px rgba(45,122,82,0.4)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px rgba(45,122,82,0.3)';">
                <span style="font-size: 1.25rem;">➕</span>
                <span>Créer une commande</span>
            </a>
        </div>
        @endforelse
    </div>
</div>

<!-- Status Change Modal -->
<div id="statusModal" class="status-modal" style="display: none;">
    <div class="status-modal-overlay"></div>
    <div class="status-modal-content">
        <div class="status-modal-header">
            <h3>Changer le statut de la commande</h3>
            <button class="status-modal-close" type="button">&times;</button>
        </div>
        <div class="status-modal-body">
            <p style="margin-bottom: 1rem; color: #6b7280;">Sélectionnez le nouveau statut:</p>
            <div class="status-options-grid">
                <button class="status-option-btn" data-status="en attente">
                    <span class="status-badge status-en-attente">En attente</span>
                </button>
                <button class="status-option-btn" data-status="en cours">
                    <span class="status-badge status-en-cours">En cours</span>
                </button>
                <button class="status-option-btn" data-status="livré">
                    <span class="status-badge status-livre">Livré</span>
                </button>
                <button class="status-option-btn" data-status="annulé">
                    <span class="status-badge status-annule">Annulé</span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .status-button {
        min-width: 110px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .status-button:hover {
        transform: translateY(-2px) scale(1.05);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2) !important;
    }

    .status-en-attente {
        background: #fef3c7 !important;
        color: #92400e !important;
        border: 2px solid #fbbf24 !important;
    }

    .status-en-cours {
        background: #dbeafe !important;
        color: #1e40af !important;
        border: 2px solid #60a5fa !important;
    }

    .status-livre {
        background: #d1fae5 !important;
        color: #065f46 !important;
        border: 2px solid #34d399 !important;
    }

    .status-annule {
        background: #fee2e2 !important;
        color: #991b1b !important;
        border: 2px solid #f87171 !important;
    }

    /* Modal Styles */
    .status-modal {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .status-modal-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }

    .status-modal-content {
        position: relative;
        background: white;
        border-radius: 1rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        width: 90%;
        max-width: 500px;
        max-height: 90vh;
        overflow: hidden;
        animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(-10px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    .status-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .status-modal-header h3 {
        margin: 0;
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
    }

    .status-modal-close {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #6b7280;
        cursor: pointer;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 0.375rem;
        transition: background 0.2s, color 0.2s;
    }

    .status-modal-close:hover {
        background: #f3f4f6;
        color: #1f2937;
    }

    .status-modal-body {
        padding: 1.5rem;
    }

    .status-options-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 1rem;
        margin-top: 1rem;
    }

    .status-option-btn {
        background: white;
        border: 2px solid #e5e7eb;
        border-radius: 0.75rem;
        padding: 1rem;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }

    .status-option-btn:hover {
        border-color: #2d7a52;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
    }

    .status-option-btn:active {
        transform: translateY(0);
    }

    .status-badge {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        font-weight: 500;
        font-size: 0.875rem;
        width: 100%;
    }

    .status-option-btn[data-status="en attente"] .status-badge {
        background: #fef3c7;
        color: #92400e;
    }

    .status-option-btn[data-status="en cours"] .status-badge {
        background: #dbeafe;
        color: #1e40af;
    }

    .status-option-btn[data-status="livré"] .status-badge {
        background: #d1fae5;
        color: #065f46;
    }

    .status-option-btn[data-status="annulé"] .status-badge {
        background: #fee2e2;
        color: #991b1b;
    }
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const modal = document.getElementById('statusModal');
    const modalOverlay = modal.querySelector('.status-modal-overlay');
    const modalClose = modal.querySelector('.status-modal-close');
    const statusButtons = document.querySelectorAll('.status-button[data-commande-id]');
    const statusOptionButtons = modal.querySelectorAll('.status-option-btn');
    
    let currentCommandeId = null;
    let currentStatusButton = null;

    // Open modal when clicking status button
    statusButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            currentCommandeId = button.dataset.commandeId;
            currentStatusButton = button;
            const currentStatus = button.dataset.currentStatus;
            
            // Hide current status option in modal
            statusOptionButtons.forEach(optBtn => {
                if (optBtn.dataset.status === currentStatus) {
                    optBtn.style.display = 'none';
                } else {
                    optBtn.style.display = 'block';
                }
            });
            
            modal.style.display = 'flex';
        });
    });

    // Close modal functions
    function closeModal() {
        modal.style.display = 'none';
        currentCommandeId = null;
        currentStatusButton = null;
    }

    modalClose.addEventListener('click', closeModal);
    modalOverlay.addEventListener('click', closeModal);

    // Handle status option click
    statusOptionButtons.forEach(optionBtn => {
        optionBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const newStatus = optionBtn.dataset.status;
            const statusText = optionBtn.querySelector('.status-badge').textContent.trim();
            
            if (!currentCommandeId || !currentStatusButton) return;
            
            // Save values before closing modal (since closeModal resets them)
            const commandeId = currentCommandeId;
            const statusButton = currentStatusButton;
            
            // Show loading state
            statusButton.textContent = 'Chargement...';
            statusButton.disabled = true;
            
            // Close modal
            closeModal();
            
            // Send AJAX request
            fetch(`/commandes/${commandeId}/update-status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ status: newStatus })
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(err.message || 'Erreur HTTP: ' + response.status);
                    }).catch(() => {
                        throw new Error('Erreur HTTP: ' + response.status);
                    });
                }
                return response.json().catch(() => {
                    throw new Error('Réponse invalide du serveur');
                });
            })
            .then(data => {
                if (data.success) {
                    // Update button text and class
                    statusButton.textContent = newStatus;
                    statusButton.dataset.currentStatus = newStatus;
                    
                    // Normalize status for CSS class (replace spaces and accents)
                    const statusClass = newStatus.replace(/\s+/g, '-').toLowerCase()
                        .replace(/é/g, 'e').replace(/à/g, 'a').replace(/è/g, 'e');
                    statusButton.className = `status-button status-${statusClass}`;
                } else {
                    alert(data.message || 'Une erreur est survenue');
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Une erreur est survenue: ' + error.message);
                location.reload();
            })
            .finally(() => {
                if (statusButton) {
                    statusButton.disabled = false;
                }
            });
        });
    });

    // Close modal on Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal.style.display === 'flex') {
            closeModal();
        }
    });
});
</script>
@endpush
@endsection

