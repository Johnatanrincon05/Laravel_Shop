<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('products.list');
});

Route::get('/home', function () {
    return view('products.list');
});

Auth::routes();

/* Orders Routes */
Route::resource('orders', App\Http\Controllers\OrderController::class);

Route::prefix('payment')->group(function () {
    Route::get('create/{id}', [App\Http\Controllers\PaymentController::class, 'create'])->name('payment.create');
    Route::get('result/{reference}', [App\Http\Controllers\PaymentController::class, 'result'])->name('payment.result');
});

Route::get('/products', function () {
    return view('products.list');
})->name('products');
