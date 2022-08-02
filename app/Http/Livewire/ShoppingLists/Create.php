<?php

namespace App\Http\Livewire\ShoppingLists;

use App\Models\Category;
use App\Models\Market;
use App\Models\Product;
use Illuminate\Support\Arr;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;
    protected $listeners = ['product_add' => 'product_add'];

    public $budget = 0;
    public $prefix = 'http://127.0.0.1:3000';
    public $total = 69;
    public $items = 0;
    public $markets;
    public $categories;
    public $list_details = [];
    public $new_detail;

    // search filters
    public $itemsearch;
    public $marketfilter;
    public $categoryfilter; 
    public $sortfilter = 'asc';
    
    public function render()
    {    
        return view('livewire.shopping-lists.create',[
            'products'=>Product::orderBy('product_name','asc')->paginate(8)
        ]);
    } 

    public function product_add($id)
    {
        $this->new_detail = Product::where('id', $id)->get();
        $this->list_details[] = [
            'id' => Arr::get($this->new_detail, '0.id'),
            'product_id' => Arr::get($this->new_detail, '0.product_id'),
            'image_path' => Arr::get($this->new_detail, '0.image_path'),
            'quantity' => 1,
            'product_name' => Arr::get($this->new_detail, '0.product_name'),
            'price' => Arr::get($this->new_detail, '0.price')
        ];
        $this->items++;
    }

    public function quantity_sub() {
        // Subtract quantity of specific list detail
    }

    public function quantity_add() {
        // Add quantity of specific list detail
        dd($this->new_detail);
    }
    public function mount(){
        $this->markets = Market::all();
        $this->categories = Category::all();
    }
}
