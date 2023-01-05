<?php

namespace App\Http\Livewire\Market;

use App\Models\Category;
use App\Models\ListDetail;
use App\Models\Product;
use App\Models\ShoppingList;
use PDF;
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
    public $years;
    public $monthly_top_trending;
    public $yearly_top_trending;
    public $mtt_category;
    public $ytt_category;
    public $colors;
    public $categories;
    public $chart_config;

    public function mount()
    {
        $this->years = ShoppingList::select(DB::raw('YEAR(updated_at) as year'))
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
        $this->chart_config = [];

        foreach ($this->years as $key => $year) {
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

            // chartjs: monthly trending
            if (!empty($this->monthly_top_trending[$key])) {
                $this->chart_config[$key]['mt'] = "{type:'bar',data:{labels:['Count'],datasets:[";
                for ($j = 0; $j < count($this->monthly_top_trending[$key]); $j++) {
                    $this->chart_config[$key]['mt'] .= "{label:'" . $this->monthly_top_trending[$key][$j]['product_name'] . "',backgroundColor:'" . $this->colors[$j] . "',data:[" . $this->monthly_top_trending[$key][$j]['total_count'] . "]},";
                }
                $this->chart_config[$key]['mt'] .= "]},options:{scales:{y:{suggestedMin:0,ticks:{stepSize:1}}}}}";
            }

            // chartjs: yearly trending
            if (!empty($this->yearly_top_trending[$key])) {
                $this->chart_config[$key]['yt'] = "{type:'bar',data:{labels:['Count'],datasets:[";
                for ($j = 0; $j < count($this->yearly_top_trending[$key]); $j++) {
                    $this->chart_config[$key]['yt'] .= "{label:'" . $this->yearly_top_trending[$key][$j]['product_name'] . "'";
                    $this->chart_config[$key]['yt'] .= ",backgroundColor:'" . $this->colors[$j] . "',data:[" . $this->yearly_top_trending[$key][$j]['total_count'] . "]},";
                }
                $this->chart_config[$key]['yt'] .= "]},options:{scales:{y:{suggestedMin:0,ticks:{stepSize:1}}}}}";
            }

            foreach ($this->categories as $ctg_key => $category) {
                // chartjs: monthly trending per category
                if (!empty($this->mtt_category[(count($this->categories) * $key) + $ctg_key])) {
                    $this->chart_config[$key]['mtpc'][$ctg_key] = "{type:'bar',data:{labels:['Count'],datasets:[";
                    for ($k = 0; $k < count($this->mtt_category[(count($this->categories) * $key) + $ctg_key]); $k++) {
                        $this->chart_config[$key]['mtpc'][$ctg_key] .= "{label:'" . $this->mtt_category[(count($this->categories) * $key) + $ctg_key][$k]['product_name'] . "'";
                        $this->chart_config[$key]['mtpc'][$ctg_key] .= ",backgroundColor:'" . $this->colors[$k] . "',data:[" . $this->mtt_category[(count($this->categories) * $key) + $ctg_key][$k]['total_count'] . "]},";
                    }
                    $this->chart_config[$key]['mtpc'][$ctg_key] .= "]},options:{scales:{y:{suggestedMin:0,ticks:{stepSize:1}}}}}";
                }

                // chartjs: yearly trending per category
                if (!empty($this->ytt_category[(count($this->categories) * $key) + $ctg_key])) {
                    $this->chart_config[$key]['ytpc'][$ctg_key] = "{type:'bar',data:{labels:['Count'],datasets:[";
                    for ($k = 0; $k < count($this->ytt_category[(count($this->categories) * $key) + $ctg_key]); $k++) {
                        $this->chart_config[$key]['ytpc'][$ctg_key] .= "{label:'" . $this->ytt_category[(count($this->categories) * $key) + $ctg_key][$k]['product_name'] . "'";
                        $this->chart_config[$key]['ytpc'][$ctg_key] .= ",backgroundColor:'" . $this->colors[$k] . "',data:[" . $this->ytt_category[(count($this->categories) * $key) + $ctg_key][$k]['total_count'] . "]},";
                    }
                    $this->chart_config[$key]['ytpc'][$ctg_key] .= "]},options:{scales:{y:{suggestedMin:0,ticks:{stepSize:1}}}}}";
                }
            }
        }
    }

    public function render()
    {
        // dd($this->monthly_top_trending, $this->yearly_top_trending, $this->mtt_category, $this->ytt_category);
        if (Auth::user()->role_id != 'R2') abort(403);
        return view('livewire.market.market-stats');
    }

    public function generatepdf($report)
    {
        $monthly_top_trending = [];
        $yearly_top_trending = [];
        $mtt_category = [];
        $ytt_category = [];

        $years = ShoppingList::select(DB::raw('YEAR(updated_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')->toArray();

        $colors = [
            '#84cc16', // lime-500
            '#10b981', // emerald-500
            '#06b6d4', // cyan-500
            '#3b82f6', // blue-500
            '#8b5cf6', // violet-500
        ];

        $categories = Category::select('category_id', 'category_name')->get()->toArray();

        $market = DB::table('markets')
            ->join('users', 'users.email', '=', 'markets.email')
            ->where('users.email', Auth::user()->email)
            ->pluck('markets.market_id');

        foreach ($years as $key => $year) {
            array_push(
                $yearly_top_trending,
                ListDetail::select(
                    'products.product_name',
                    'products.image_path',
                    DB::raw('COUNT(*) as total_count'),
                )
                    ->join('products', 'list_details.product_id', '=', 'products.product_id')
                    ->join('shopping_lists', 'list_details.list_id', '=', 'shopping_lists.list_id')
                    ->where('products.market_id', $market)
                    ->whereYear('shopping_lists.updated_at', $year)
                    ->limit(5)
                    ->groupBy('products.product_name', 'products.image_path', DB::raw('YEAR(shopping_lists.updated_at)'))
                    ->orderBy(DB::raw('YEAR(shopping_lists.updated_at)'), 'desc')
                    ->orderBy('total_count', 'desc')
                    ->orderBy('products.product_name', 'asc')
                    ->get()
                    ->toArray()
            );

            foreach ($categories as $category) {
                array_push(
                    $ytt_category,
                    ListDetail::select(
                        'products.product_name',
                        'products.image_path',
                        DB::raw('COUNT(*) as total_count'),
                    )
                        ->join('products', 'list_details.product_id', '=', 'products.product_id')
                        ->join('shopping_lists', 'list_details.list_id', '=', 'shopping_lists.list_id')
                        ->join('subcategories', 'products.subcategory_id', '=', 'subcategories.subcategory_id')
                        ->join('categories', 'subcategories.category_id', '=', 'categories.category_id')
                        ->where('products.market_id', $market)
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

            array_push(
                $monthly_top_trending,
                ListDetail::select(
                    'products.product_name',
                    'products.image_path',
                    DB::raw('COUNT(*) as total_count'),
                )
                    ->join('products', 'list_details.product_id', '=', 'products.product_id')
                    ->join('shopping_lists', 'list_details.list_id', '=', 'shopping_lists.list_id')
                    ->where('products.market_id', $market)
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

            foreach ($categories as $category) {
                array_push(
                    $mtt_category,
                    ListDetail::select(
                        'products.product_name',
                        'products.image_path',
                        DB::raw('COUNT(*) as total_count'),
                    )
                        ->join('products', 'list_details.product_id', '=', 'products.product_id')
                        ->join('shopping_lists', 'list_details.list_id', '=', 'shopping_lists.list_id')
                        ->join('subcategories', 'products.subcategory_id', '=', 'subcategories.subcategory_id')
                        ->join('categories', 'subcategories.category_id', '=', 'categories.category_id')
                        ->where('products.market_id', $market)
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

            // chartjs: monthly trending
            if (!empty($monthly_top_trending[$key])) {
                $chart_config[$key]['mt'] = "{type:'bar',data:{labels:['Count'],datasets:[";
                for ($j = 0; $j < count($monthly_top_trending[$key]); $j++) {
                    $chart_config[$key]['mt'] .= "{label:'" . $monthly_top_trending[$key][$j]['product_name'] . "',backgroundColor:'" . $colors[$j] . "',data:[" . $monthly_top_trending[$key][$j]['total_count'] . "]},";
                }
                $chart_config[$key]['mt'] .= "]},options:{scales:{y:{suggestedMin:0,ticks:{stepSize:1}}}}}";
            }

            // chartjs: yearly trending
            if (!empty($yearly_top_trending[$key])) {
                $chart_config[$key]['yt'] = "{type:'bar',data:{labels:['Count'],datasets:[";
                for ($j = 0; $j < count($yearly_top_trending[$key]); $j++) {
                    $chart_config[$key]['yt'] .= "{label:'" . $yearly_top_trending[$key][$j]['product_name'] . "'";
                    $chart_config[$key]['yt'] .= ",backgroundColor:'" . $colors[$j] . "',data:[" . $yearly_top_trending[$key][$j]['total_count'] . "]},";
                }
                $chart_config[$key]['yt'] .= "]},options:{scales:{y:{suggestedMin:0,ticks:{stepSize:1}}}}}";
            }

            foreach ($categories as $ctg_key => $category) {
                // chartjs: monthly trending per category
                if (!empty($mtt_category[(count($categories) * $key) + $ctg_key])) {
                    $chart_config[$key]['mtpc'][$ctg_key] = "{type:'bar',data:{labels:['Count'],datasets:[";
                    for ($k = 0; $k < count($mtt_category[(count($categories) * $key) + $ctg_key]); $k++) {
                        $chart_config[$key]['mtpc'][$ctg_key] .= "{label:'" . $mtt_category[(count($categories) * $key) + $ctg_key][$k]['product_name'] . "'";
                        $chart_config[$key]['mtpc'][$ctg_key] .= ",backgroundColor:'" . $colors[$k] . "',data:[" . $mtt_category[(count($categories) * $key) + $ctg_key][$k]['total_count'] . "]},";
                    }
                    $chart_config[$key]['mtpc'][$ctg_key] .= "]},options:{scales:{y:{suggestedMin:0,ticks:{stepSize:1}}}}}";
                }

                // chartjs: yearly trending per category
                if (!empty($ytt_category[(count($categories) * $key) + $ctg_key])) {
                    $chart_config[$key]['ytpc'][$ctg_key] = "{type:'bar',data:{labels:['Count'],datasets:[";
                    for ($k = 0; $k < count($ytt_category[(count($categories) * $key) + $ctg_key]); $k++) {
                        $chart_config[$key]['ytpc'][$ctg_key] .= "{label:'" . $ytt_category[(count($categories) * $key) + $ctg_key][$k]['product_name'] . "'";
                        $chart_config[$key]['ytpc'][$ctg_key] .= ",backgroundColor:'" . $colors[$k] . "',data:[" . $ytt_category[(count($categories) * $key) + $ctg_key][$k]['total_count'] . "]},";
                    }
                    $chart_config[$key]['ytpc'][$ctg_key] .= "]},options:{scales:{y:{suggestedMin:0,ticks:{stepSize:1}}}}}";
                }
            }
        }
        return PDF::loadView('livewire.market.report', [
            'report' => $report,
            'years' => $years,
            'categories' => $categories,
            'monthly_top_trending' => $monthly_top_trending,
            'yearly_top_trending' => $yearly_top_trending,
            'mtt_category' => $mtt_category,
            'ytt_category' => $ytt_category,
            'chart_config' => $chart_config
        ])->setOptions([
            'defaultFont' => 'Nunito',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ])->setPaper('letter', 'portrait')->stream();
    }
}
