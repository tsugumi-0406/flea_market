<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;

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

Route::get('/', [ItemController::class, 'index']);

Route::get('/item/{item_id}', [ItemController::class, 'detail'])->name('item.detail');

Route::middleware('auth')->group(function () {
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])->name('item.purchase');

    Route::get('/purchase/address/{item_id}', [UserController::class, 'address'])->name('item.address');

    Route::get('/sell', [ItemController::class, 'sell']);

    Route::get('/mypage', [UserController::class, 'mypage']);

    Route::get('/mypage/profile', [UserController::class, 'profile']);

    Route::post('/listing', [ItemController::class, 'listing']);

    Route::post('/profile', [UserController::class, 'update']);

    Route::post('/order', [ItemController::class, 'order']);

    Route::post('/update/address/{item_id}', [UserController::class, 'updateAddress'])->name('item.updateAddress');
});