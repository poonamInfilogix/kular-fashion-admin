<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;

Route::get('/', function (){
    return redirect()->route('admin.dashboard.index');
});

Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard.index');

