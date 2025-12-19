@extends('layouts.app')

@section('title', 'Nouveau Produit - Co-op ERP')
@section('page-title', 'Ajouter un Produit')

@section('content')
<div style="max-width: 800px;">
    <div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #1f2937;">Informations du produit</h2>
        
        <form action="{{ route('products.store') }}" method="POST">
            @csrf
            
            <div style="margin-bottom: 1.5rem;">
                <label for="name" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Nom du produit</label>
                <input type="text" name="name" id="name" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;" placeholder="ex: Pantalon Chino" value="{{ old('name') }}">
                @error('name')
                    <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <div style="display: flex; flex-direction: column; gap: 1.5rem; margin-bottom: 2rem;">
                <!-- Catégories -->
                <div class="field-container">
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Catégories</label>
                    <div class="custom-select-wrapper" data-name="categories">
                        <div class="selected-items"></div>
                        <div class="input-wrapper">
                            <input type="text" class="search-input" placeholder="Sélectionner des catégories...">
                            <div class="options-dropdown">
                                @foreach($categories as $category)
                                    <div class="option" data-value="{{ $category->id }}" data-text="{{ $category->name }}">{{ $category->name }}</div>
                                @endforeach
                            </div>
                        </div>
                        <select name="categories[]" multiple hidden required></select>
                    </div>
                    @error('categories')
                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Couleurs -->
                <div class="field-container">
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Couleurs</label>
                    <div class="custom-select-wrapper" data-name="colors">
                        <div class="selected-items"></div>
                        <div class="input-wrapper">
                            <input type="text" class="search-input" placeholder="Sélectionner des couleurs...">
                            <div class="options-dropdown">
                                @foreach($colors as $color)
                                    <div class="option" data-value="{{ $color->id }}" data-text="{{ $color->name }}">{{ $color->name }}</div>
                                @endforeach
                            </div>
                        </div>
                        <select name="colors[]" multiple hidden required></select>
                    </div>
                    @error('colors')
                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tailles -->
                <div class="field-container">
                    <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Tailles</label>
                    <div class="custom-select-wrapper" data-name="sizes">
                        <div class="selected-items"></div>
                        <div class="input-wrapper">
                            <input type="text" class="search-input" placeholder="Sélectionner des tailles...">
                            <div class="options-dropdown">
                                @foreach($sizes as $size)
                                    <div class="option" data-value="{{ $size->id }}" data-text="{{ $size->name }}">{{ $size->name }}</div>
                                @endforeach
                            </div>
                        </div>
                        <select name="sizes[]" multiple hidden required></select>
                    </div>
                    @error('sizes')
                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div style="display: flex; gap: 1rem; border-top: 1px solid #e5e7eb; padding-top: 1.5rem;">
                <button type="submit" style="background: #2d7a52; color: white; padding: 0.75rem 2rem; border-radius: 0.5rem; border: none; font-weight: 500; cursor: pointer;">
                    Enregistrer le produit
                </button>
                <a href="{{ route('products.index') }}" style="background: white; color: #4b5563; padding: 0.75rem 2rem; border-radius: 0.5rem; border: 1px solid #d1d5db; text-decoration: none; font-weight: 500; text-align: center;">
                    Annuler
                </a>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
    .custom-select-wrapper {
        position: relative;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        background: white;
        padding: 0.375rem;
        min-height: 42px;
        display: flex;
        flex-wrap: wrap;
        gap: 0.375rem;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .custom-select-wrapper:focus-within {
        border-color: #2d7a52;
        box-shadow: 0 0 0 3px rgba(45, 122, 82, 0.1);
    }

    .selected-items {
        display: flex;
        flex-wrap: wrap;
        gap: 0.375rem;
    }

    .tag {
        display: inline-flex;
        align-items: center;
        background: #f0fdf4;
        color: #166534;
        padding: 0.25rem 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.875rem;
        font-weight: 500;
        border: 1px solid #bbf7d0;
        animation: slideIn 0.2s ease-out;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .tag .remove-btn {
        margin-left: 0.375rem;
        cursor: pointer;
        color: #166534;
        opacity: 0.6;
        font-size: 1.1rem;
        line-height: 1;
    }

    .tag .remove-btn:hover {
        opacity: 1;
    }

    .input-wrapper {
        flex: 1;
        min-width: 120px;
        position: relative;
    }

    .search-input {
        width: 100%;
        border: none;
        padding: 0.375rem;
        outline: none;
        font-size: 0.875rem;
    }

    .options-dropdown {
        position: absolute;
        top: calc(100% + 0.5rem);
        left: -0.375rem;
        right: -0.375rem;
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 0.5rem;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        z-index: 50;
        max-height: 200px;
        overflow-y: auto;
        display: none;
    }

    .options-dropdown.show {
        display: block;
    }

    .option {
        padding: 0.625rem 1rem;
        cursor: pointer;
        font-size: 0.875rem;
        transition: background 0.2s;
    }

    .option:hover {
        background: #f9fafb;
    }

    .option.selected {
        background: #f0fdf4;
        color: #2d7a52;
        font-weight: 500;
        pointer-events: none;
    }

    .option.hidden {
        display: none;
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const wrappers = document.querySelectorAll('.custom-select-wrapper');

        wrappers.forEach(wrapper => {
            const input = wrapper.querySelector('.search-input');
            const dropdown = wrapper.querySelector('.options-dropdown');
            const selectedContainer = wrapper.querySelector('.selected-items');
            const select = wrapper.querySelector('select');
            const options = Array.from(wrapper.querySelectorAll('.option'));

            const updateSelect = () => {
                select.innerHTML = '';
                const tags = selectedContainer.querySelectorAll('.tag');
                tags.forEach(tag => {
                    const opt = document.createElement('option');
                    opt.value = tag.dataset.value;
                    opt.selected = true;
                    select.appendChild(opt);
                });
            };

            const addTag = (value, text) => {
                if (selectedContainer.querySelector(`[data-value="${value}"]`)) return;

                const tag = document.createElement('div');
                tag.className = 'tag';
                tag.dataset.value = value;
                tag.innerHTML = `
                    <span>${text}</span>
                    <span class="remove-btn">&times;</span>
                `;

                tag.querySelector('.remove-btn').onclick = () => {
                    tag.remove();
                    options.forEach(opt => {
                        if (opt.dataset.value === value) opt.classList.remove('selected');
                    });
                    updateSelect();
                };

                selectedContainer.appendChild(tag);
                updateSelect();
                
                // Mark option as selected
                options.forEach(opt => {
                    if (opt.dataset.value === value) opt.classList.add('selected');
                });
            };

            input.onfocus = () => dropdown.classList.add('show');
            
            // Handle clicks outside
            document.addEventListener('click', (e) => {
                if (!wrapper.contains(e.target)) {
                    dropdown.classList.remove('show');
                }
            });

            input.oninput = (e) => {
                const term = e.target.value.toLowerCase();
                options.forEach(opt => {
                    const text = opt.dataset.text.toLowerCase();
                    opt.classList.toggle('hidden', !text.includes(term));
                });
                dropdown.classList.add('show');
            };

            options.forEach(opt => {
                opt.onclick = () => {
                    addTag(opt.dataset.value, opt.dataset.text);
                    input.value = '';
                    options.forEach(o => o.classList.remove('hidden'));
                    dropdown.classList.remove('show');
                    input.focus();
                };
            });
        });
    });
</script>
@endpush
@endsection
