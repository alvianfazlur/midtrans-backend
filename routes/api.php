<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\OrderController;
use App\Http\Controllers\Api\V1\BalanceController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('order/topup', [OrderController::class, 'topup']);
Route::post('midtrans-callback', [OrderController::class, 'callback']);
Route::get('get-order', [OrderController::class, 'getOrder']);
Route::post('setuser', [BalanceController::class, 'setUSer']);
Route::get('get-balance', [BalanceController::class, 'getBalance']);