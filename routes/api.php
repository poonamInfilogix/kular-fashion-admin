<?php

use App\Http\Controllers\ProductBarcodeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('products/add-manufacture-barcode', [ProductBarcodeController::class, 'addManufactureBarcode']);