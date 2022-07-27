<?php

namespace App\Http\Livewire\ShoppingLists;

use Livewire\Component;

class Index extends Component
{
    public $show = false;

    public function showContextmenu(){
        $this->show = true;
    }
    public function render()
    {
        return view('livewire.shopping-lists.index');
    }
}
