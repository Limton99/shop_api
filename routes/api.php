<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'products'], function () {
    Route::get('/', [\App\Http\Controllers\ProductController::class, 'index']);
    Route::get('/search', [\App\Http\Controllers\ProductController::class, 'search']);
});

Route::group(['prefix' => 'cart', 'middleware' => 'optional_auth'], function () {
    Route::get('/', [\App\Http\Controllers\CartController::class, 'index']);
    Route::post('/add', [\App\Http\Controllers\CartController::class, 'addToCart']);
});

Route::group(['prefix' => 'user'], function () {
    Route::post('/register', [\App\Http\Controllers\UserController::class, 'register']);
    Route::post('/login', [\App\Http\Controllers\UserController::class, 'login']);
});
