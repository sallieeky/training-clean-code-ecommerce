<?php

use App\Http\Controllers\Api\InventoryController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::resource('/product', ProductController::class);
Route::resource('/inventory', InventoryController::class);
