<?php

use App\Http\Controllers\HomeController;
use App\Http\Livewire\Admin\AdminIndex;
use App\Http\Livewire\Market\Dashboard;
use App\Http\Livewire\Market\MarketCreate;
use App\Http\Livewire\Market\MarketEdit;
use App\Http\Livewire\Market\MarketIndex;
use App\Http\Livewire\Shopper\ShopperCreate;
use App\Http\Livewire\Shopper\ShopperEdit;
use App\Http\Livewire\Shopper\ShopperIndex;
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
    Route::get('home', [HomeController::class, 'index']);

    // Admin
    Route::get('admin', AdminIndex::class)->name('admin');

    // Market
    Route::get('market', MarketIndex::class)->name('market');
    Route::get('market/create', MarketCreate::class)->name('market/create');
    Route::get('market/edit/{product_id}', MarketEdit::class);
    Route::get('market/dashboard', Dashboard::class)->name('market/dashboard');

    // Shopper
    Route::get('shopper', ShopperIndex::class)->name('shopper');
    Route::get('shopper/create', ShopperCreate::class)->name('shopper/create');
    Route::get('shopper/edit/{list_id}', ShopperEdit::class);
    Route::get('shopper/download/{list_id}', [ShopperIndex::class,'generatepdf']);
});


