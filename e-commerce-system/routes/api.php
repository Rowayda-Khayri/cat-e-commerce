<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', [StoreController::class, 'getAllStoreItems'])->name('api.store');

Route::post('/add-to-cart/{itemId}', [CartController::class, 'addToCart'])->name('api.addToCart');

Route::get('/cart', [CartController::class, 'viewCart'])->name('api.cart');

Route::get('/cart/remove/{itemId}', [CartController::class, 'removeItemFromCart'])->name('api.removeItemFromCart');

Route::post('/checkout/process', [OrderController::class, 'processCheckout'])->name('api.checkout.process');