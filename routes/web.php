<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\Auth\StaffLoginController;
use App\Http\Controllers\Auth\StaffRegisterController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ExpenseController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;

// Public Routes
Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Authentication for Staff
Route::get('staff/login', [StaffLoginController::class, 'showLoginForm'])->name('staff.login');
Route::post('staff/login', [StaffLoginController::class, 'login'])->middleware('guest:staff');
Route::post('staff/logout', [StaffLoginController::class, 'logout'])->name('staff.logout');


// Registration for Staff (Optional: Disable if you don’t want public staff registration)
Route::get('staff/register', [StaffRegisterController::class, 'showRegistrationForm'])->name('staff.register');
Route::post('staff/register', [StaffRegisterController::class, 'register']);

// Middleware-Protected Routes (Staff-Only)

    // Staff Management
    Route::resource('staff', StaffController::class);

    // Inventory Management
    Route::get('/inventory', [MedicineController::class, 'index'])->name('inventory.index');
    Route::get('/inventory/create', [MedicineController::class, 'create'])->name('inventory.create');
    Route::post('/inventory', [MedicineController::class, 'store'])->name('inventory.store');
    Route::get('/inventory/{id}/edit', [MedicineController::class, 'edit'])->name('inventory.edit');
    Route::put('/inventory/{id}', [MedicineController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}', [MedicineController::class, 'destroy'])->name('inventory.destroy');
    // sale management
    Route::get('/sales', [SaleController::class, 'index'])->name('sales.index'); // List all sales
    Route::get('/sales/create', [SaleController::class, 'create'])->name('sales.create'); // Show create sale form
    Route::post('/sales', [SaleController::class, 'store'])->name('sales.store'); // Store new sale
    Route::get('/sales/{id}', [SaleController::class, 'show'])->name('sales.show'); // View specific sale
    Route::get('/sales/{id}/edit', [SaleController::class, 'edit'])->name('sales.edit'); // Edit a sale
    Route::put('/sales/{id}', [SaleController::class, 'update'])->name('sales.update'); // Update sale
    Route::delete('/sales/{id}', [SaleController::class, 'destroy'])->name('sales.destroy'); // Delete sale

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/medicines/search', [MedicineController::class, 'search'])->name('medicines.search');
Route::get('/medicines/search_inventory', [MedicineController::class, 'searchInventory'])->name('medicines.search_inventory');



Route::get('/sales-report', [ReportController::class, 'salesReport'])->name('sales.report');
Route::get('/inventory-report', [ReportController::class, 'inventoryReport'])->name('inventory.report');
Route::get('/revenue-report', [ReportController::class, 'revenueReport'])->name('revenue.report');
Route::get('/medicines/{medicine}/barcode', [MedicineController::class, 'showBarcode'])->name('medicines.barcode');
Route::post('/api/scan', [MedicineController::class, 'processScan']);
Route::resource('expenses', ExpenseController::class);

Route::middleware('auth')->group(function () {
    // Profile route
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
});
Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');

// Update settings
Route::post('/settings/update', [SettingController::class, 'update'])->name('settings.update');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
