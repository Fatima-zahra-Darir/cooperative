@extends('layouts.app')

@section('title', 'Stock Produit - Co-op ERP')
@section('page-title', 'Stock Produit')

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
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #1f2937;">Stock Produit</h2>
            <p style="color: #6b7280;">Gestion du stock pour les produits existants.</p>
        </div>
        <a href="{{ route('stock-produit.create') }}" style="background: #2d7a52; color: white; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 500; transition: background 0.2s;">
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
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Produit</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Catégorie</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Couleur</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Taille</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Quantité</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500;">Notes</th>
                    <th style="padding: 1rem; color: #6b7280; font-weight: 500; text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($stocks as $stock)
                @php
                    $globalQuantity = $stock->global_quantity;
                @endphp
                <tr style="border-bottom: 1px solid #f3f4f6;">
                    <td style="padding: 1rem; color: #1f2937; font-weight: 500;">{{ $stock->product->name }}</td>
                    <td style="padding: 1rem; color: #4b5563;">{{ $stock->category->name ?? '-' }}</td>
                    <td style="padding: 1rem; color: #4b5563;">{{ $stock->color->name ?? '-' }}</td>
                    <td style="padding: 1rem; color: #4b5563;">{{ $stock->size->name ?? '-' }}</td>
                    <td style="padding: 1rem; color: #4b5563;">
                        <span style="background: {{ $globalQuantity > 0 ? '#ecfdf5' : '#fee2e2' }}; color: {{ $globalQuantity > 0 ? '#065f46' : '#991b1b' }}; padding: 0.25rem 0.75rem; border-radius: 1rem; font-size: 0.875rem; font-weight: 600;">
                            {{ $globalQuantity }} unités
                        </span>
                    </td>
                    <td style="padding: 1rem; color: #4b5563;">{{ $stock->notes ?? '-' }}</td>
                    <td style="padding: 1rem; text-align: right;">
                        <div style="display: flex; justify-content: flex-end; gap: 0.5rem; flex-wrap: wrap;">
                            <a href="{{ route('stock-produit.show', $stock->id) }}" class="btn-icon btn-icon-view tooltip" data-tooltip="Voir">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </a>
                            <button onclick="openRestockModal({{ $stock->id }})" class="btn-icon btn-icon-restock tooltip" data-tooltip="Réapprovisionner">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </button>
                            <button onclick="openUsageModal({{ $stock->id }}, {{ $globalQuantity }})" class="btn-icon btn-icon-usage tooltip" data-tooltip="Utilisation">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </button>
                            <a href="{{ route('stock-produit.edit', $stock->id) }}" class="btn-icon btn-icon-edit tooltip" data-tooltip="Modifier">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <form action="{{ route('stock-produit.destroy', $stock->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr ?')" style="display: inline;">
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
                    <td colspan="7" style="padding: 2rem; text-align: center; color: #9ca3af;">Aucun stock produit trouvé.</td>
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
            <div class="form-group">
                <label class="form-label" for="usage_quantity">Quantité utilisée</label>
                <input type="number" id="usage_quantity" name="quantity" class="form-input" min="1" required>
                <small style="color: #6b7280; font-size: 0.75rem; display: block; margin-top: 0.25rem;">Stock disponible: <span id="available_quantity">0</span> unités</small>
                @error('quantity')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="usage_date">Date</label>
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
    function openRestockModal(stockId) {
        const modal = document.getElementById('restockModal');
        const form = document.getElementById('restockForm');
        form.action = '{{ route("stock-produit.restock", ":id") }}'.replace(':id', stockId);
        modal.classList.add('active');
    }

    function closeRestockModal() {
        const modal = document.getElementById('restockModal');
        modal.classList.remove('active');
        const form = document.getElementById('restockForm');
        form.reset();
    }

    function openUsageModal(stockId, availableQuantity) {
        const modal = document.getElementById('usageModal');
        const form = document.getElementById('usageForm');
        const availableQuantitySpan = document.getElementById('available_quantity');
        form.action = '{{ route("stock-produit.usage", ":id") }}'.replace(':id', stockId);
        availableQuantitySpan.textContent = availableQuantity;
        modal.classList.add('active');
    }

    function closeUsageModal() {
        const modal = document.getElementById('usageModal');
        modal.classList.remove('active');
        const form = document.getElementById('usageForm');
        form.reset();
    }

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
