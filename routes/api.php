<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\DailyExpenseController;
use App\Http\Controllers\ProductController as ControllersProductController;
use App\Http\Controllers\ReportController;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('admin',AdminController::class);
Route::apiResource('category',CategoryController::class);
Route::apiResource('products',ProductController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('order-items', OrderItemController::class);
Route::apiResource('dailyexpenses',DailyExpenseController::class);
Route::get('reports/daily', [ReportController::class, 'dailyProfit']);
Route::get('reports/monthly', [ReportController::class, 'monthlyReport']);
Route::get('reports/low-stock', [ReportController::class, 'lowStockReport']);
Route::get('reports/inventory-value', [ReportController::class, 'inventoryValue']);
Route::get('reports/top-selling', [ReportController::class, 'topSelling']);


