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

Route::get('/test', function () {
    return 'Web routes are working!';
});

Route::get('/', [ItemController::class, 'index']);

Route::get('/item/{item_id}', [ItemController::class, 'detail']);

Route::get('/purchase/{item_id}', [ItemController::class, 'purchase']);

Route::get('/purchase/address/{item_id}', [UserController::class, 'address']);

Route::get('/sell', [ItemController::class, 'sell']);

Route::get('/mypage', [UserController::class, 'mypage']);

Route::get('/mypage/profile', [UserController::class, 'profile']);
