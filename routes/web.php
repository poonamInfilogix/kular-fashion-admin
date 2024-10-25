<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProductTypeController;
use App\Http\Controllers\SettingController;

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
        'brands'        => BrandController::class
    ]);
    Route::post('/department-status', [DepartmentController::class, 'updateStatus'])->name('department-status');
    Route::post('/product-types-status', [ProductTypeController::class, 'productTypeStatus'])->name('product-types-status');
    Route::post('/brand-status', [BrandController::class, 'updateStatus'])->name('brand-status');
});

