<?php

namespace App\Http\Livewire\Market;

use App\Models\Category;
use App\Models\ListDetail;
use App\Models\Market;
use App\Models\Product;
use App\Models\ShoppingList;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class MarketIndex extends Component
{
    use WithPagination;

    // collections
    public $markets;
    public $categories;
    public $subcategories;

    // search filters
    public $selectedmarket = null;
    public $selectedsubcategory = null;
    public $selectedsort = "asc";
    public $searchproduct = "";

    // livewire methods
    public function mount()
    {
        $this->markets = Market::all();
        $this->categories = Category::all();
        $this->subcategories = Subcategory::all();
    }

    public function render()
    {        
        return view('livewire.market.market-index', [
            'products' => Product::with(['market', 'category'])
                ->when($this->selectedmarket, function ($query) {
                    $query->where('market_id', $this->selectedmarket);
                })
                ->when($this->selectedsubcategory, function ($query) {
                    $query->where('subcategory_id', $this->selectedsubcategory);
                })
                ->orderBy('price', $this->selectedsort)
                ->search(trim($this->searchproduct))
                ->paginate(8)
        ]);
    }
}
