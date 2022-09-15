<?php

namespace App\Http\Livewire\Market;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MarketEdit extends Component
{
    public function render()
    {
        if(Auth::user()->role_id != 'R2') abort(403);
        else return view('livewire.market.market-edit');
    }
}
