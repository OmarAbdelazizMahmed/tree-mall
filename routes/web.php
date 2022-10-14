<?php

use App\Http\Controllers\Cart\CartController;
use App\Http\Controllers\Cart\LaterController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Search\AlgoliaSearchController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', WelcomeController::class)->name('welcome');

Route::group(['prefix' => 'shop', 'as' => 'shop.'], function () {
    Route::get('/', [ShopController::class, 'index'])->name('index');
    Route::get('/{product:slug}', [ShopController::class, 'show'])->name('show');
});

Route::group(['prefix'=> 'cart', 'as' => 'cart.'], function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::delete('/remove/{product}', [CartController::class, 'remove'])->name('remove');
    Route::patch('/update/{product}', [CartController::class, 'update'])->name('update');
    Route::post('/later/{product}', [LaterController::class, 'store'])->name('later.store');
    Route::patch('/later/{product}', [LaterController::class, 'moveToCart'])->name('later.moveToCart');
    Route::post('/moveToCart/{product}', [LaterController::class, 'moveToCart'])->name('later.moveToCart');
    Route::post('/destroy/{product}', [LaterController::class, 'remove'])->name('later.remove');
});

Route::group(['prefix' => 'coupon', 'as' => 'coupon.'], function () {
    Route::post('/apply', [CouponController::class, 'apply'])->name('apply');
    Route::delete('/remove', [CouponController::class, 'remove'])->name('remove');
});

Route::group(['prefix' => 'checkout', 'as' => 'checkout.'], function () {
    Route::get('/guest', [CheckoutController::class, 'index'])->name('guest.index');
    Route::post('/', [CheckoutController::class, 'store'])->name('store');
});

// search
Route::get('/search-algolia', [AlgoliaSearchController::class, 'search'])->name('search-algolia');

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardController::class)->name('dashboard');

    Route::get('/my-orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/my-orders/invoice/{order:confirmation_number}', [OrderController::class, 'show'])->name('orders.show');
    Route::group(['prefix' => 'checkout', 'as' => 'checkout.'], function () {
        Route::get('/', [CheckoutController::class, 'index'])->name('index');
    });

    Route::group(['prefix' => 'invoice', 'as' => 'invoice.'], function () {
        Route::get('/{order:confirmation_number}', [InvoiceController::class, 'show'])->name('show');
        Route::post('/{order:confirmation_number}', [InvoiceController::class, 'store'])->name('store');
    });

});

