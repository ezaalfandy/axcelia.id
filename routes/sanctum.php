<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\UserController;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ShoppingCartCollection;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ShoppingCart;
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
    Route::get('purchase/available-courier/{purchase}', [PurchaseController::class , 'getAvailableCourier'])->name('purchase.available-courier');

    Route::post('shopping-cart', [ShoppingCartController::class , 'store'])->name('shopping-cart.store');
    Route::get('shopping-cart', function () {
        return  new ShoppingCartCollection(ShoppingCart::where('user_id', Auth::user()->id)->get());
    });
});


Route::get('/province', [UserController::class, 'getProvince']);
Route::get('/city/{province}', [UserController::class, 'getCity']);
Route::get('/subdistrict/{id}', [UserController::class, 'getSubdistrict']);
