<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\User;

Route::post('/login', [AuthenticatedSessionController::class, 'storeUser']);

Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'storeUser']);


Route::middleware('auth:sanctum')->group(function () {

    // Route::post('/login', [AuthenticatedSessionController::class, 'storeUser']);
    Route::get('product', function () {
        return  new ProductCollection(Product::all());
    });

    Route::get('product/{id}', function ($id) {
        return  new ProductResource(Product::findOrFail($id));
    });

    Route::post('purchase', [PurchaseController::class, 'store']);
});


Route::get('/province', [UserController::class, 'getProvince']);
Route::get('/city/{province}', [UserController::class, 'getCity']);
