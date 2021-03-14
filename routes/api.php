<?php

use App\Http\Controllers\v1\Rest\AuthController;
use App\Http\Controllers\v1\Rest\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::group(['namespace' => 'v1/Rest', 'prefix' => 'v1'], function () {

    Route::group(['prefix' => 'auth'], function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
    });

    Route::group(['prefix' => 'goods'], function () {
        Route::post('makeOrder', [OrderController::class, 'makeOrder'])->middleware('authen');
        Route::get('search', [AuthController::class, 'search']);
    });

    Route::get('categories', [AuthController::class, 'categories']);
    Route::get('categories/{id}', [AuthController::class, 'categoryGoods']);

});

