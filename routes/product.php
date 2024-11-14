<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('products/create/step-1', [ProductController::class, 'productStep1'])->name('products.create.step-1');
Route::post('products/create/step-1', [ProductController::class, 'saveStep1'])->name('products.save-step-1');
Route::get('products/create/step-2', [ProductController::class, 'productStep2'])->name('products.create.step-2');
Route::post('products/create/step-2', [ProductController::class, 'saveStep2'])->name('products.save-step-2');
Route::get('products/create/step-3', [ProductController::class, 'productStep3'])->name('products.create.step-3');
Route::post('add-variant', [ProductController::class, 'addVariant'])->name('add.variant');
Route::get('products/remove-variant/{colorId}', [ProductController::class, 'removeVariant'])->name('products.remove-variant');

Route::put('products/update/step-1/{product}', [ProductController::class, 'updateStep1'])->name('products.update-step-1');
Route::get('products/edit/step-2/{product}', [ProductController::class, 'editStep2'])->name('products.edit.step-2');
