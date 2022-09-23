<?php

use App\Http\Controllers\HomeController;
use App\Http\Livewire\Admin\AdminIndex;
use App\Http\Livewire\Admin\Categories\AdminCategoryCreate;
use App\Http\Livewire\Admin\Categories\AdminCategoryEdit;
use App\Http\Livewire\Admin\Categories\AdminCategoryIndex;
use App\Http\Livewire\Admin\Markets\AdminMarketCreate;
use App\Http\Livewire\Admin\Markets\AdminMarketEdit;
use App\Http\Livewire\Admin\Markets\AdminMarketIndex;
use App\Http\Livewire\Admin\Subcategories\AdminSubcategoryCreate;
use App\Http\Livewire\Admin\Subcategories\AdminSubcategoryEdit;
use App\Http\Livewire\Admin\Subcategories\AdminSubcategoryIndex;
use App\Http\Livewire\Admin\Users\AdminUserCreate;
use App\Http\Livewire\Admin\Users\AdminUserEdit;
use App\Http\Livewire\Admin\Users\AdminUserIndex;
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

Route::get('admin/login', function () {
    return view('auth.safe');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('home', [HomeController::class, 'index']);

    // Admin
    Route::get('admin', AdminIndex::class)->name('admin');

    Route::get('admin/users', AdminUserIndex::class)->name('admin/users');
    Route::get('admin/users/create', AdminUserCreate::class)->name('admin/users/create');
    Route::get('admin/users/edit/{user_id}', AdminUserEdit::class);

    Route::get('admin/markets', AdminMarketIndex::class)->name('admin/markets');
    Route::get('admin/markets/create', AdminMarketCreate::class)->name('admin/markets/create');
    Route::get('admin/markets/edit/{market_id}', AdminMarketEdit::class);

    Route::get('admin/categories', AdminCategoryIndex::class)->name('admin/categories');
    Route::get('admin/categories/create', AdminCategoryCreate::class)->name('admin/categories/create');
    Route::get('admin/categories/edit/{categories_id}', AdminCategoryEdit::class);

    Route::get('admin/subcategories', AdminSubcategoryIndex::class)->name('admin/subcategories');
    Route::get('admin/subcategories/create', AdminSubcategoryCreate::class)->name('admin/subcategories/create');
    Route::get('admin/subcategories/edit/{user_id}', AdminSubcategoryEdit::class);

    // Market
    Route::get('market', MarketIndex::class)->name('market');
    Route::get('market/create', MarketCreate::class)->name('market/create');
    Route::get('market/edit/{product_id}', MarketEdit::class);
    Route::get('market/dashboard', Dashboard::class)->name('market/dashboard');
    Route::get('market/export/{market_id}', [MarketIndex::class, 'export']);
    Route::post('market/import', [MarketIndex::class, 'import'])->name('market/import');

    // Shopper
    Route::get('shopper', ShopperIndex::class)->name('shopper');
    Route::get('shopper/create', ShopperCreate::class)->name('shopper/create');
    Route::get('shopper/edit/{list_id}', ShopperEdit::class);
    Route::get('shopper/download/{list_id}', [ShopperIndex::class, 'generatepdf']);
});
