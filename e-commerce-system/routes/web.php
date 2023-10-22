<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

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

Route::get('/', [StoreController::class, 'getAllStoreItems'])->name('store');

Route::post('/add-to-cart/{itemId}', [CartController::class, 'addToCart'])->name('addToCart');

Route::get('/cart',  [CartController::class, 'viewCart'])->name('cart');

Route::get('/cart/remove/{itemId}', [CartController::class, 'removeItemFromCart'])
->name('removeItemFromCart');

Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');

Route::post('/checkout/process', [OrderController::class, 'processCheckout'])
->name('checkout.process');