<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\InboundStockController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductVarianController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\UserController;
use App\Models\Product;
use App\Models\ProductVarian;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});


Route::middleware(['auth'])->group(function () {
    Route::resource('product', ProductController::class);
    Route::post('change-status/{product}', [ProductController::class, 'changeStatus'])->name('product.change-status');

    Route::get('product-ready', [ProductController::class, 'productReady'])->name('product.product-ready');
    Route::get('barang-unik', [ProductController::class, 'barangUnik'])->name('product.barang-unik');
    Route::get('preorder', [ProductController::class, 'preorder'])->name('product.preorder');
    Route::get('non-active', [ProductController::class, 'nonActive'])->name('product.non-active');

    Route::resource('product-varian', ProductVarianController::class);
    Route::resource('inbound-stock', InboundStockController::class);

    Route::get('user-approved', [UserController::class, 'userApproved'])->name('user.approved');
    Route::get('user-waiting', [UserController::class, 'userWaiting'])->name('user.waiting');
    Route::get('user/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::get('get-city/{province?}', [UserController::class, 'getCity'])->name('user.get-city');
    Route::put('change-status/{user}', [UserController::class, 'changeStatus'])->name('user.change-status');

    Route::resource('purchase', PurchaseController::class)->except('create');
    Route::get('purchase-complete', [PurchaseController::class , 'complete'])->name('purchase.complete');
    Route::delete('purchase/{purchase}', [PurchaseController::class , 'destroy'])->name('purchase.destroy');
    Route::get('purchase/available-courier/{purchase}', [PurchaseController::class , 'getAvailableCourier'])->name('purchase.available-courier');
    Route::put('purchase/update-discount/{purchase}', [PurchaseController::class, 'updateDiscount'])->name('purchase.update-discount');
    Route::put('purchase/update-resi/{purchase}', [PurchaseController::class, 'updateResi'])->name('purchase.update-resi');


    Route::put('confirm-purchase/{purchase}', [PurchaseController::class , 'confirm'])->name('purchase.confirm');
    Route::get('cetak-resi/{purchase}', [PurchaseController::class , 'cetakResi'])->name('purchase.cetak-resi');
    Route::get('cetak-nota/{purchase}', [PurchaseController::class , 'cetakNota'])->name('purchase.cetak-nota');

    Route::delete('shopping-cart/{shoppingCart}', [ShoppingCartController::class , 'destroy'])->name('shopping-cart.destroy');
    Route::get('shopping-cart', [ShoppingCartController::class , 'index'])->name('shopping-cart.index');

    Route::get('/dashboard-axcelia', [AdminController::class, 'index'])->name('dashboard.index');

    Route::get('admin/{admin}', [AdminController::class, 'edit'])->name('admin.edit');
    Route::put('admin/{admin}', [AdminController::class, 'update'])->name('admin.update');
});

Route::get('/symlink', function () {
    Artisan::call('storage:link');
});

Route::get('/migrate', function () {
    Artisan::call('migrate:refresh');
});

Route::get('/seed', function () {
    Artisan::call('db:seed --force');
});

require __DIR__.'/auth.php';
