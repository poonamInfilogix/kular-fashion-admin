<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\SizeScaleController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\TaxController;

Route::get('/', function (){
    return redirect()->route('dashboard');
});

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'auth.session'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resources([
        'departments'   => DepartmentController::class,
        'product-types' => ProductTypeController::class,
        'settings'      => SettingController::class,
        'brands'        => BrandController::class,
        'colors'        => ColorController::class,
        'size-scales'   => SizeScaleController::class,
        'suppliers'     => SupplierController::class,
        'taxes'         => TaxController::class
    ]);

    Route::get('size-scales/sizes/{sizeScaleId}', [SizeController::class, 'index'])->name('sizes.index');
    Route::get('size-scales/sizes/{sizeScaleId}/create', [SizeController::class, 'create'])->name('sizes.create');
    Route::post('sizes/{sizeScaleId}', [SizeController::class, 'store'])->name('sizes.store');
    Route::get('size-scales/{sizeScaleId}/sizes/{size}/edit', [SizeController::class, 'edit'])->name('sizes.edit');
    Route::put('size-scales/{sizeScaleId}/sizes/{size}', [SizeController::class, 'update'])->name('sizes.update');
    Route::delete('size-scales/{sizeScaleId}/sizes/{size}', [SizeController::class, 'destroy'])->name('sizes.destroy');

    Route::post('/department-status', [DepartmentController::class, 'updateStatus'])->name('department-status');
    Route::post('/product-types-status', [ProductTypeController::class, 'productTypeStatus'])->name('product-types-status');
    Route::post('/brand-status', [BrandController::class, 'updateStatus'])->name('brand-status');
    Route::post('/color-status', [ColorController::class, 'colorStatus'])->name('color-status');
    Route::post('/size-scale-status', [SizeScaleController::class, 'sizeScaleStatus'])->name('size-scale-status');
    Route::post('/size-status', [SizeController::class, 'sizeStatus'])->name('size-status');
    Route::post('/supplier-status',[SupplierController::class, 'supplierStatus'])->name('supplier-status');
    Route::post('/tax-status', [TaxController::class, 'taxStatus'])->name('tax-status');
    Route::get('/get-states/{countryId}', [SupplierController::class, 'getStates']);
});

