<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserauthController;
use App\Http\Controllers\TransactionheaderController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\WarehouseController;
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
// Route::resource('warehouses','WarehouseController');
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
        return redirect('transactions');
    }
    return view('login');
});

Route::get('/transform', [TransactionheaderController::class, 'create'])->middleware('checktransaction');
Route::post('/transform', [TransactionheaderController::class, 'store'])->middleware('checktransaction');
Route::post('/updatetrans', [TransactionheaderController::class, 'update']);

Route::get('test/{id}', function ($id) {
    return $id;
});

//CLI command to make middleware
//php artisan make:middleware Admin
//Register a middleware in Protected $Routemiddleware in Kernel.php

//Regular route with middleware
//Route::get('admin/routes', 'HomeController@admin')->middleware('admin');

//Multiple middleware in Single Route
// Route::get('admin/routes', 'HomeController@admin')->middleware(['admin','auth']);

Route::fallback(function() {
    return redirect('/');
});