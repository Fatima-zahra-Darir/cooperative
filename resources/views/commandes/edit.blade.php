@extends('layouts.app')

@section('title', 'Modifier Commande - Co-op ERP')
@section('page-title', 'Modifier une Commande')

@section('content')
<div style="max-width: 800px;">
    <div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #1f2937;">Informations de la commande</h2>
        
        <form action="{{ route('commandes.update', $commande->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div style="margin-bottom: 1.5rem;">
                <label for="client_id" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Client <span style="color: #dc2626;">*</span></label>
                <select name="client_id" id="client_id" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;">
                    <option value="">Sélectionner un client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $commande->client_id) == $client->id ? 'selected' : '' }}>{{ $client->name }}@if($client->email) - {{ $client->email }}@endif</option>
                    @endforeach
                </select>
                @error('client_id')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="product_stock_id" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Stock Produit <span style="color: #dc2626;">*</span></label>
                <select name="product_stock_id" id="product_stock_id" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;">
                    <option value="">Sélectionner un stock produit</option>
                    @foreach($productStocks as $stock)
                        @php
                            $productName = $stock->product->name;
                            $attrs = [];
                            if ($stock->category) $attrs[] = $stock->category->name;
                            if ($stock->color) $attrs[] = $stock->color->name;
                            if ($stock->size) $attrs[] = $stock->size->name;
                            $displayName = $productName . (count($attrs) > 0 ? ' (' . implode(', ', $attrs) . ')' : '') . ' - Stock: ' . $stock->global_quantity;
                        @endphp
                        <option value="{{ $stock->id }}" {{ old('product_stock_id', $commande->product_stock_id) == $stock->id ? 'selected' : '' }} data-stock="{{ $stock->global_quantity }}">{{ $displayName }}</option>
                    @endforeach
                </select>
                @error('product_stock_id')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
                <p id="stock-info" style="color: #6b7280; font-size: 0.75rem; margin-top: 0.5rem;"></p>
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="quantity" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Quantité <span style="color: #dc2626;">*</span></label>
                <input type="number" name="quantity" id="quantity" required min="1" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;" placeholder="1" value="{{ old('quantity', $commande->quantity) }}">
                @error('quantity')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 2rem;">
                <label for="notes" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Notes (optionnel)</label>
                <textarea name="notes" id="notes" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none; resize: vertical;" placeholder="Notes additionnelles...">{{ old('notes', $commande->notes) }}</textarea>
                @error('notes')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; border-top: 1px solid #e5e7eb; padding-top: 1.5rem;">
                <button type="submit" style="background: #2d7a52; color: white; padding: 0.75rem 2rem; border-radius: 0.5rem; border: none; font-weight: 500; cursor: pointer;">
                    Enregistrer les modifications
                </button>
                <a href="{{ route('commandes.index') }}" style="background: white; color: #4b5563; padding: 0.75rem 2rem; border-radius: 0.5rem; border: 1px solid #d1d5db; text-decoration: none; font-weight: 500; text-align: center;">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const productStockSelect = document.getElementById('product_stock_id');
    const stockInfo = document.getElementById('stock-info');
    const quantityInput = document.getElementById('quantity');

    function updateStockInfo() {
        const selectedOption = productStockSelect.options[productStockSelect.selectedIndex];
        if (selectedOption && selectedOption.value) {
            const stock = selectedOption.dataset.stock || 0;
            stockInfo.textContent = `Stock disponible: ${stock} unités`;
            
            // Set max quantity
            quantityInput.setAttribute('max', stock);
        } else {
            stockInfo.textContent = '';
        }
    }

    productStockSelect.addEventListener('change', updateStockInfo);
    updateStockInfo();
});
</script>
@endpush
@endsection

