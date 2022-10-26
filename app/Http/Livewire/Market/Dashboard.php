<?php

namespace App\Http\Livewire\Market;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $market;
    public $labels;
    public $data;
    public $titles;

    public function mount()
    {
        $this->market = DB::table('markets')
            ->join('users', 'users.email', '=', 'markets.email')
            ->where('users.email', Auth::user()->email)
            ->pluck('markets.market_id');
        try {
            $this->labels = [
                DB::table('list_details')
                    ->join('products', 'list_details.product_id', '=', 'products.product_id')
                    ->where('products.market_id', $this->market)
                    ->groupBy('products.product_name')
                    ->orderBy(DB::raw('count(*)'), 'desc')
                    ->pluck('products.product_name')
                    ->toArray(),
                DB::table('list_details')
                    ->join('products', 'list_details.product_id', '=', 'products.product_id')
                    ->where('products.market_id', $this->market)
                    ->groupBy('products.product_name')
                    ->orderBy(DB::raw('count(*)'), 'desc')
                    ->limit(10)
                    ->pluck('products.product_name')
                    ->toArray(),
                DB::table('list_details')
                    ->join('products', 'list_details.product_id', '=', 'products.product_id')
                    ->where('products.market_id', $this->market)
                    ->groupBy('products.product_name')
                    ->orderBy(DB::raw('count(*)'), 'asc')
                    ->pluck('products.product_name')
                    ->toArray()
            ];
    
            $this->data = [
                DB::table('list_details')
                    ->join('products', 'list_details.product_id', '=', 'products.product_id')
                    ->where('products.market_id', $this->market)
                    ->groupBy('products.product_name')
                    ->orderBy('total', 'desc')
                    ->pluck(DB::raw('count(*) as total'))
                    ->toArray(),
                DB::table('list_details')
                    ->join('products', 'list_details.product_id', '=', 'products.product_id')
                    ->where('products.market_id', $this->market)
                    ->groupBy('products.product_name')
                    ->orderBy('total', 'desc')
                    ->limit(10)
                    ->pluck(DB::raw('count(*) as total'))
                    ->toArray(),
                DB::table('list_details')
                    ->join('products', 'list_details.product_id', '=', 'products.product_id')
                    ->where('products.market_id', $this->market)
                    ->groupBy('products.product_name')
                    ->orderBy('total', 'asc')
                    ->pluck(DB::raw('count(*) as total'))
                    ->toArray()
            ];
            
            $this->titles = [
                'Most trending',
                'Most trending (Top 10)',
                'Least trending'
            ];

        } catch (QueryException $qe) {
            $this->labels = null;
            $this->data = null;
            $this->titles = null;
        }
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R2') abort(403);
        // dd($this->labels, $this->data, $this->titles);
        return view('livewire.market.dashboard', [
            'labels' => $this->labels,
            'data' => $this->data,
            'titles' => $this->titles
        ]);
    }
}
