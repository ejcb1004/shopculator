<?php

namespace App\Http\Livewire\ShoppingLists;

use App\Models\ShoppingList;
use Livewire\Component;

class Index extends Component
{

    public $searchterm ='';
    public $shoppinglists;


    
    public function render()
    {
        $this->shoppinglists = ShoppingList::where('list_name','like','%'.$this->searchterm.'%')->get();
        return view('livewire.shopping-lists.index');
    }
}
