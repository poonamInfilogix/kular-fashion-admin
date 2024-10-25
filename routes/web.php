<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
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
        'categories'    => CategoryController::class,
        'sub-categories'=> SubCategoryController::class,
        'settings'      => SettingController::class,
        'brands'        => BrandController::class
    ]);
    Route::post('/update-status', [CategoryController::class, 'updateStatus'])->name('update-status');
    Route::post('/sub-category-status', [SubCategoryController::class, 'SubCategoryStatus'])->name('sub-category-status');
    Route::post('/brands-status', [BrandController::class, 'updateStatus'])->name('brands-status');
});

