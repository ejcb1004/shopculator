<?php

namespace App\Http\Livewire\Shopper;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Page extends Component
{
    public $data;
    public $budget;
    public $total;
    public $created_at;

    public function render()
    {
        if (Auth::user()->role_id != 'R3') abort(403);
        else return view('livewire.shopper.page');
    }
}
