<?php

use App\Http\Livewire\Shopper\Create;
use App\Http\Livewire\Shopper\Edit;
use App\Http\Livewire\Shopper\Index;
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
    Route::get('shopper', Index::class)->name('shopper');
    Route::get('shopper/create', Create::class)->name('shopper/create');
    Route::get('shopper/edit/{list_id}', Edit::class);
    Route::get('shopper/download/{list_id}', [Index::class,'generatepdf']);
});
