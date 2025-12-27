@extends('layouts.app')

@section('title', 'Ajouter Stock Produit - Co-op ERP')
@section('page-title', 'Ajouter Stock Produit')

@section('content')
<div style="max-width: 800px;">
    <div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #1f2937;">Informations du stock</h2>
        
        <form action="{{ route('stock-produit.store') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 1.5rem;">
                <label for="product_id" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Produit</label>
                <select name="product_id" id="product_id" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;">
                    <option value="">Sélectionner un produit</option>
                    @foreach($products as $product)
                        <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>{{ $product->name }}</option>
                    @endforeach
                </select>
                @error('product_id')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="category_id" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Catégorie</label>
                <select name="category_id" id="category_id" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;">
                    <option value="">Sélectionner une catégorie</option>
                </select>
                @error('category_id')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="color_id" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Couleur</label>
                <select name="color_id" id="color_id" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;">
                    <option value="">Sélectionner une couleur</option>
                </select>
                @error('color_id')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="size_id" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Taille</label>
                <select name="size_id" id="size_id" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;">
                    <option value="">Sélectionner une taille</option>
                </select>
                @error('size_id')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="quantity" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Quantité</label>
                <input type="number" name="quantity" id="quantity" required min="0" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;" placeholder="0" value="{{ old('quantity') }}">
                @error('quantity')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="fornisseur_id" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Fournisseur</label>
                <select name="fornisseur_id" id="fornisseur_id" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none; transition: border-color 0.2s;">
                    <option value="">Sélectionner un fournisseur (optionnel)</option>
                    @foreach($fornisseurs as $fornisseur)
                        <option value="{{ $fornisseur->id }}" {{ old('fornisseur_id') == $fornisseur->id ? 'selected' : '' }}>
                            {{ $fornisseur->name }}@if($fornisseur->ville) - {{ $fornisseur->ville }}@endif
                        </option>
                    @endforeach
                </select>
                @error('fornisseur_id')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="margin-bottom: 1.5rem;">
                <label for="notes" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Notes (optionnel)</label>
                <textarea name="notes" id="notes" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none; resize: vertical;">{{ old('notes') }}</textarea>
                @error('notes')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: flex; gap: 1rem; border-top: 1px solid #e5e7eb; padding-top: 1.5rem;">
                <button type="submit" style="background: #2d7a52; color: white; padding: 0.75rem 2rem; border-radius: 0.5rem; border: none; font-weight: 500; cursor: pointer;">
                    Enregistrer le stock
                </button>
                <a href="{{ route('stock-produit.index') }}" style="background: white; color: #4b5563; padding: 0.75rem 2rem; border-radius: 0.5rem; border: 1px solid #d1d5db; text-decoration: none; font-weight: 500; text-align: center;">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const categorySelect = document.getElementById('category_id');
    const colorSelect = document.getElementById('color_id');
    const sizeSelect = document.getElementById('size_id');

    // Store old values for restoration after product change
    const oldCategoryId = @json(old('category_id'));
    const oldColorId = @json(old('color_id'));
    const oldSizeId = @json(old('size_id'));

    function clearSelect(select) {
        select.innerHTML = '<option value="">Sélectionner ' + (select.id === 'category_id' ? 'une catégorie' : select.id === 'color_id' ? 'une couleur' : 'une taille') + '</option>';
    }

    function loadProductAttributes(productId) {
        if (!productId) {
            clearSelect(categorySelect);
            clearSelect(colorSelect);
            clearSelect(sizeSelect);
            return;
        }

        fetch(`/stock-produit/product/${productId}/attributes`)
            .then(response => response.json())
            .then(data => {
                // Populate categories
                clearSelect(categorySelect);
                data.categories.forEach(category => {
                    const option = document.createElement('option');
                    option.value = category.id;
                    option.textContent = category.name;
                    if (oldCategoryId && category.id == oldCategoryId) {
                        option.selected = true;
                    }
                    categorySelect.appendChild(option);
                });

                // Populate colors
                clearSelect(colorSelect);
                data.colors.forEach(color => {
                    const option = document.createElement('option');
                    option.value = color.id;
                    option.textContent = color.name;
                    if (oldColorId && color.id == oldColorId) {
                        option.selected = true;
                    }
                    colorSelect.appendChild(option);
                });

                // Populate sizes
                clearSelect(sizeSelect);
                data.sizes.forEach(size => {
                    const option = document.createElement('option');
                    option.value = size.id;
                    option.textContent = size.name;
                    if (oldSizeId && size.id == oldSizeId) {
                        option.selected = true;
                    }
                    sizeSelect.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error loading product attributes:', error);
            });
    }

    // Load attributes when product is selected
    productSelect.addEventListener('change', function() {
        loadProductAttributes(this.value);
    });

    // Load attributes on page load if product is already selected
    if (productSelect.value) {
        loadProductAttributes(productSelect.value);
    }
});
</script>
@endsection

