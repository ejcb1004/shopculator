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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/shopping-lists', function () {
        return view('shopping-lists/index');
    })->name('shopping-lists');
    Route::get('/shopping-lists/products', function () {
        return view('shopping-lists/products');
    })->name('shopping-lists/products');
    Route::get('/shopping-lists/create', function () {
        return view('shopping-lists/create');
    })->name('/shopping-lists/create');
});
