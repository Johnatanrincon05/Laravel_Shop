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
})->middleware('auth');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('orders', App\Http\Controllers\OrderController::class)->middleware('auth');

Route::get('/payment', [App\Http\Controllers\PaymentGateway::class, 'index'])->name('payment');

Route::get('/products', function () {
    return view('products.list');
})->middleware('auth');
