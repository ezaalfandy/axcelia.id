<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\UserController;
use App\Http\Resources\ProductCollection;
use App\Http\Resources\ProductResource;
use App\Http\Resources\ProductVarianResource;
use App\Http\Resources\ProductVarianCollection;
use App\Http\Resources\PurchaseResource;
use App\Http\Resources\ShoppingCartCollection;
use App\Http\Resources\PurchaseCollection;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductVarian;
use App\Models\ShoppingCart;
use App\Models\Purchase;
use App\Models\User;

use App\Services\PurchaseServices;
use App\Services\CourierServices;

Route::post('/login', [AuthenticatedSessionController::class, 'storeUser']);

Route::post('/register', [App\Http\Controllers\Auth\RegisteredUserController::class, 'storeUser']);

Route::middleware('auth:sanctum')->group(function () {

    // Route::post('/login', [AuthenticatedSessionController::class, 'storeUser']);
    Route::get('product', function () {
        if(Auth::user()->status == 'approved')
        {
            return  new ProductCollection(Product::where('status', 'available')->get());
        }else
        {
            return response()->json(["data" => []], 200);
        }
    });

    // get axcelia
    Route::get('product-ready', function () {
        if(Auth::user()->status == 'approved')
        {
            return  new ProductCollection(Product::where(['status' => 'available', 'brand' => 'product-ready'])->get());
        }else
        {
            return response()->json(["data" => []], 200);
        }
    });

    Route::get('barang-unik', function () {
        if(Auth::user()->status == 'approved')
        {
            return  new ProductCollection(Product::where(['status' => 'available', 'brand' => 'barang-unik'])->get());
        }else
        {
            return response()->json(["data" => []], 200);
        }
    });

    Route::get('pre-order', function () {
        return  new ProductCollection(Product::where('status', 'preorder')->get());
    });

    Route::get('product/{id}', function ($id) {
        return new ProductResource(Product::with('productVarian')->findOrFail($id));
    });


    Route::post('shopping-cart', [ShoppingCartController::class , 'store'])->name('shopping-cart.store');
    Route::get('shopping-cart', function () {
        $shoppingCart = ShoppingCart::where('user_id', Auth::user()->id)->with('productVarian')->get();
        return response()->json([
            'summary' => [
                'quantity' => $shoppingCart->sum('quantity'),
                'total_cost' => 'Rp '.number_format(PurchaseServices::sumTotalCost($shoppingCart), 0, ".", ".").' (tidak termasuk ongkir)'
            ],
            'items' => new ShoppingCartCollection($shoppingCart)
        ], 200);
    });

    //NOTA ANDA
    Route::get('nota-anda', function () {
        return new PurchaseCollection(Purchase::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')
            ->where('status', 'waiting_payment')->limit(20)->get());
    });

    //PEMBAYARAN ANDA
    Route::get('pembayaran-anda', function () {
        return new PurchaseCollection(Purchase::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')
            ->where('status', 'complete')->limit(20)->get());
    });

    //HISTORY NOTA
    Route::get('history-nota', function () {
        return new PurchaseCollection(Purchase::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')
            ->where('status', 'complete')->limit(20)->get());
    });

    Route::post('purchase', [PurchaseController::class, 'store']);
    Route::get('purchase', function () {
        return new PurchaseCollection(Purchase::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get());
    });
    Route::get('purchase/{purchase}', function (Purchase $purchase) {
        return new purchaseResource($purchase->load('purchase_details.productVarian'));
    });
    Route::put('purchase/{purchase}', [PurchaseController::class, 'update']);


    Route::get('/province', [UserController::class, 'getProvince']);
    Route::get('/city/{province}', [UserController::class, 'getCity']);
    Route::get('/subdistrict/{id}', [UserController::class, 'getSubdistrict']);

    Route::get('purchase/available-courier/{purchase}/{subdistrict_id}', [PurchaseController::class , 'getAvailableCourier'])->name('purchase.available-courier');

    Route::get('trace-package/{purchase}', [PurchaseController::class , 'tracePackage'])->name('purchase.trace-package');

    //ESTIMASI ONGKIR
    Route::get('cek-ongkir/{subdistrict_id}', [PurchaseController::class , 'estimateCourier']);

});

