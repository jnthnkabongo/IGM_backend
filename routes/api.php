<?php

use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [ApiController::class, 'loginApi']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('dashboard', [ApiController::class, 'dashboardApi']);
    Route::post('logout', [ApiController::class, 'logoutApi']);
});
