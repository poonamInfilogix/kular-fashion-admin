<?php

use App\Http\Controllers\CollectionController;
use App\Http\Controllers\ProductBarcodeController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\API\LoginController;
use App\Models\ProductColor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/products', [ProductController::class, 'index']);
Route::post('products/add-manufacture-barcode', [ProductBarcodeController::class, 'addManufactureBarcode']);
Route::post('/collections/check-name', [CollectionController::class, 'checkCollectionName']);

Route::post('/login', [LoginController::class, 'login']);
Route::get('/brands', [ProductController::class, 'brandList'])->name('brand.index');
Route::get('/departments', [ProductController::class, 'departmentList'])->name('department.index');
Route::get('/product-types', [ProductController::class, 'producTypesList'])->name('productType.index');
Route::middleware('auth:sanctum')->group( function () {
    Route::post('products/{product}', [ProductController::class, 'productDetail'])->name('products.show');
    Route::post('/apply-coupon', [ProductController::class, 'applyCoupon']);
});