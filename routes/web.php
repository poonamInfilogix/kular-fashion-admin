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
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TagController;

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
        'tax-settings'  => TaxController::class,
        'products'      => ProductController::class,
        'tags'          => TagController::class,
    ]);

    #Product Steps Rout: 
    Route::get('products/create/step-1',[ProductController::class,'productStep1'])->name('products.create.step-1');
    Route::post('products/create/step-1',[ProductController::class,'saveStep1'])->name('products.save-step-1');
    Route::get('products/create/step-2',[ProductController::class,'productStep2'])->name('products.create.step-2');
    Route::post('products/create/step-2',[ProductController::class,'saveStep2'])->name('products.save-step-2');
    Route::get('products/create/step-3',[ProductController::class,'productStep3'])->name('products.create.step-3');
    Route::post('products/create/step-3',[ProductController::class,'saveStep3'])->name('products.save-step-3');

    #Product Steps Route End:
    Route::get('general-settings', [SettingController::class, 'generalSetting'])->name('general-settings.index');
    Route::post('general-settings.store', [SettingController::class, 'generalSettingStore'])->name('general-settings.store');

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
    Route::post('/product-status', [ProductController::class, 'productStatus'])->name('product-status');
    Route::post('/tag-status', [TagController::class, 'tagStatus'])->name('tag-status');
    Route::get('/get-states/{countryId}', [SupplierController::class, 'getStates']);
    Route::get('/get-product-type/{departmentId}', [ProductController::class, 'getDepartment']);
});

