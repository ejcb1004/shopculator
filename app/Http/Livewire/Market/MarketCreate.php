<?php

namespace App\Http\Livewire\Market;

use App\Models\Category;
use App\Models\Subcategory;
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
        return view('livewire.market.market-create');
    }
}
