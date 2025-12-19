<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\RevenueController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\OncaController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\StockProduitController;
use App\Http\Controllers\StockCapsuleController;

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'verified', 'superadmin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Stock Management
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');
    Route::resource('stock-produit', StockProduitController::class);
    Route::resource('stock-capsules', StockCapsuleController::class);

    // Products
    Route::resource('products', ProductController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('colors', ColorController::class);
    Route::resource('sizes', SizeController::class);

    // Clients
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');

    // Revenue
    Route::get('/revenue', [RevenueController::class, 'index'])->name('revenue.index');

    // Expenses
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');

    // Reports & Statistics
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // ONCA Documents
    // ONCA Documents
    Route::get('/onca/create/{type}', [OncaController::class, 'createForm'])->name('onca.create-form');
    Route::get('/onca/{onca}/print', [OncaController::class, 'print'])->name('onca.print');
    Route::resource('onca', OncaController::class);

    // Archives
    Route::get('/archives', [ArchiveController::class, 'index'])->name('archives.index');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
});

require __DIR__.'/auth.php';
