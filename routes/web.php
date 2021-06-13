<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UserController;
use App\Models\Product;
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

Route::get('/create-token', [UserController::class, 'getToken']);


Route::middleware(['auth'])->group(function () {
    Route::resource('product', ProductController::class);
    Route::post('change-status/{product}', [ProductController::class, 'changeStatus'])->name('product.change-status');

    Route::get('axcelia', [ProductController::class, 'axcelia'])->name('product.axcelia');
    Route::get('mooncarla', [ProductController::class, 'mooncarla'])->name('product.mooncarla');
    Route::get('preorder', [ProductController::class, 'preorder'])->name('product.preorder');
    Route::get('non-active', [ProductController::class, 'nonActive'])->name('product.non-active');

    Route::get('user-approved', [UserController::class, 'userApproved'])->name('user.approved');
    Route::get('user-waiting', [UserController::class, 'userWaiting'])->name('user.waiting');
    Route::get('user/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::put('user/{user}', [UserController::class, 'update'])->name('user.update');
    Route::get('get-city/{province?}', [UserController::class, 'getCity'])->name('user.get-city');
    Route::put('change-status/{user}', [UserController::class, 'changeStatus'])->name('user.change-status');


    Route::get('purchase-waiting', [PurchaseController::class , 'index'])->name('purchase.index');
    Route::get('purchase-complete', [PurchaseController::class , 'complete'])->name('purchase.complete');
    Route::delete('purchase/{purchase}', [PurchaseController::class , 'destroy'])->name('purchase.destroy');
    Route::get('purchase/{purchase}', [PurchaseController::class , 'show'])->name('purchase.show');
    Route::put('purchase/{purchase}', [PurchaseController::class , 'update'])->name('purchase.update');
    Route::put('confirm-purchase/{purchase}', [PurchaseController::class , 'confirm'])->name('purchase.confirm');
    Route::get('cetak-resi/{purchase}', [PurchaseController::class , 'cetakResi'])->name('purchase.cetak-resi');

    Route::get('/symlink', function () {
        Artisan::call('storage:link');
    });
});

require __DIR__.'/auth.php';
