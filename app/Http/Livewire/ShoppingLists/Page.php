<?php

namespace App\Http\Livewire\ShoppingLists;

use Livewire\Component;

class Page extends Component
{
    public $data;
    public $budget;
    public $total;
    public $created_at;
    
    public function render()
    {
        return view('livewire.shopping-lists.page');
    }
}
