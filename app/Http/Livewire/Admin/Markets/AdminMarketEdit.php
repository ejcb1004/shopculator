<?php

namespace App\Http\Livewire\Admin\Markets;

use App\Models\Market;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminMarketEdit extends Component
{
    public $market_id;
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
        $market = Market::where('market_id', $this->market_id)->get();
        foreach ($market as $data) {
            $this->market_name = $data->market_name;
            $this->email = $data->email;
        }
        $this->to_confirm = false;
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R1') abort(403);
        else return view('livewire.admin.markets.admin-market-edit');
    }

    public function store()
    {
        $this->to_confirm = false;
        Market::where('market_id', $this->market_id)->update([
            'market_name' => $this->market_name,
            'email' => $this->email,
        ]);

        $this->reset('market_name', 'email');

        session()->flash('flash.banner', 'Market successfully updated!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect('admin/markets');
    }

    // user-defined method
    public function confirm()
    {
        $this->to_confirm = true;
    }
}
