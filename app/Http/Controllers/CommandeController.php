<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\CommandeEmballage;
use App\Models\CommandeFilledCapsule;
use App\Models\Client;
use App\Models\Product;
use App\Models\ProductStock;
use App\Models\FilledCapsule;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CommandeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $commandes = Commande::with([
                'client',
                'emballages.productStock.product',
                'filledCapsules.filledCapsule'
            ])
            ->latest()
            ->get();
        return view('commandes.index', compact('commandes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clients = Client::orderBy('name')->get();
        
        // Get PILULIER products with their stock
        $piluliers = Product::where('type_emballage', 'PILULIER')
            ->with('stock')
            ->get();
        
        // Get BOUCHON products with their stock
        $bouchons = Product::where('type_emballage', 'BOUCHON')
            ->with('stock')
            ->get();
        
        // Get filled capsules for selection
        $filledCapsules = FilledCapsule::with(['herb', 'capsule'])->get();
        
        // Capsules per unit options
        $capsulesPerUnitOptions = [30, 60, 120];
        
        return view('commandes.create', compact(
            'clients',
            'piluliers',
            'bouchons',
            'filledCapsules',
            'capsulesPerUnitOptions'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \Log::info('COMMANDE STORE: Request received', $request->all());
        
        // Validation
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'quantity' => 'required|integer|min:1',
            'capsules_per_unit' => 'required|integer|in:30,60,120',
            'pilulier_product_stock_id' => 'required|exists:product_stock,id',
            'bouchon_product_stock_id' => 'required|exists:product_stock,id',
            'filled_capsule_id' => 'required|exists:filled_capsules,id',
            'notes' => 'nullable|string',
        ]);
        
        \Log::info('COMMANDE STORE: Validation passed', $validated);

        try {
            DB::beginTransaction();
            \Log::info('COMMANDE STORE: Transaction started');

            $quantity = $request->quantity;
            $capsulesPerUnit = $request->capsules_per_unit;
            $totalCapsulesNeeded = $quantity * $capsulesPerUnit;
            \Log::info('COMMANDE STORE: Variables set', ['quantity' => $quantity, 'capsules_per_unit' => $capsulesPerUnit]);

            // Get product stocks
            $pilulierStock = ProductStock::findOrFail($request->pilulier_product_stock_id);
            $bouchonStock = ProductStock::findOrFail($request->bouchon_product_stock_id);
            $filledCapsule = FilledCapsule::findOrFail($request->filled_capsule_id);
            \Log::info('COMMANDE STORE: Stock records found');

            // Verify products are correct type
            if ($pilulierStock->product->type_emballage !== 'PILULIER') {
                throw new \Exception('Le stock sélectionné pour PILULIER est invalide.');
            }
            if ($bouchonStock->product->type_emballage !== 'BOUCHON') {
                throw new \Exception('Le stock sélectionné pour BOUCHON est invalide.');
            }
            \Log::info('COMMANDE STORE: Product types verified');

            // Check stock availability
            if ($quantity > $pilulierStock->quantity) {
                \Log::warning('COMMANDE STORE: PILULIER stock insufficient');
                return back()->withErrors([
                    'pilulier_product_stock_id' => 'Stock PILULIER insuffisant. Disponible: ' . $pilulierStock->quantity
                ])->withInput();
            }
            if ($quantity > $bouchonStock->quantity) {
                \Log::warning('COMMANDE STORE: BOUCHON stock insufficient');
                return back()->withErrors([
                    'bouchon_product_stock_id' => 'Stock BOUCHON insuffisant. Disponible: ' . $bouchonStock->quantity
                ])->withInput();
            }
            if ($totalCapsulesNeeded > $filledCapsule->quantity) {
                \Log::warning('COMMANDE STORE: Capsules insufficient');
                return back()->withErrors([
                    'filled_capsule_id' => 'Quantité de capsules insuffisante. Disponible: ' . $filledCapsule->quantity
                ])->withInput();
            }
            \Log::info('COMMANDE STORE: Stock availability verified');

            // Create commande
            \Log::info('COMMANDE STORE: About to create commande', [
                'client_id' => $request->client_id,
                'product_stock_id' => $request->pilulier_product_stock_id,
                'quantity' => $quantity,
                'capsules_per_unit' => $capsulesPerUnit,
                'status' => 'en attente',
                'notes' => $request->notes,
            ]);
            
            $commande = Commande::create([
                'client_id' => $request->client_id,
                'product_stock_id' => $request->pilulier_product_stock_id, // Reference to main stock
                'quantity' => $quantity,
                'capsules_per_unit' => $capsulesPerUnit,
                'status' => 'en attente',
                'notes' => $request->notes,
            ]);
            
            \Log::info('COMMANDE STORE: Commande created', ['id' => $commande->id, 'client_id' => $commande->client_id]);

            // Create emballage records (PILULIER and BOUCHON)
            CommandeEmballage::create([
                'commande_id' => $commande->id,
                'product_stock_id' => $request->pilulier_product_stock_id,
                'quantity' => $quantity,
            ]);

            CommandeEmballage::create([
                'commande_id' => $commande->id,
                'product_stock_id' => $request->bouchon_product_stock_id,
                'quantity' => $quantity,
            ]);

            // Create filled capsule record
            CommandeFilledCapsule::create([
                'commande_id' => $commande->id,
                'filled_capsule_id' => $request->filled_capsule_id,
                'quantity' => $totalCapsulesNeeded,
            ]);

            // Create stock movements to deduct from stock
            // PILULIER deduction
            $pilulierStock->decrement('quantity', $quantity);
            StockMovement::create([
                'product_stock_id' => $request->pilulier_product_stock_id,
                'type' => 'usage',
                'quantity' => $quantity,
                'movement_date' => now(),
                'notes' => 'Commande #' . $commande->id . ' - PILULIER - ' . ($request->notes ?? ''),
            ]);

            // BOUCHON deduction
            $bouchonStock->decrement('quantity', $quantity);
            StockMovement::create([
                'product_stock_id' => $request->bouchon_product_stock_id,
                'type' => 'usage',
                'quantity' => $quantity,
                'movement_date' => now(),
                'notes' => 'Commande #' . $commande->id . ' - BOUCHON - ' . ($request->notes ?? ''),
            ]);

            // FilledCapsule deduction - just decrement quantity, no stock movement needed
            $filledCapsule->decrement('quantity', $totalCapsulesNeeded);
            
            \Log::info('COMMANDE STORE: Stock decremented', [
                'pilulier_decrement' => $quantity,
                'bouchon_decrement' => $quantity,
                'capsules_decrement' => $totalCapsulesNeeded
            ]);
            
            DB::commit();

            \Log::info('COMMANDE STORE: SUCCESS - Commande created with ID: ' . $commande->id);

            return redirect()->route('commandes.index')
                ->with('success', 'Commande créée avec succès. PILULIER: ' . $quantity . 'x, BOUCHON: ' . $quantity . 'x, Capsules: ' . $totalCapsulesNeeded . 'x');

        } catch (\Exception $e) {
            \Log::error('COMMANDE STORE: ERROR - ' . $e->getMessage(), ['exception' => $e]);
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur lors de la création: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Commande $commande)
    {
        $commande->load([
            'client',
            'emballages.productStock.product',
            'filledCapsules.filledCapsule.herb'
        ]);
        return view('commandes.show', compact('commande'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Commande $commande)
    {
        $commande->load([
            'client',
            'emballages.productStock.product',
            'filledCapsules.filledCapsule'
        ]);
        
        $clients = Client::orderBy('name')->get();
        
        // Get PILULIER products with their stock
        $piluliers = Product::where('type_emballage', 'PILULIER')
            ->with('stock')
            ->get();
        
        // Get BOUCHON products with their stock
        $bouchons = Product::where('type_emballage', 'BOUCHON')
            ->with('stock')
            ->get();
        
        // Get filled capsules for selection
        $filledCapsules = FilledCapsule::with(['herb', 'capsule'])->get();
        
        // Capsules per unit options
        $capsulesPerUnitOptions = [30, 60, 120];
        
        return view('commandes.edit', compact(
            'commande',
            'clients',
            'piluliers',
            'bouchons',
            'filledCapsules',
            'capsulesPerUnitOptions'
        ));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Commande $commande)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,id',
            'quantity' => 'required|integer|min:1',
            'capsules_per_unit' => 'required|integer|in:30,60,120',
            'pilulier_product_stock_id' => 'required|exists:product_stock,id',
            'bouchon_product_stock_id' => 'required|exists:product_stock,id',
            'filled_capsule_id' => 'required|exists:filled_capsules,id',
            'notes' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $oldQuantity = $commande->quantity;
            $oldCapsulesPerUnit = $commande->capsules_per_unit;
            $oldTotalCapsules = $oldQuantity * $oldCapsulesPerUnit;

            $newQuantity = $request->quantity;
            $newCapsulesPerUnit = $request->capsules_per_unit;
            $newTotalCapsules = $newQuantity * $newCapsulesPerUnit;

            $isCancelled = $commande->status === 'annulé';

            if (!$isCancelled) {
                // Get new stocks
                $newPilulierStock = ProductStock::findOrFail($request->pilulier_product_stock_id);
                $newBouchonStock = ProductStock::findOrFail($request->bouchon_product_stock_id);
                $newFilledCapsule = FilledCapsule::findOrFail($request->filled_capsule_id);

                // Verify products are correct type
                if ($newPilulierStock->product->type_emballage !== 'PILULIER') {
                    throw new \Exception('Le stock sélectionné pour PILULIER est invalide.');
                }
                if ($newBouchonStock->product->type_emballage !== 'BOUCHON') {
                    throw new \Exception('Le stock sélectionné pour BOUCHON est invalide.');
                }

                // Get old emballages
                $oldEmballages = $commande->emballages()->with('productStock')->get();
                $oldPilulierStock = null;
                $oldBouchonStock = null;

                foreach ($oldEmballages as $emballage) {
                    if ($emballage->productStock->product->type_emballage === 'PILULIER') {
                        $oldPilulierStock = $emballage->productStock;
                    } elseif ($emballage->productStock->product->type_emballage === 'BOUCHON') {
                        $oldBouchonStock = $emballage->productStock;
                    }
                }

                // Get old filled capsule
                $oldFilledCapsuleRecord = $commande->filledCapsules()->first();
                $oldFilledCapsule = $oldFilledCapsuleRecord ? $oldFilledCapsuleRecord->filledCapsule : null;

                // Restore old stock
                if ($oldPilulierStock) {
                    $oldPilulierStock->increment('quantity', $oldQuantity);
                    StockMovement::create([
                        'product_stock_id' => $oldPilulierStock->id,
                        'type' => 'restock',
                        'quantity' => $oldQuantity,
                        'movement_date' => now(),
                        'notes' => 'Commande #' . $commande->id . ' mise à jour - PILULIER',
                    ]);
                }

                if ($oldBouchonStock) {
                    $oldBouchonStock->increment('quantity', $oldQuantity);
                    StockMovement::create([
                        'product_stock_id' => $oldBouchonStock->id,
                        'type' => 'restock',
                        'quantity' => $oldQuantity,
                        'movement_date' => now(),
                        'notes' => 'Commande #' . $commande->id . ' mise à jour - BOUCHON',
                    ]);
                }

                if ($oldFilledCapsule) {
                    $oldFilledCapsule->increment('quantity', $oldTotalCapsules);
                }

                // Check new stock availability
                if ($newQuantity > $newPilulierStock->quantity) {
                    throw new \Exception('Stock PILULIER insuffisant. Disponible: ' . $newPilulierStock->quantity);
                }
                if ($newQuantity > $newBouchonStock->quantity) {
                    throw new \Exception('Stock BOUCHON insuffisant. Disponible: ' . $newBouchonStock->quantity);
                }
                if ($newTotalCapsules > $newFilledCapsule->quantity) {
                    throw new \Exception('Quantité de capsules insuffisante. Disponible: ' . $newFilledCapsule->quantity);
                }

                // Decrement new stock
                $newPilulierStock->decrement('quantity', $newQuantity);
                StockMovement::create([
                    'product_stock_id' => $request->pilulier_product_stock_id,
                    'type' => 'usage',
                    'quantity' => $newQuantity,
                    'movement_date' => now(),
                    'notes' => 'Commande #' . $commande->id . ' - PILULIER - ' . ($request->notes ?? ''),
                ]);

                $newBouchonStock->decrement('quantity', $newQuantity);
                StockMovement::create([
                    'product_stock_id' => $request->bouchon_product_stock_id,
                    'type' => 'usage',
                    'quantity' => $newQuantity,
                    'movement_date' => now(),
                    'notes' => 'Commande #' . $commande->id . ' - BOUCHON - ' . ($request->notes ?? ''),
                ]);

                $newFilledCapsule->decrement('quantity', $newTotalCapsules);
            }

            // Update commande
            $commande->update([
                'client_id' => $request->client_id,
                'quantity' => $newQuantity,
                'capsules_per_unit' => $newCapsulesPerUnit,
                'notes' => $request->notes,
            ]);

            // Update emballages
            $commande->emballages()->delete();
            CommandeEmballage::create([
                'commande_id' => $commande->id,
                'product_stock_id' => $request->pilulier_product_stock_id,
                'quantity' => $newQuantity,
            ]);
            CommandeEmballage::create([
                'commande_id' => $commande->id,
                'product_stock_id' => $request->bouchon_product_stock_id,
                'quantity' => $newQuantity,
            ]);

            // Update filled capsules
            $commande->filledCapsules()->delete();
            CommandeFilledCapsule::create([
                'commande_id' => $commande->id,
                'filled_capsule_id' => $request->filled_capsule_id,
                'quantity' => $newTotalCapsules,
            ]);

            DB::commit();

            return redirect()->route('commandes.index')
                ->with('success', 'Commande mise à jour avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur lors de la mise à jour: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Commande $commande)
    {
        try {
            DB::beginTransaction();

            $isCancelled = $commande->status === 'annulé';

            if (!$isCancelled) {
                // Restore all stock
                $emballages = $commande->emballages()->with('productStock')->get();
                
                foreach ($emballages as $emballage) {
                    $emballage->productStock->increment('quantity', $emballage->quantity);
                    StockMovement::create([
                        'product_stock_id' => $emballage->product_stock_id,
                        'type' => 'restock',
                        'quantity' => $emballage->quantity,
                        'movement_date' => now(),
                        'notes' => 'Commande #' . $commande->id . ' supprimée',
                    ]);
                }

                // Restore filled capsules
                $filledCapsuleRecords = $commande->filledCapsules()->with('filledCapsule')->get();
                foreach ($filledCapsuleRecords as $record) {
                    $record->filledCapsule->increment('quantity', $record->quantity);
                }
            }

            $commande->delete();
            
            DB::commit();

            return redirect()->route('commandes.index')
                ->with('success', 'Commande supprimée avec succès.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Erreur lors de la suppression: ' . $e->getMessage()]);
        }
    }

    /**
     * Update commande status via AJAX
     */
    public function updateStatus(Request $request, Commande $commande)
    {
        try {
            $request->validate([
                'status' => 'required|in:en attente,en cours,livré,annulé',
            ]);

            $oldStatus = $commande->status;
            $newStatus = $request->status;

            // If changing from cancelled to not cancelled, deduct stock again
            if ($oldStatus === 'annulé' && $newStatus !== 'annulé') {
                $commande->load('emballages.productStock', 'filledCapsules.filledCapsule');
                
                $quantity = $commande->quantity;
                $totalCapsules = $quantity * $commande->capsules_per_unit;

                foreach ($commande->emballages as $emballage) {
                    if ($emballage->quantity > $emballage->productStock->global_quantity) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Stock insuffisant pour ' . $emballage->productStock->product->name
                        ], 400);
                    }

                    StockMovement::create([
                        'product_stock_id' => $emballage->product_stock_id,
                        'type' => 'usage',
                        'quantity' => $emballage->quantity,
                        'movement_date' => now(),
                        'notes' => 'Commande #' . $commande->id . ' - réactivée de annulé',
                    ]);
                }

                foreach ($commande->filledCapsules as $record) {
                    $record->filledCapsule->decrement('quantity', $record->quantity);
                }
            }
            
            // If changing to cancelled, restore stock
            if ($oldStatus !== 'annulé' && $newStatus === 'annulé') {
                $commande->load('emballages', 'filledCapsules.filledCapsule');
                
                foreach ($commande->emballages as $emballage) {
                    StockMovement::create([
                        'product_stock_id' => $emballage->product_stock_id,
                        'type' => 'restock',
                        'quantity' => $emballage->quantity,
                        'movement_date' => now(),
                        'notes' => 'Commande #' . $commande->id . ' - annulée',
                    ]);
                }

                foreach ($commande->filledCapsules as $record) {
                    $record->filledCapsule->increment('quantity', $record->quantity);
                }
            }

            $commande->update(['status' => $newStatus]);

            return response()->json([
                'success' => true,
                'message' => 'Statut mis à jour avec succès.',
                'status' => $newStatus
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Une erreur est survenue: ' . $e->getMessage()
            ], 500);
        }
    }
}

