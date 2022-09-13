<?php

namespace App\Http\Livewire\Shopper;

use Livewire\Component;

class Page extends Component
{
    public $data;
    public $budget;
    public $total;
    public $created_at;
    
    public function render()
    {
        return view('livewire.shopper.page');
    }
}
