<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StaApiController;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

//Item
Route::get('items', [StaApiController::class, 'getItems']);
Route::get('items/{id}', [StaApiController::class, 'getItem']);
Route::post('items', [StaApiController::class, 'storeItem']);
Route::delete('items/{id}',[StaApiController::class, 'destroyItem']);
//Warehouse
Route::get('warehouses', [StaApiController::class, 'getWarehouses']);
Route::get('warehouses/{id}', [StaApiController::class, 'getWarehouse']);
Route::post('warehouses', [StaApiController::class, 'storeWarehouse']);
Route::delete('warehouses/{id}',[StaApiController::class, 'destroyWarehouse']);
//Transactions
Route::get('transactions', [StaApiController::class, 'getTransactions']);
Route::get('transactions/{id}', [StaApiController::class, 'showTransaction']);
Route::post('transactions', [StaApiController::class, 'storeTransaction']);
Route::put('transactions', [StaApiController::class, 'updateTransaction']);
Route::get('transactionsToday', [StaApiController::class, 'getTransactionsToday']);
Route::get('transactionsByStatus/{status}', [StaApiController::class, 'getTransactionsByStatus']);
Route::get('transactionsByStatus/{status1}/{status2}', [StaApiController::class, 'getTransactionsByStatus2']);
Route::put('transactionsIsOpened/{id}/{isOpened}', [StaApiController::class, 'updateIsViewed']);
//TransactionLines
Route::get('transactionlines/{id}', [StaApiController::class, 'getTransactionLines']);
