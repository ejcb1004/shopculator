<?php

namespace App\Http\Livewire\ShoppingLists;

use App\Models\ShoppingList;
use Livewire\Component;

class Index extends Component
{

    public $searchterm = '';
    public $selectall = false;
    public $shoppinglists;
    public $checkboxticked;

    public function check_listid()
    {
        dd($this->checkboxticked);
    }

    public function updatedSelectAll($value)
    {
        $value ? $this->checkboxticked = ShoppingList::pluck('id') : $this->checkboxticked = [];
    }
    
    public function mount()
    {
        $this->checkboxticked = [];
    }


    public function render()
    {
        $this->shoppinglists = ShoppingList::where('list_name', 'like', '%' . $this->searchterm . '%')->get();
        return view('livewire.shopping-lists.index');
    }
}
