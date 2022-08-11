<?php

use App\Http\Controllers\UserController;
use App\Http\Livewire\ShoppingLists\Index;
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


Route::get('generatepdf', [Index::class,'generatepdf'])->name('list.pdf');

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
    Route::get('/shopping-lists/edit', function () {
        return view('shopping-lists/edit');
    })->name('/shopping-lists/edit');
});
