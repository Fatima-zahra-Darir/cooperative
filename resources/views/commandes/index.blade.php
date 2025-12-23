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

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid #e5e7eb; text-align: left;">
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">ID</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Client</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Produit</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Quantité</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Statut</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Date</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($commandes as $commande)
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 1rem; color: #1f2937; font-weight: 500;">#{{ $commande->id }}</td>
                    <td style="padding: 1rem; color: #4b5563;">{{ $commande->client->name }}</td>
                    <td style="padding: 1rem; color: #4b5563;">
                        <div style="font-weight: 500;">{{ $commande->productStock->product->name }}</div>
                        <div style="font-size: 0.75rem; color: #6b7280; margin-top: 0.25rem;">
                            @if($commande->productStock->category)
                                <span style="background: #f3f4f6; padding: 0.125rem 0.375rem; border-radius: 0.25rem; margin-right: 0.25rem;">{{ $commande->productStock->category->name }}</span>
                            @endif
                            @if($commande->productStock->color)
                                <span style="background: #e0f2fe; color: #0369a1; padding: 0.125rem 0.375rem; border-radius: 0.25rem; margin-right: 0.25rem;">{{ $commande->productStock->color->name }}</span>
                            @endif
                            @if($commande->productStock->size)
                                <span style="background: #fef3c7; color: #92400e; padding: 0.125rem 0.375rem; border-radius: 0.25rem;">{{ $commande->productStock->size->name }}</span>
                            @endif
                        </div>
                    </td>
                    <td style="padding: 1rem; color: #4b5563; font-weight: 500;">{{ $commande->quantity }}</td>
                    <td style="padding: 1rem;">
                        @php
                            $statusClass = str_replace([' ', 'é', 'à', 'è'], ['-', 'e', 'a', 'e'], strtolower($commande->status));
                        @endphp
                        <button class="status-button status-{{ $statusClass }}" type="button" data-commande-id="{{ $commande->id }}" data-current-status="{{ $commande->status }}" style="background: none; border: none; padding: 0.375rem 0.75rem; border-radius: 0.375rem; cursor: pointer; font-size: 0.875rem; font-weight: 500; transition: all 0.2s;">
                            {{ $commande->status }}
                        </button>
                    </td>
                    <td style="padding: 1rem; color: #6b7280; font-size: 0.875rem;">{{ $commande->created_at->format('d/m/Y') }}</td>
                    <td style="padding: 1rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem;">
                            <a href="{{ route('commandes.edit', $commande->id) }}" style="color: #4b5563; text-decoration: none; font-size: 0.875rem; padding: 0.25rem 0.5rem; border: 1px solid #e5e7eb; border-radius: 0.25rem;">Modifier</a>
                            <form action="{{ route('commandes.destroy', $commande->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette commande ?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="color: #dc2626; background: none; border: 1px solid #fee2e2; border-radius: 0.25rem; font-size: 0.875rem; padding: 0.25rem 0.5rem; cursor: pointer;">Supprimer</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 2rem; text-align: center; color: #9ca3af;">Aucune commande trouvée.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
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
        min-width: 100px;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .status-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .status-en-attente {
        background: #fef3c7 !important;
        color: #92400e !important;
    }

    .status-en-cours {
        background: #dbeafe !important;
        color: #1e40af !important;
    }

    .status-livre {
        background: #d1fae5 !important;
        color: #065f46 !important;
    }

    .status-annule {
        background: #fee2e2 !important;
        color: #991b1b !important;
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

