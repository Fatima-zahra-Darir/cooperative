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

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware(['auth', 'verified', 'superadmin'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Stock Management
    Route::get('/stock', [StockController::class, 'index'])->name('stock.index');

    // Products
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    // Clients
    Route::get('/clients', [ClientController::class, 'index'])->name('clients.index');

    // Revenue
    Route::get('/revenue', [RevenueController::class, 'index'])->name('revenue.index');

    // Expenses
    Route::get('/expenses', [ExpenseController::class, 'index'])->name('expenses.index');

    // Reports & Statistics
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

    // ONCA Documents
    Route::get('/onca', [OncaController::class, 'index'])->name('onca.index');

    // Archives
    Route::get('/archives', [ArchiveController::class, 'index'])->name('archives.index');

    // Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
});

require __DIR__.'/auth.php';
