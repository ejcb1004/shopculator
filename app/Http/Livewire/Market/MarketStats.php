<?php

namespace App\Http\Livewire\Market;

use App\Models\Category;
use App\Models\ListDetail;
use App\Models\Product;
use App\Models\ShoppingList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MarketStats extends Component
{
    public $market;

    public $total_cp;
    public $total_products;
    public $monthly_purchases;
    public $yearly_purchases;
    public $an_years;
    public $mo_years;
    public $monthly_top_trending;
    public $yearly_top_trending;
    public $mtt_category;
    public $ytt_category;
    public $colors;
    public $categories;

    public function mount()
    {
        $this->an_years = ShoppingList::select(DB::raw('YEAR(updated_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')->toArray();

        $this->mo_years = ShoppingList::select(DB::raw('YEAR(updated_at) as year'))
            ->whereMonth('updated_at', DB::raw('MONTH(NOW())'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')->toArray();

        $this->colors = [
            '#84cc16', // lime-500
            '#10b981', // emerald-500
            '#06b6d4', // cyan-500
            '#3b82f6', // blue-500
            '#8b5cf6', // violet-500
        ];

        $this->categories = Category::select('category_id', 'category_name')->get()->toArray();

        $this->market = DB::table('markets')
            ->join('users', 'users.email', '=', 'markets.email')
            ->where('users.email', Auth::user()->email)
            ->pluck('markets.market_id');

        $this->total_cp = DB::table('list_details')
            ->join('products', 'list_details.product_id', '=', 'products.product_id')
            ->where('products.market_id', $this->market)
            ->count('list_details.product_id');

        $this->total_products = Product::where('market_id', $this->market)->count('id');

        $this->monthly_purchases = ListDetail::select(
            DB::raw('YEAR(shopping_lists.created_at) AS year'),
            DB::raw('COUNT(*) AS purchases')
        )
            ->join('products', 'list_details.product_id', '=', 'products.product_id')
            ->join('shopping_lists', 'list_details.list_id', '=', 'shopping_lists.list_id')
            ->where('products.market_id', $this->market)
            ->whereMonth('shopping_lists.updated_at', DB::raw('MONTH(NOW())'))
            ->limit(5)
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get()
            ->toArray();

        $this->yearly_purchases = ListDetail::select(
            DB::raw('YEAR(shopping_lists.created_at) AS year'),
            DB::raw('COUNT(*) AS purchases')
        )
            ->join('products', 'list_details.product_id', '=', 'products.product_id')
            ->join('shopping_lists', 'list_details.list_id', '=', 'shopping_lists.list_id')
            ->where('products.market_id', $this->market)
            ->limit(5)
            ->groupBy('year')
            ->orderBy('year', 'desc')
            ->get()
            ->toArray();

        $this->monthly_top_trending = [];
        $this->yearly_top_trending = [];
        $this->mtt_category = [];
        $this->ytt_category = [];

        foreach ($this->an_years as $year) {
            array_push(
                $this->yearly_top_trending,
                ListDetail::select(
                    'products.product_name',
                    'products.image_path',
                    DB::raw('COUNT(*) as total_count'),
                )
                    ->join('products', 'list_details.product_id', '=', 'products.product_id')
                    ->join('shopping_lists', 'list_details.list_id', '=', 'shopping_lists.list_id')
                    ->where('products.market_id', $this->market)
                    ->whereYear('shopping_lists.updated_at', $year)
                    ->limit(5)
                    ->groupBy('products.product_name', 'products.image_path', DB::raw('YEAR(shopping_lists.updated_at)'))
                    ->orderBy(DB::raw('YEAR(shopping_lists.updated_at)'), 'desc')
                    ->orderBy('total_count', 'desc')
                    ->orderBy('products.product_name', 'asc')
                    ->get()
                    ->toArray()
            );
            foreach ($this->categories as $category) {
                array_push(
                    $this->ytt_category,
                    ListDetail::select(
                        'products.product_name',
                        'products.image_path',
                        DB::raw('COUNT(*) as total_count'),
                    )
                        ->join('products', 'list_details.product_id', '=', 'products.product_id')
                        ->join('shopping_lists', 'list_details.list_id', '=', 'shopping_lists.list_id')
                        ->join('subcategories', 'products.subcategory_id', '=', 'subcategories.subcategory_id')
                        ->join('categories', 'subcategories.category_id', '=', 'categories.category_id')
                        ->where('products.market_id', $this->market)
                        ->where('subcategories.category_id', $category['category_id'])
                        ->whereYear('shopping_lists.updated_at', $year)
                        ->limit(5)
                        ->groupBy('products.product_name', 'products.image_path', DB::raw('YEAR(shopping_lists.updated_at)'))
                        ->orderBy(DB::raw('YEAR(shopping_lists.updated_at)'), 'desc')
                        ->orderBy('total_count', 'desc')
                        ->orderBy('products.product_name', 'asc')
                        ->get()
                        ->toArray()
                );
            }
        }

        foreach ($this->mo_years as $year) {
            array_push(
                $this->monthly_top_trending,
                ListDetail::select(
                    'products.product_name',
                    'products.image_path',
                    DB::raw('COUNT(*) as total_count'),
                )
                    ->join('products', 'list_details.product_id', '=', 'products.product_id')
                    ->join('shopping_lists', 'list_details.list_id', '=', 'shopping_lists.list_id')
                    ->where('products.market_id', $this->market)
                    ->whereYear('shopping_lists.updated_at', $year)
                    ->whereMonth('shopping_lists.updated_at', DB::raw('MONTH(NOW())'))
                    ->limit(5)
                    ->groupBy('products.product_name', 'products.image_path', DB::raw('YEAR(shopping_lists.updated_at)'))
                    ->orderBy(DB::raw('YEAR(shopping_lists.updated_at)'), 'desc')
                    ->orderBy('total_count', 'desc')
                    ->orderBy('products.product_name', 'asc')
                    ->get()
                    ->toArray()
            );
            foreach ($this->categories as $category) {
                array_push(
                    $this->mtt_category,
                    ListDetail::select(
                        'products.product_name',
                        'products.image_path',
                        DB::raw('COUNT(*) as total_count'),
                    )
                        ->join('products', 'list_details.product_id', '=', 'products.product_id')
                        ->join('shopping_lists', 'list_details.list_id', '=', 'shopping_lists.list_id')
                        ->join('subcategories', 'products.subcategory_id', '=', 'subcategories.subcategory_id')
                        ->join('categories', 'subcategories.category_id', '=', 'categories.category_id')
                        ->where('products.market_id', $this->market)
                        ->where('subcategories.category_id', $category['category_id'])
                        ->whereYear('shopping_lists.updated_at', $year)
                        ->whereMonth('shopping_lists.updated_at', DB::raw('MONTH(NOW())'))
                        ->limit(5)
                        ->groupBy('products.product_name', 'products.image_path', DB::raw('YEAR(shopping_lists.updated_at)'))
                        ->orderBy(DB::raw('YEAR(shopping_lists.updated_at)'), 'desc')
                        ->orderBy('total_count', 'desc')
                        ->orderBy('products.product_name', 'asc')
                        ->get()
                        ->toArray()
                );
            }
        }
    }

    public function render()
    {
        //dd($this->yearly_purchases);
        if (Auth::user()->role_id != 'R2') abort(403);
        return view('livewire.market.market-stats');
    }
}
