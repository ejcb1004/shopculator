<?php

use App\Http\Livewire\ShoppingLists\Create;
use App\Http\Livewire\ShoppingLists\Edit;
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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('shopping-lists', Index::class)->name('shopping-lists');
    Route::get('shopping-lists/create', Create::class)->name('shopping-lists/create');
    Route::get('shopping-lists/edit/{list_id}', Edit::class);
    Route::get('shopping-lists/download/{list_id}', [Index::class,'generatepdf']);
});
