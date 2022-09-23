<?php

namespace App\Http\Livewire\Market;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $labels;
    public $data;
    public $market;

    public function mount()
    {
        $this->market = DB::table('markets')
            ->join('users', 'users.email', '=', 'markets.email')
            ->where('users.email', Auth::user()->email)
            ->pluck('markets.market_id');
        $this->data = DB::table('list_details')
            ->join('products', 'list_details.product_id', '=', 'products.product_id')
            ->where('products.market_id', $this->market)
            ->groupBy('products.product_name')
            ->pluck(DB::raw('count(*) as total'))
            ->toArray();
        $this->labels = DB::table('list_details')
            ->join('products', 'list_details.product_id', '=', 'products.product_id')
            ->where('products.market_id', $this->market)
            ->groupBy('products.product_name')
            ->pluck('products.product_name')
            ->toArray();
    }

    public function render()
    {
        // dd($this->products, $this->data);
        return view('livewire.market.dashboard', [
            'labels' => $this->labels,
            'data' => $this->data
        ]);
    }
}
