<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
});

Route::prefix('sales')->group(function () {
    Route::post('/', [SaleController::class, 'store']);
    Route::get('/', [SaleController::class, 'index']);
    Route::get('/{saleId}', [SaleController::class, 'show']);
    Route::put('/{saleId}/cancel', [SaleController::class, 'cancel']);
});
