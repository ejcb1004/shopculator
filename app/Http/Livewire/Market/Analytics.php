<?php

namespace App\Http\Livewire\Market;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Analytics extends Component
{
    public $market;
    public $products;
    public $counts;
    public $contents;
    public $titles;

    public function mount()
    {
        $this->market = DB::table('markets')
            ->join('users', 'users.email', '=', 'markets.email')
            ->where('users.email', Auth::user()->email)
            ->pluck('markets.market_id');
        try {
            $this->products = [
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
    
            $this->counts = [
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

            for ($i = 0; $i < count($this->titles); $i++) {
                for ($j = 0; $j < count($this->products[$i]); $j++) {
                    $this->contents[$i][$j] = [
                        'product' => $this->products[$i][$j],
                        'count' => $this->counts[$i][$j]
                    ];
                }
            }
            
        } catch (QueryException $qe) {
            $this->contents = null;
            $this->titles = null;
        }
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R2') abort(403);
        // dd($this->contents, $this->titles);
        return view('livewire.market.analytics', [
            'contents' => $this->contents,
            'titles' => $this->titles
        ]);
    }
}
