@extends('layouts.app')

@section('title', 'Stock Capsules vide - Co-op ERP')
@section('page-title', 'Stock Capsules vide')

@push('styles')
<style>
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0,0,0,0.5);
    }

    .modal.active {
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .modal-content {
        background-color: white;
        margin: auto;
        padding: 2rem;
        border-radius: 0.5rem;
        width: 90%;
        max-width: 500px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }

    .modal-title {
        font-size: 1.25rem;
        font-weight: 600;
        color: #1f2937;
    }

    .close {
        color: #9ca3af;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        border: none;
        background: none;
        padding: 0;
        width: 30px;
        height: 30px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .close:hover,
    .close:focus {
        color: #1f2937;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-label {
        display: block;
        margin-bottom: 0.5rem;
        color: #374151;
        font-weight: 500;
        font-size: 0.875rem;
    }

    .form-input {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        transition: border-color 0.2s;
    }

    .form-input:focus {
        outline: none;
        border-color: #2d7a52;
        box-shadow: 0 0 0 3px rgba(45, 122, 82, 0.1);
    }

    .form-textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #d1d5db;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        min-height: 100px;
        resize: vertical;
        transition: border-color 0.2s;
    }

    .form-textarea:focus {
        outline: none;
        border-color: #2d7a52;
        box-shadow: 0 0 0 3px rgba(45, 122, 82, 0.1);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 0.75rem;
        margin-top: 2rem;
    }

    .btn {
        padding: 0.75rem 1.5rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        cursor: pointer;
        border: none;
        transition: all 0.2s;
    }

    .btn-primary {
        background: #2d7a52;
        color: white;
    }

    .btn-primary:hover {
        background: #256349;
    }

    .btn-secondary {
        background: #f3f4f6;
        color: #374151;
    }

    .btn-secondary:hover {
        background: #e5e7eb;
    }

    .btn-icon {
        width: 32px;
        height: 32px;
        padding: 0.375rem;
        border-radius: 0.25rem;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: all 0.2s;
        position: relative;
    }

    .btn-icon svg {
        width: 18px;
        height: 18px;
    }

    .btn-icon-view {
        background: #2d7a52;
        color: white;
    }

    .btn-icon-view:hover {
        background: #256349;
    }

    .btn-icon-restock {
        background: #3b82f6;
        color: white;
    }

    .btn-icon-restock:hover {
        background: #2563eb;
    }

    .btn-icon-usage {
        background: #f59e0b;
        color: white;
    }

    .btn-icon-usage:hover {
        background: #d97706;
    }

    .btn-icon-edit {
        background: #f3f4f6;
        color: #4b5563;
        border: 1px solid #e5e7eb;
    }

    .btn-icon-edit:hover {
        background: #e5e7eb;
    }

    .btn-icon-delete {
        background: transparent;
        color: #dc2626;
        border: 1px solid #fee2e2;
    }

    .btn-icon-delete:hover {
        background: #fee2e2;
    }

    .tooltip {
        position: relative;
    }

    .tooltip::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        margin-bottom: 5px;
        padding: 0.375rem 0.75rem;
        background: #1f2937;
        color: white;
        font-size: 0.75rem;
        border-radius: 0.25rem;
        white-space: nowrap;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.2s;
        z-index: 1000;
    }

    .tooltip:hover::after {
        opacity: 1;
    }

    .error-message {
        color: #dc2626;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>
@endpush

@section('content')
<div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">Stock Capsules vide</h2>
            <p style="color: #6b7280;">Gestion du stock des capsules vides par carton.</p>
        </div>
        <a href="{{ route('stock-capsules.create') }}" style="background: #2d7a52; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 500; transition: background 0.2s;">
            + Ajouter Stock
        </a>
    </div>

    @if(session('success'))
        <div style="background: #ecfdf5; color: #065f46; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div style="background: #fee2e2; color: #991b1b; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1.5rem;">
            <ul style="margin: 0; padding-left: 1.5rem;">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div style="overflow-x: auto;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid #e5e7eb; text-align: left;">
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Carton</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Quantité de cartons</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Nombre de capsules</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Fournisseur</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Notes</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($capsules as $capsule)
                @php
                    $globalQuantity = $capsule->global_quantity;
                    // Get the most recent restock movement with supplier
                    $latestRestock = $capsule->movements()->where('type', 'restock')->with('fornisseur')->orderBy('movement_date', 'desc')->orderBy('created_at', 'desc')->first();
                @endphp
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 1rem; color: #1f2937; font-weight: 500;">{{ $capsule->carton }}</td>
                    <td style="padding: 1rem; color: #4b5563;">
                        <div style="margin-bottom: 0.5rem;">
                            <span style="background: {{ $capsule->quantity > 0 ? '#ecfdf5' : '#fee2e2' }}; color: {{ $capsule->quantity > 0 ? '#065f46' : '#991b1b' }}; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.875rem; font-weight: 600; display: inline-block;">
                                {{ $capsule->quantity }} cartons
                            </span>
                        </div>
                        @php
                            $isPartial = ($capsule->nombre_capsules % 125000) != 0;
                        @endphp
                        @if($isPartial)
                            <div style="color: #f59e0b; font-size: 0.75rem; font-style: italic; margin-top: 0.25rem; display: block;">
                                📦 1 carton en cours d'utilisation
                            </div>
                        @endif
                    </td>
                    <td style="padding: 1rem; color: #1f2937; font-weight: 600; font-size: 0.95rem;">
                        {{ number_format($capsule->nombre_capsules, 0, ',', ' ') }}
                    </td>
                    <td style="padding: 1rem; color: #6b7280;">
                        @if($latestRestock && $latestRestock->fornisseur)
                            <span style="font-weight: 500; color: #1f2937;">{{ $latestRestock->fornisseur->name }}</span>
                            @if($latestRestock->fornisseur->ville)
                                <span style="color: #6b7280; font-size: 0.875rem;"> - {{ $latestRestock->fornisseur->ville }}</span>
                            @endif
                        @else
                            <span style="color: #9ca3af;">-</span>
                        @endif
                    </td>
                    <td style="padding: 1rem; color: #4b5563;">{{ $capsule->notes ?? '-' }}</td>
                    <td style="padding: 1rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem; flex-wrap: wrap;">
                            <a href="{{ route('stock-capsules.show', $capsule->id) }}" class="btn-icon btn-icon-view tooltip" data-tooltip="Voir">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <button onclick="openRestockModal({{ $capsule->id }})" class="btn-icon btn-icon-restock tooltip" data-tooltip="Réapprovisionner">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                            <button onclick="openUsageModal({{ $capsule->id }}, {{ $capsule->nombre_capsules }})" class="btn-icon btn-icon-usage tooltip" data-tooltip="Utilisation">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </button>
                            <a href="{{ route('stock-capsules.edit', $capsule->id) }}" class="btn-icon btn-icon-edit tooltip" data-tooltip="Modifier">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('stock-capsules.destroy', $capsule->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?')" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-icon btn-icon-delete tooltip" data-tooltip="Supprimer">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 2rem; text-align: center; color: #9ca3af;">Aucun stock capsule trouvé.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Restock Modal -->
<div id="restockModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Réapprovisionner le stock</h2>
            <button class="close" onclick="closeRestockModal()">&times;</button>
        </div>
        <form id="restockForm" method="POST">
            @csrf
            <div class="form-group">
                <label class="form-label" for="restock_quantity">Quantité</label>
                <input type="number" id="restock_quantity" name="quantity" class="form-input" min="1" required>
                @error('quantity')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="restock_fornisseur_id">Fournisseur</label>
                <select id="restock_fornisseur_id" name="fornisseur_id" class="form-input">
                    <option value="">Sélectionner un fournisseur (optionnel)</option>
                    @foreach($fornisseurs as $fornisseur)
                        <option value="{{ $fornisseur->id }}">{{ $fornisseur->name }}@if($fornisseur->ville) - {{ $fornisseur->ville }}@endif</option>
                    @endforeach
                </select>
                @error('fornisseur_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="restock_date">Date</label>
                <input type="date" id="restock_date" name="movement_date" class="form-input" value="{{ date('Y-m-d') }}" required>
                @error('movement_date')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="restock_notes">Notes (optionnel)</label>
                <textarea id="restock_notes" name="notes" class="form-textarea"></textarea>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeRestockModal()">Annuler</button>
                <button type="submit" class="btn btn-primary">Réapprovisionner</button>
            </div>
        </form>
    </div>
</div>

<!-- Usage Modal -->
<div id="usageModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Enregistrer une utilisation</h2>
            <button class="close" onclick="closeUsageModal()">&times;</button>
        </div>
        <form id="usageForm" method="POST">
            @csrf
            <!-- Information Box -->
            <div style="background-color: #eff6ff; border-left: 4px solid #3b82f6; padding: 0.75rem 1rem; margin-bottom: 1.5rem; border-radius: 0.375rem; font-size: 0.875rem; color: #1e40af;">
                <strong>📌 Informations:</strong> 1 carton = 125,000 capsules | 1 rangée = 420 capsules
            </div>

            <div class="form-group">
                <label class="form-label" for="usage_quantity">Quantité utilisée (rangées)</label>
                <input type="number" id="usage_quantity" name="quantity" class="form-input" min="1" required>
                <small style="color: #6b7280; font-size: 0.75rem; display: block; margin-top: 0.25rem;">Nombre de rangées à utiliser</small>
                @error('quantity')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <!-- Live Calculation Display -->
            <div style="background-color: #f3f4f6; padding: 1rem; border-radius: 0.375rem; margin-bottom: 1.5rem; border: 1px solid #e5e7eb;">
                <div style="font-size: 0.875rem; color: #374151; margin-bottom: 0.75rem;">
                    <strong>Calcul en temps réel:</strong>
                </div>
                <div style="font-size: 0.813rem; color: #4b5563; line-height: 1.6;">
                    <div>Capsules utilisées: <strong id="calc_capsules_used">0</strong> capsules</div>
                    <div style="color: #6b7280; margin-top: 0.5rem;">Nombre de capsules restantes: <strong id="calc_remaining_capsules" style="color: #059669;">0</strong></div>
                    <div style="color: #6b7280; margin-top: 0.25rem;">Nombre de cartons restants: <strong id="calc_remaining_cartons" style="color: #059669;">0</strong> cartons</div>
                    <div style="color: #6b7280; margin-top: 0.25rem; font-style: italic;">Statut: <strong id="calc_status" style="color: #059669;">-</strong></div>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="usage_herb_id">Herbe utilisée <span style="color: #ef4444;">*</span></label>
                <select id="usage_herb_id" name="herb_id" class="form-input" required>
                    <option value="">Sélectionner une herbe</option>
                    @foreach($herbs as $herb)
                        <option value="{{ $herb->id }}" data-stock="{{ $herb->global_quantity }}">{{ $herb->name }} (Source: {{ $herb->source }})</option>
                    @endforeach
                </select>
                <small style="color: #6b7280; font-size: 0.75rem; display: block; margin-top: 0.25rem;">Stock d'herbe disponible: <span id="available_herb_quantity">-</span></small>
                @error('herb_id')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="usage_herb_quantity">Quantité d'herbe utilisée <span style="color: #ef4444;">*</span></label>
                <input type="number" id="usage_herb_quantity" name="herb_quantity" class="form-input" step="0.01" min="0.01" required>
                <small style="color: #6b7280; font-size: 0.75rem; display: block; margin-top: 0.25rem;">Quantité d'herbe utilisée pour remplir les capsules</small>
                @error('herb_quantity')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="usage_date">Date d'utilisation</label>
                <input type="date" id="usage_date" name="movement_date" class="form-input" value="{{ date('Y-m-d') }}" required>
                @error('movement_date')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="usage_notes">Notes (optionnel)</label>
                <textarea id="usage_notes" name="notes" class="form-textarea"></textarea>
            </div>
            <div class="form-actions">
                <button type="button" class="btn btn-secondary" onclick="closeUsageModal()">Annuler</button>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Store current capsule data for calculations
    let currentCapsuleData = {
        id: null,
        nombreCapsules: 0,
        nombreCartons: 0
    };

    function openRestockModal(capsuleId) {
        const modal = document.getElementById('restockModal');
        const form = document.getElementById('restockForm');
        form.action = '{{ route("stock-capsules.restock", ":id") }}'.replace(':id', capsuleId);
        modal.classList.add('active');
    }

    function closeRestockModal() {
        const modal = document.getElementById('restockModal');
        modal.classList.remove('active');
        const form = document.getElementById('restockForm');
        form.reset();
    }

    function openUsageModal(capsuleId, numberOfCapsules) {
        const modal = document.getElementById('usageModal');
        const form = document.getElementById('usageForm');
        
        // Store current capsule data for calculations
        currentCapsuleData = {
            id: capsuleId,
            nombreCapsules: numberOfCapsules,
            nombreCartons: Math.floor(numberOfCapsules / 125000)
        };

        form.action = '{{ route("stock-capsules.usage", ":id") }}'.replace(':id', capsuleId);
        
        // Reset form and calculations
        form.reset();
        resetCalculations();
        
        modal.classList.add('active');
    }

    function closeUsageModal() {
        const modal = document.getElementById('usageModal');
        modal.classList.remove('active');
        const form = document.getElementById('usageForm');
        form.reset();
        resetCalculations();
        // Reset herb stock display
        document.getElementById('available_herb_quantity').textContent = '-';
    }

    function resetCalculations() {
        document.getElementById('calc_capsules_used').textContent = '0';
        document.getElementById('calc_remaining_capsules').textContent = '0';
        document.getElementById('calc_remaining_cartons').textContent = '0';
        document.getElementById('calc_status').textContent = '-';
    }

    function updateCalculations() {
        const rangesInput = document.getElementById('usage_quantity');
        const ranges = parseInt(rangesInput.value) || 0;

        // Constants: 1 range = 420 capsules, 1 carton = 125,000 capsules
        const CAPSULES_PER_RANGE = 420;
        const CAPSULES_PER_CARTON = 125000;

        // Calculate capsules used
        const capsulesUsed = ranges * CAPSULES_PER_RANGE;
        
        // Calculate remaining capsules
        const remainingCapsules = currentCapsuleData.nombreCapsules - capsulesUsed;
        
        // Calculate remaining cartons
        const remainingCartons = Math.floor(remainingCapsules / CAPSULES_PER_CARTON);
        
        // Determine status
        let status = remainingCartons;
        if (remainingCapsules > 0 && remainingCapsules < CAPSULES_PER_CARTON) {
            status = 'Carton ouvert';
        }

        // Update display
        document.getElementById('calc_capsules_used').textContent = capsulesUsed.toLocaleString('fr-FR');
        document.getElementById('calc_remaining_capsules').textContent = Math.max(0, remainingCapsules).toLocaleString('fr-FR');
        document.getElementById('calc_remaining_cartons').textContent = Math.max(0, remainingCartons);
        document.getElementById('calc_status').textContent = remainingCapsules < 0 ? '⚠️ Quantité insuffisante' : status;
    }

    // Update herb stock when herb is selected
    document.addEventListener('DOMContentLoaded', function() {
        const herbSelect = document.getElementById('usage_herb_id');
        const herbStockSpan = document.getElementById('available_herb_quantity');
        const usageQuantityInput = document.getElementById('usage_quantity');
        
        if (herbSelect && herbStockSpan) {
            herbSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                if (selectedOption.value) {
                    const stock = selectedOption.getAttribute('data-stock');
                    herbStockSpan.textContent = stock || '0';
                } else {
                    herbStockSpan.textContent = '-';
                }
            });
        }

        // Add event listener for range quantity input to update calculations in real-time
        if (usageQuantityInput) {
            usageQuantityInput.addEventListener('input', updateCalculations);
        }
    });

    // Close modals when clicking outside
    window.onclick = function(event) {
        const restockModal = document.getElementById('restockModal');
        const usageModal = document.getElementById('usageModal');
        if (event.target == restockModal) {
            closeRestockModal();
        }
        if (event.target == usageModal) {
            closeUsageModal();
        }
    }

    // Close modals on Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeRestockModal();
            closeUsageModal();
        }
    });
</script>
@endpush
