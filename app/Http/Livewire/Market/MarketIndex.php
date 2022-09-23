<?php

namespace App\Http\Livewire\Market;

use App\Exports\ProductsExport;
use App\Imports\ProductsImport;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class MarketIndex extends Component
{
    use WithPagination;
    use WithFileUploads;

    // string
    public $market;
    public $product_id;

    // collections
    public $markets;
    public $categories;
    public $subcategories;

    // boolean
    public $confirm_delete;

    //special
    public $file;

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
            ->pluck('markets.market_id')
            ->first();
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

    public function export($market_id)
    {
        return Excel::download(new ProductsExport($market_id), 'products.csv');
    }

    public function import(Request $request)
    {
        Excel::import(new ProductsImport, $request->file('file')->store('temp'));
        session()->flash('flash.banner', 'Batch import successful!');
        session()->flash('flash.bannerStyle', 'success');
        return back();
    }
}
