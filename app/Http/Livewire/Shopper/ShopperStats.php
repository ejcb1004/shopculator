<?php

namespace App\Http\Livewire\Shopper;

use App\Models\ListDetail;
use App\Models\ShoppingList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShopperStats extends Component
{
    public $total_lists;
    public $total_lists_monthly;
    public $total_lists_yearly;
    public $an_years;
    public $mo_years;
    public $colors;

    public $list_count;
    public $active_list_count;
    public $completed_list_count;
    public $monthly_top_trending;
    public $yearly_top_trending;

    public function mount()
    {
        $this->an_years = ShoppingList::select(DB::raw('YEAR(updated_at) as year'))
            ->where('email', Auth::user()->email)
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')->toArray();

        $this->mo_years = ShoppingList::select(DB::raw('YEAR(updated_at) as year'))
            ->where('email', Auth::user()->email)
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

        $this->total_lists = [
            'labels' => [
                'Active',
                'Completed'
            ],
            'data' => [
                count(ShoppingList::where('email', Auth::user()->email)
                    ->where('list_status', 1)
                    ->where('email', Auth::user()->email)
                    ->pluck('list_id')->toArray()),
                count(ShoppingList::where('email', Auth::user()->email)
                    ->where('list_status', 2)
                    ->where('email', Auth::user()->email)
                    ->pluck('list_id')->toArray())
            ]
        ];

        $total_lists_monthly = [];
        $this->total_lists_monthly = [];
        $this->total_lists_yearly = [];

        $this->monthly_top_trending = [];
        $this->yearly_top_trending = [];

        foreach ($this->an_years as $x => $year) {
            $this->total_lists_monthly[$x] = [];
            for ($j = 0; $j < 12; $j++) {
                array_push($this->total_lists_monthly[$x], [
                    'month' => $j + 1,
                    'active_count' => 0,
                    'completed_count' => 0,
                    'month_count' => 0
                ]);
            }

            array_push($this->total_lists_yearly, [
                'year' => $year,
                'active_count' => 0,
                'completed_count' => 0,
                'year_count' => 0
            ]);

            array_push(
                $total_lists_monthly,
                ShoppingList::where('email', Auth::user()->email)
                    ->whereYear('updated_at', $year)
                    ->select(
                        DB::raw('MONTH(updated_at) AS month'),
                        'list_status',
                        DB::raw('COUNT(*) AS month_count')
                    )
                    ->groupBy('month', 'list_status')
                    ->get()
                    ->toArray()
            );

            foreach ($total_lists_monthly[$x] as $value) {
                if ($value['list_status'] == 1) $this->total_lists_monthly[$x][$value['month'] - 1]['active_count'] = $value['month_count'];
                elseif ($value['list_status'] == 2) $this->total_lists_monthly[$x][$value['month'] - 1]['completed_count'] = $value['month_count'];
                $this->total_lists_monthly[$x][$value['month'] - 1]['month_count'] = $this->total_lists_monthly[$x][$value['month'] - 1]['active_count'] + $this->total_lists_monthly[$x][$value['month'] - 1]['completed_count'];
            }

            array_push(
                $this->yearly_top_trending,
                ListDetail::select(
                    'products.product_name',
                    'products.image_path',
                    DB::raw('COUNT(*) as total_count'),
                )
                    ->join('products', 'list_details.product_id', '=', 'products.product_id')
                    ->join('shopping_lists', 'list_details.list_id', '=', 'shopping_lists.list_id')
                    ->where('shopping_lists.email', Auth::user()->email)
                    ->whereYear('shopping_lists.updated_at', $year)
                    ->limit(5)
                    ->groupBy('products.product_name', 'products.image_path')
                    ->orderBy('total_count', 'desc')
                    ->orderBy('products.product_name', 'asc')
                    ->get()
                    ->toArray()
            );
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
                    ->where('shopping_lists.email', Auth::user()->email)
                    ->whereYear('shopping_lists.updated_at', $year)
                    ->whereMonth('shopping_lists.updated_at', DB::raw('MONTH(NOW())'))
                    ->limit(5)
                    ->groupBy('products.product_name', 'products.image_path')
                    ->orderBy('total_count', 'desc')
                    ->orderBy('products.product_name', 'asc')
                    ->get()
                    ->toArray()
            );
        }

        $total_lists_yearly = ShoppingList::where('email', Auth::user()->email)
            ->select(DB::raw('YEAR(updated_at) AS year'), 'list_status', DB::raw('COUNT(*) AS year_count'))
            ->groupBy('year', 'list_status')
            ->orderBy('year', 'desc')
            ->get()
            ->toArray();

        foreach ($total_lists_yearly as $value) {
            if ($value['list_status'] == 1) $this->total_lists_yearly[array_search($value['year'], $this->an_years)]['active_count'] = $value['year_count'];
            elseif ($value['list_status'] == 2) $this->total_lists_yearly[array_search($value['year'], $this->an_years)]['completed_count'] = $value['year_count'];
            $this->total_lists_yearly[array_search($value['year'], $this->an_years)]['year_count'] = $this->total_lists_yearly[array_search($value['year'], $this->an_years)]['active_count'] + $this->total_lists_yearly[array_search($value['year'], $this->an_years)]['completed_count'];
        }

        $this->list_count = count(ShoppingList::where('email', Auth::user()->email)
            ->where('list_status', 1)
            ->orWhere('list_status', 2)
            ->where('email', Auth::user()->email)
            ->pluck('list_id')->toArray());

        $this->active_list_count = count(ShoppingList::where('email', Auth::user()->email)
            ->where('list_status', 1)
            ->pluck('list_id')->toArray());

        $this->completed_list_count = count(ShoppingList::where('email', Auth::user()->email)
            ->where('list_status', 2)
            ->pluck('list_id')->toArray());
    }

    public function render()
    {
        //dd($this->total_lists_yearly);
        if (Auth::user()->role_id != 'R3') abort(403);
        else return view('livewire.shopper.shopper-stats');
    }

    public function monthly_list_sum($arr)
    {
        $list_sum = 0;
        foreach ($arr as $item) {
            $list_sum += $item['month_count'];
        }
        return $list_sum;
    }

    public function yearly_list_sum($arr)
    {
        $list_sum = 0;
        foreach ($arr as $item) {
            $list_sum += $item['year_count'];
        }
        return $list_sum;
    }

    public function active_list_sum($arr)
    {
        $list_sum = 0;
        foreach ($arr as $item) {
            $list_sum += $item['active_count'];
        }
        return $list_sum;
    }

    public function completed_list_sum($arr)
    {
        $list_sum = 0;
        foreach ($arr as $item) {
            $list_sum += $item['completed_count'];
        }
        return $list_sum;
    }
}
