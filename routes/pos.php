<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\LoginController;

Route::post('api/pos/login', [LoginController::class, 'login']);


Route::prefix('api/pos')->middleware('auth:sanctum')->group(function () {
    Route::post('/place-order', [OrderController::class, 'PosOrderPlace']);
    Route::get('/test-outside-auth', [OrderController::class, 'testOutsideAuth']);
});