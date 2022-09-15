<?php

namespace App\Http\Livewire\Market;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MarketCreate extends Component
{
    // collections
    public $categories;
    public $subcategories;

    public $image_path;
    
    public function mount()
    {
        $this->categories = Category::all();
        $this->subcategories = Subcategory::all();
    }

    public function render()
    {
        if(Auth::user()->role_id != 'R2') abort(403);
        else return view('livewire.market.market-create');
    }
}
