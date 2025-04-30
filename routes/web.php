<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\MaintenanceRecordsController;
use App\Http\Controllers\MovementController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StatusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Equipment
    Route::get('/equipment', [EquipmentController::class, 'index'])->name('equipment.index');
    Route::get('/equipment/create', [EquipmentController::class, 'create'])->name('equipment.create');
    Route::post('/equipment', [EquipmentController::class, 'store'])->name('equipment.store');
    Route::get('/equipment/{equipment}', [EquipmentController::class, 'show'])->name('equipment.show');
    Route::get('/equipment/{equipment}/edit', [EquipmentController::class, 'edit'])->name('equipment.edit');
    Route::put('/equipment/{equipment}', [EquipmentController::class, 'update'])->name('equipment.update');
    Route::delete('/equipment/{equipment}', [EquipmentController::class, 'destroy'])->name('equipment.destroy');
    Route::get('/equipment-search', [EquipmentController::class, 'search'])->name('equipment.search');
    Route::get('/equipment-filter', [EquipmentController::class, 'filter'])->name('equipment.filter');
    Route::get('/equipment/export/csv', [EquipmentController::class, 'exportCSV'])->name('equipment.export.csv');
    Route::get('/equipment/export/filtered-csv', [EquipmentController::class, 'exportFilteredCSV'])->name('equipment.export.filtered-csv');
    Route::get('/equipment/export/dynamic-csv', [EquipmentController::class, 'dynamicCSVExport'])->name('equipment.export.dynamic-csv');
    
    // Category
    Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('category.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('category.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('category.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('category.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('category.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('category.destroy');
    Route::get('/category-search', [CategoryController::class, 'search'])->name('category.search');
    
    // Status
    Route::get('/statuses', [StatusController::class, 'index'])->name('status.index');
    Route::get('/statuses/create', [StatusController::class, 'create'])->name('status.create');
    Route::post('/statuses', [StatusController::class, 'store'])->name('status.store');
    Route::get('/statuses/{status}', [StatusController::class, 'show'])->name('status.show');
    Route::get('/statuses/{status}/edit', [StatusController::class, 'edit'])->name('status.edit');
    Route::put('/statuses/{status}', [StatusController::class, 'update'])->name('status.update');
    Route::delete('/statuses/{status}', [StatusController::class, 'destroy'])->name('status.destroy');
    Route::get('/status-search', [StatusController::class, 'search'])->name('status.search');
    
    // Movement
    Route::get('/movements', [MovementController::class, 'index'])->name('movement.index');
    Route::get('/movements/create', [MovementController::class, 'create'])->name('movement.create');
    Route::post('/movements', [MovementController::class, 'store'])->name('movement.store');
    Route::get('/movements/{movement}', [MovementController::class, 'show'])->name('movement.show');
    Route::get('/movements/{movement}/edit', [MovementController::class, 'edit'])->name('movement.edit');
    Route::put('/movements/{movement}', [MovementController::class, 'update'])->name('movement.update');
    Route::delete('/movements/{movement}', [MovementController::class, 'destroy'])->name('movement.destroy');
    Route::get('/movement-search', [MovementController::class, 'search'])->name('movement.search');
    Route::get('/movement-filter', [MovementController::class, 'filter'])->name('movement.filter');
    Route::get('/equipment/{equipment}/history', [MovementController::class, 'history'])->name('movement.history');
    
    // Maintenance
    Route::get('/maintenance', [MaintenanceRecordsController::class, 'index'])->name('maintenance.index');
    Route::get('/maintenance/create', [MaintenanceRecordsController::class, 'create'])->name('maintenance.create');
    Route::post('/maintenance', [MaintenanceRecordsController::class, 'store'])->name('maintenance.store');
    Route::get('/maintenance/{maintenanceRecord}', [MaintenanceRecordsController::class, 'show'])->name('maintenance.show');
    Route::get('/maintenance/{maintenanceRecord}/edit', [MaintenanceRecordsController::class, 'edit'])->name('maintenance.edit');
    Route::put('/maintenance/{maintenanceRecord}', [MaintenanceRecordsController::class, 'update'])->name('maintenance.update');
    Route::delete('/maintenance/{maintenanceRecord}', [MaintenanceRecordsController::class, 'destroy'])->name('maintenance.destroy');
    Route::get('/maintenance-search', [MaintenanceRecordsController::class, 'search'])->name('maintenance.search');
    Route::get('/maintenance-filter', [MaintenanceRecordsController::class, 'filter'])->name('maintenance.filter');
    
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';