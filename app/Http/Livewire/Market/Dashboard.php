<?php

namespace App\Http\Livewire\Market;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Dashboard extends Component
{
    public $products;
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
            ->groupBy('list_details.product_id')
            ->pluck(DB::raw('count(*) as total'))
            ->toArray();
        $this->products = DB::table('list_details')
            ->join('products', 'list_details.product_id', '=', 'products.product_id')
            ->where('products.market_id', $this->market)
            ->limit(count($this->data))
            ->pluck('products.product_name')
            ->toArray();
    }

    public function render()
    {
        return view('livewire.market.dashboard', [
            'products' => $this->products,
            'data' => $this->data
        ]);
    }
}
