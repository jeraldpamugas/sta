<?php

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserauthController;
use App\Http\Controllers\TransactionheaderController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\WarehouseController;
use App\Http\Controllers\HomeController;
URL::forceRootUrl('http://127.0.0.1:8000');
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


Route::post('user', [UserauthController::class,'userlogin']);

//Route::view('login','login');

// Route::resource('transactions','TransactionheaderController');

// Route::resource('items','ItemController');
Route::resource('home', HomeController::class);
Route::resource('items', ItemController::class)->middleware('usertypecheck');
Route::resource('warehouses', WarehouseController::class)->middleware('usertypecheck');
Route::resource('transactions', TransactionheaderController::class)->middleware('logincheck');

Route::get('/logout', function () {
    if(session()->has('code')){
        session()->pull('code');
    }
    return redirect('/');
});

Route::get('/', function () {
    if(session()->has('code')){
        return redirect('home');
    }
    return view('login');
});

Route::get('/transform', [TransactionheaderController::class, 'create'])->middleware('checktransaction');
Route::post('/transform', [TransactionheaderController::class, 'store'])->middleware('checktransaction');
Route::post('/updatetrans', [TransactionheaderController::class, 'update']);

Route::fallback(function() {
    return redirect('/');
});

Route::get('test', function () {
    event(new App\Events\StatusLiked('Someone'));
    return "Event has been sent!";
});

Route::get('/welcome', function () {
    return view('testpusher');
});
