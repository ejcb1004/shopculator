<?php

namespace App\Http\Livewire\Admin\Markets;

use App\Models\Market;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminMarketCreate extends Component
{
    public $market_name;
    public $email;

    public $to_confirm;

    protected $rules = [
        'market_name' => [
            'required',
            'unique:markets,market_name',
            'string',
            'max:255'
        ],
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            'unique:users'
        ]
    ];

    public function mount()
    {
        $this->to_confirm = false;
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R1') abort(403);
        else return view('livewire.admin.markets.admin-market-create');
    }

    public function store()
    {
        $this->to_confirm = false;
        $market = Market::create([
            'market_id' => '',
            'market_name' => $this->market_name,
            'email' => $this->email,
        ]);
        $market->market_id = "M" . str_pad($market->id, 6, "0", STR_PAD_LEFT);
        $market->save();

        $this->reset('market_name', 'email');

        session()->flash('flash.banner', 'Market successfully created!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect('admin/markets');
    }

    // user-defined method
    public function confirm()
    {
        $this->to_confirm = true;
    }
}
