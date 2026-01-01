@extends('layouts.app')

@section('title', 'Modifier Commande - Co-op ERP')
@section('page-title', 'Modifier une Commande (Gestion Emballage)')

@section('content')
<div style="max-width: 1000px;">
    <div style="background: white; border-radius: 0.75rem; padding: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1);">
        
        <!-- Progress Steps -->
        <div style="display: flex; justify-content: space-between; margin-bottom: 2rem; position: relative;">
            <div style="position: absolute; top: 20px; left: 0; right: 0; height: 2px; background: #e5e7eb; z-index: 0;"></div>
            
            <div style="flex: 1; text-align: center; position: relative; z-index: 1;">
                <div class="step-circle" data-step="1" style="width: 40px; height: 40px; margin: 0 auto 0.5rem; border-radius: 50%; background: #2d7a52; color: white; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.875rem;">1</div>
                <p style="font-size: 0.75rem; color: #4b5563; font-weight: 500;">Client</p>
            </div>
            
            <div style="flex: 1; text-align: center; position: relative; z-index: 1;">
                <div class="step-circle" data-step="2" style="width: 40px; height: 40px; margin: 0 auto 0.5rem; border-radius: 50%; background: #e5e7eb; color: #4b5563; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.875rem;">2</div>
                <p style="font-size: 0.75rem; color: #4b5563; font-weight: 500;">Emballage</p>
            </div>
            
            <div style="flex: 1; text-align: center; position: relative; z-index: 1;">
                <div class="step-circle" data-step="3" style="width: 40px; height: 40px; margin: 0 auto 0.5rem; border-radius: 50%; background: #e5e7eb; color: #4b5563; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.875rem;">3</div>
                <p style="font-size: 0.75rem; color: #4b5563; font-weight: 500;">Quantité</p>
            </div>
            
            <div style="flex: 1; text-align: center; position: relative; z-index: 1;">
                <div class="step-circle" data-step="4" style="width: 40px; height: 40px; margin: 0 auto 0.5rem; border-radius: 50%; background: #e5e7eb; color: #4b5563; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.875rem;">4</div>
                <p style="font-size: 0.75rem; color: #4b5563; font-weight: 500;">Capsules</p>
            </div>
            
            <div style="flex: 1; text-align: center; position: relative; z-index: 1;">
                <div class="step-circle" data-step="5" style="width: 40px; height: 40px; margin: 0 auto 0.5rem; border-radius: 50%; background: #e5e7eb; color: #4b5563; display: flex; align-items: center; justify-content: center; font-weight: 600; font-size: 0.875rem;">5</div>
                <p style="font-size: 0.75rem; color: #4b5563; font-weight: 500;">Résumé</p>
            </div>
        </div>

        <form id="commandeForm" action="{{ route('commandes.update', $commande->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Step 1: Client Selection -->
            <div class="form-step" data-step="1" style="display: block;">
                <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #1f2937;">Étape 1: Sélectionner le client</h2>
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="client_id" style="display: block; font-size: 0.875rem; font-weight: 500; color: #4b5563; margin-bottom: 0.5rem;">Client <span style="color: #dc2626;">*</span></label>
                    <select name="client_id" id="client_id" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;">
                        <option value="">Sélectionner un client</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" {{ old('client_id', $commande->client_id) == $client->id ? 'selected' : '' }}>
                                {{ $client->name }} @if($client->email)- {{ $client->email }}@endif
                            </option>
                        @endforeach
                    </select>
                    @error('client_id')
                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Step 2: Packaging Selection (PILULIER + BOUCHON) -->
            <div class="form-step" data-step="2" style="display: none;">
                <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #1f2937;">Étape 2: Sélectionner les emballages</h2>
                
                <p style="color: #4b5563; font-size: 0.875rem; margin-bottom: 1rem;">Sélectionnez le PILULIER et le BOUCHON pour cette commande.</p>

                <!-- PILULIER Selection -->
                <div style="margin-bottom: 2rem; padding: 1.5rem; background: #f9fafb; border-radius: 0.75rem; border: 2px solid #e5e7eb;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">🥛 PILULIER <span style="color: #dc2626;">*</span></label>
                    
                    <select name="pilulier_product_stock_id" id="pilulier_product_stock_id" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none; margin-bottom: 0.5rem;">
                        <option value="">Sélectionner un PILULIER</option>
                        @foreach($piluliers as $pilulier)
                            @foreach($pilulier->stock as $stock)
                                @php
                                    $isSelected = false;
                                    foreach($commande->emballages as $ce) {
                                        if($ce->productStock->product->type_emballage === 'PILULIER' && $ce->product_stock_id == $stock->id) {
                                            $isSelected = true;
                                            break;
                                        }
                                    }
                                @endphp
                                <option value="{{ $stock->id }}" data-stock="{{ $stock->quantity }}" data-type="PILULIER" {{ $isSelected ? 'selected' : '' }}>
                                    {{ $pilulier->name }} - Stock: {{ $stock->quantity }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                    <p id="pilulier-stock-info" style="color: #6b7280; font-size: 0.75rem;"></p>
                    @error('pilulier_product_stock_id')
                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>

                <!-- BOUCHON Selection -->
                <div style="margin-bottom: 1.5rem; padding: 1.5rem; background: #f9fafb; border-radius: 0.75rem; border: 2px solid #e5e7eb;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">🔗 BOUCHON <span style="color: #dc2626;">*</span></label>
                    
                    <select name="bouchon_product_stock_id" id="bouchon_product_stock_id" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none; margin-bottom: 0.5rem;">
                        <option value="">Sélectionner un BOUCHON</option>
                        @foreach($bouchons as $bouchon)
                            @foreach($bouchon->stock as $stock)
                                @php
                                    $isSelected = false;
                                    foreach($commande->emballages as $ce) {
                                        if($ce->productStock->product->type_emballage === 'BOUCHON' && $ce->product_stock_id == $stock->id) {
                                            $isSelected = true;
                                            break;
                                        }
                                    }
                                @endphp
                                <option value="{{ $stock->id }}" data-stock="{{ $stock->quantity }}" data-type="BOUCHON" {{ $isSelected ? 'selected' : '' }}>
                                    {{ $bouchon->name }} - Stock: {{ $stock->quantity }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                    <p id="bouchon-stock-info" style="color: #6b7280; font-size: 0.75rem;"></p>
                    @error('bouchon_product_stock_id')
                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Step 3: Quantity Input (applies to BOTH packaging types) -->
            <div class="form-step" data-step="3" style="display: none;">
                <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #1f2937;">Étape 3: Quantité</h2>
                
                <p style="color: #4b5563; font-size: 0.875rem; margin-bottom: 1.5rem;"><strong>⚠️ Attention:</strong> Cette quantité s'applique aux DEUX emballages (PILULIER et BOUCHON).</p>

                <div style="margin-bottom: 1.5rem; padding: 1.5rem; background: #f0fdf4; border-radius: 0.75rem; border: 2px solid #86efac;">
                    <label for="quantity" style="display: block; font-size: 0.875rem; font-weight: 600; color: #1f2937; margin-bottom: 0.5rem;">Quantité (pour PILULIER ET BOUCHON) <span style="color: #dc2626;">*</span></label>
                    <input type="number" name="quantity" id="quantity" required min="1" value="{{ old('quantity', $commande->quantity) }}" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none; font-size: 1rem;">
                    <p id="quantity-info" style="color: #6b7280; font-size: 0.75rem; margin-top: 0.5rem;"></p>
                    @error('quantity')
                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Step 4: Filled Capsules Selection -->
            <div class="form-step" data-step="4" style="display: none;">
                <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #1f2937;">Étape 4: Capsules remplies</h2>
                
                <div style="margin-bottom: 1.5rem;">
                    <label for="filled_capsule_id" style="display: block; font-size: 0.875rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">Sélectionner les capsules remplies <span style="color: #dc2626;">*</span></label>
                    <select name="filled_capsule_id" id="filled_capsule_id" required style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none;">
                        <option value="">Sélectionner des capsules remplies</option>
                        @foreach($filledCapsules as $capsule)
                            @php
                                $isSelected = false;
                                if($commande->filledCapsules && $commande->filledCapsules->first()) {
                                    $isSelected = $commande->filledCapsules->first()->filled_capsule_id == $capsule->id;
                                }
                            @endphp
                            <option value="{{ $capsule->id }}" data-quantity="{{ $capsule->quantity }}" {{ $isSelected ? 'selected' : '' }}>
                                {{ $capsule->herb->name ?? 'Herbe inconnue' }} - Stock: {{ $capsule->quantity }} rangées
                            </option>
                        @endforeach
                    </select>
                    @error('filled_capsule_id')
                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                    <p id="capsule-info" style="color: #6b7280; font-size: 0.75rem; margin-top: 0.5rem;"></p>
                </div>

                <!-- Capsules Per Unit Selection -->
                <div style="margin-bottom: 1.5rem;">
                    <label style="display: block; font-size: 0.875rem; font-weight: 600; color: #1f2937; margin-bottom: 1rem;">Capsules par unité <span style="color: #dc2626;">*</span></label>
                    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1rem;">
                        @foreach($capsulesPerUnitOptions as $option)
                            <label style="display: flex; align-items: center; padding: 1rem; border: 2px solid #e5e7eb; border-radius: 0.5rem; cursor: pointer; transition: all 0.2s;">
                                <input type="radio" name="capsules_per_unit" value="{{ $option }}" required style="width: 1.25rem; height: 1.25rem; cursor: pointer;" {{ old('capsules_per_unit', $commande->capsules_per_unit) == $option ? 'checked' : '' }}>
                                <span style="margin-left: 0.75rem; font-weight: 500; color: #1f2937;">{{ $option }} capsules</span>
                            </label>
                        @endforeach
                    </div>
                    @error('capsules_per_unit')
                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Step 5: Summary -->
            <div class="form-step" data-step="5" style="display: none;">
                <h2 style="font-size: 1.25rem; font-weight: 600; margin-bottom: 1.5rem; color: #1f2937;">Étape 5: Résumé de la commande</h2>
                
                <div style="padding: 1.5rem; background: #f9fafb; border-radius: 0.75rem; border: 1px solid #e5e7eb; margin-bottom: 1.5rem;">
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                        <div>
                            <p style="font-size: 0.75rem; color: #6b7280; font-weight: 500; margin-bottom: 0.25rem;">CLIENT</p>
                            <p id="summary-client" style="font-size: 1rem; color: #1f2937; font-weight: 600;">-</p>
                        </div>
                        <div>
                            <p style="font-size: 0.75rem; color: #6b7280; font-weight: 500; margin-bottom: 0.25rem;">QUANTITÉ (×2 emballages)</p>
                            <p id="summary-quantity" style="font-size: 1rem; color: #1f2937; font-weight: 600;">-</p>
                        </div>
                        <div>
                            <p style="font-size: 0.75rem; color: #6b7280; font-weight: 500; margin-bottom: 0.25rem;">PILULIER</p>
                            <p id="summary-pilulier" style="font-size: 1rem; color: #1f2937; font-weight: 600;">-</p>
                        </div>
                        <div>
                            <p style="font-size: 0.75rem; color: #6b7280; font-weight: 500; margin-bottom: 0.25rem;">BOUCHON</p>
                            <p id="summary-bouchon" style="font-size: 1rem; color: #1f2937; font-weight: 600;">-</p>
                        </div>
                        <div>
                            <p style="font-size: 0.75rem; color: #6b7280; font-weight: 500; margin-bottom: 0.25rem;">CAPSULES REMPLIES</p>
                            <p id="summary-capsules" style="font-size: 1rem; color: #1f2937; font-weight: 600;">-</p>
                        </div>
                        <div>
                            <p style="font-size: 0.75rem; color: #6b7280; font-weight: 500; margin-bottom: 0.25rem;">TOTAL CAPSULES NEEDED</p>
                            <p id="summary-total-capsules" style="font-size: 1rem; color: #1f2937; font-weight: 600;">-</p>
                        </div>
                    </div>
                </div>

                <!-- Notes -->
                <div style="margin-bottom: 1.5rem;">
                    <label for="notes" style="display: block; font-size: 0.875rem; font-weight: 600; color: #1f2937; margin-bottom: 0.5rem;">Notes (optionnel)</label>
                    <textarea name="notes" id="notes" rows="3" style="width: 100%; padding: 0.75rem; border: 1px solid #d1d5db; border-radius: 0.5rem; outline: none; resize: vertical;">{{ old('notes', $commande->notes) }}</textarea>
                    @error('notes')
                        <p style="color: #dc2626; font-size: 0.75rem; margin-top: 0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div style="display: flex; gap: 1rem; border-top: 1px solid #e5e7eb; padding-top: 1.5rem;">
                <button type="button" id="prevBtn" style="background: white; color: #4b5563; padding: 0.75rem 2rem; border-radius: 0.5rem; border: 1px solid #d1d5db; font-weight: 500; cursor: pointer; display: none;">
                    ← Précédent
                </button>
                
                <button type="button" id="nextBtn" style="background: #2d7a52; color: white; padding: 0.75rem 2rem; border-radius: 0.5rem; border: none; font-weight: 500; cursor: pointer; margin-left: auto;">
                    Suivant →
                </button>
                
                <button type="submit" id="submitBtn" style="background: #059669; color: white; padding: 0.75rem 2rem; border-radius: 0.5rem; border: none; font-weight: 500; cursor: pointer; display: none;">
                    ✓ Mettre à jour
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
let currentStep = 1;
const totalSteps = 5;

const form = document.getElementById('commandeForm');
const prevBtn = document.getElementById('prevBtn');
const nextBtn = document.getElementById('nextBtn');
const submitBtn = document.getElementById('submitBtn');

// Elements for real-time info
const clientSelect = document.getElementById('client_id');
const quantityInput = document.getElementById('quantity');
const pilulierSelect = document.getElementById('pilulier_product_stock_id');
const bouchonSelect = document.getElementById('bouchon_product_stock_id');
const filledCapsuleSelect = document.getElementById('filled_capsule_id');
const capsulesPerUnitInputs = document.querySelectorAll('input[name="capsules_per_unit"]');

function showStep(step) {
    // Hide all steps
    document.querySelectorAll('.form-step').forEach(el => el.style.display = 'none');
    
    // Show current step
    document.querySelector(`.form-step[data-step="${step}"]`).style.display = 'block';
    
    // Update button visibility
    prevBtn.style.display = step > 1 ? 'block' : 'none';
    nextBtn.style.display = step < totalSteps ? 'block' : 'none';
    submitBtn.style.display = step === totalSteps ? 'block' : 'none';
    
    // Update progress indicator - update all circles
    document.querySelectorAll('.step-circle').forEach((circle) => {
        const stepNum = parseInt(circle.dataset.step);
        if (stepNum <= step) {
            circle.style.background = '#2d7a52';
            circle.style.color = 'white';
        } else {
            circle.style.background = '#e5e7eb';
            circle.style.color = '#4b5563';
        }
    });
    
    window.scrollTo(0, 0);
}

function validateStep(step) {
    const errors = [];
    
    if (step === 1) {
        if (!clientSelect.value) errors.push('Veuillez sélectionner un client');
    } else if (step === 2) {
        if (!pilulierSelect.value) errors.push('Veuillez sélectionner un PILULIER');
        if (!bouchonSelect.value) errors.push('Veuillez sélectionner un BOUCHON');
    } else if (step === 3) {
        if (!quantityInput.value || quantityInput.value < 1) errors.push('Veuillez entrer une quantité valide');
    } else if (step === 4) {
        if (!filledCapsuleSelect.value) errors.push('Veuillez sélectionner des capsules remplies');
        if (!document.querySelector('input[name="capsules_per_unit"]:checked')) errors.push('Veuillez sélectionner le nombre de capsules par unité');
    }
    
    if (errors.length > 0) {
        alert('Erreurs:\n- ' + errors.join('\n- '));
        return false;
    }
    return true;
}

function updateSummary() {
    // Client
    const clientOption = clientSelect.options[clientSelect.selectedIndex];
    document.getElementById('summary-client').textContent = clientOption.text || '-';
    
    // Quantity
    document.getElementById('summary-quantity').textContent = quantityInput.value ? quantityInput.value + ' × 2 emballages' : '-';
    
    // Pilulier
    const pilulierOption = pilulierSelect.options[pilulierSelect.selectedIndex];
    document.getElementById('summary-pilulier').textContent = pilulierOption.text?.split(' - Stock')[0] || '-';
    
    // Bouchon
    const bouchonOption = bouchonSelect.options[bouchonSelect.selectedIndex];
    document.getElementById('summary-bouchon').textContent = bouchonOption.text?.split(' - Stock')[0] || '-';
    
    // Capsules
    const capsuleOption = filledCapsuleSelect.options[filledCapsuleSelect.selectedIndex];
    document.getElementById('summary-capsules').textContent = capsuleOption.text?.split(' - Stock')[0] || '-';
    
    // Total capsules needed
    const capsulesPer = document.querySelector('input[name="capsules_per_unit"]:checked')?.value || 0;
    const qty = quantityInput.value || 0;
    const totalCapsules = qty * capsulesPer;
    document.getElementById('summary-total-capsules').textContent = totalCapsules + ' capsules';
}

function updateStockInfo() {
    const pilulierOption = pilulierSelect.options[pilulierSelect.selectedIndex];
    const bouchonOption = bouchonSelect.options[bouchonSelect.selectedIndex];
    const capsuleOption = filledCapsuleSelect.options[filledCapsuleSelect.selectedIndex];
    const capsulesPer = document.querySelector('input[name="capsules_per_unit"]:checked')?.value || 30;
    const qty = quantityInput.value || 0;
    
    if (pilulierOption.dataset.stock) {
        document.getElementById('pilulier-stock-info').textContent = `Stock disponible: ${pilulierOption.dataset.stock} unités`;
    }
    
    if (bouchonOption.dataset.stock) {
        document.getElementById('bouchon-stock-info').textContent = `Stock disponible: ${bouchonOption.dataset.stock} unités`;
    }
    
    if (capsuleOption.dataset.quantity) {
        const totalNeeded = qty * capsulesPer;
        document.getElementById('capsule-info').textContent = `Stock: ${capsuleOption.dataset.quantity} rangées | Besoin: ${totalNeeded} capsules`;
    }
    
    if (qty > 0 && capsulesPer) {
        document.getElementById('quantity-info').textContent = `Total: ${qty} × ${capsulesPer} = ${qty * capsulesPer} capsules`;
    }
}

prevBtn.addEventListener('click', () => {
    if (currentStep > 1) {
        currentStep--;
        showStep(currentStep);
    }
});

nextBtn.addEventListener('click', () => {
    if (validateStep(currentStep) && currentStep < totalSteps) {
        currentStep++;
        updateSummary();
        updateStockInfo();
        showStep(currentStep);
    }
});

// Event listeners for real-time updates
[quantityInput, filledCapsuleSelect, ...capsulesPerUnitInputs].forEach(el => {
    el.addEventListener('change', updateStockInfo);
});

[clientSelect, pilulierSelect, bouchonSelect, filledCapsuleSelect].forEach(el => {
    el.addEventListener('change', updateSummary);
});

submitBtn.addEventListener('click', (e) => {
    if (!validateStep(5)) {
        e.preventDefault();
    }
});

showStep(1);
updateSummary();
updateStockInfo();
</script>
@endpush
@endsection

