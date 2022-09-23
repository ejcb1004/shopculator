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

    // string
    public $market;
    public $product_id;

    // collections
    public $markets;
    public $categories;
    public $subcategories;

    // boolean
    public $confirm_delete;

    // search filters
    public $selectedsubcategory = null;
    public $selectedsort = "asc";
    public $searchproduct = "";

    // livewire methods
    public function mount()
    {
        $this->categories = Category::all();
        $this->subcategories = Subcategory::all();
        $this->market = DB::table('markets')
            ->join('users', 'users.email', '=', 'markets.email')
            ->where('users.email', Auth::user()->email)
            ->pluck('markets.market_id');
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R2') abort(403);
        else return view('livewire.market.market-index', [
            'products' => Product::with(['market', 'category'])
                ->when($this->selectedsubcategory, function ($query) {
                    $query->where('subcategory_id', $this->selectedsubcategory);
                })
                ->where('market_id', $this->market)
                ->where('is_deleted', 0)
                ->orderBy('price', $this->selectedsort)
                ->search(trim($this->searchproduct))
                ->paginate(8)
        ]);
    }

    // user-defined methods
    public function confirm_delete_fn($product_id)
    {
        $this->confirm_delete = true;
        $this->product_id = $product_id;
    }

    public function delete()
    {
        $this->confirm_delete = false;
        Product::where('id', $this->product_id)->update([
            'is_deleted' => 1
        ]);

        session()->flash('flash.banner', 'Product successfully deleted!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect('market');
    }
}
