<?php

namespace App\Http\Livewire\ShoppingLists;

use App\Models\Product;
use Illuminate\Support\Arr;
use Livewire\Component;

class Create extends Component
{
    protected $listeners = ['product_add' => 'product_add'];

    public $budget = 0;
    public $prefix = 'http://127.0.0.1:3000';
    public $total = 69;
    public $items = 0;
    public $products;
    public $list_details = [];
    public $new_detail;

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

    public function mount() {
        $this->products = Product::all();
    }

    public function render()
    {
        
        return view('livewire.shopping-lists.create');
    }   
}
