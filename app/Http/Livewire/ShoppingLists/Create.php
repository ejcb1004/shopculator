<?php

namespace App\Http\Livewire\ShoppingLists;

use App\Models\Product;
use Illuminate\Support\Arr;
use Livewire\Component;

class Create extends Component
{
    public $budget;
    public $prefix = 'http://127.0.0.1:3000';
    public $total = 69;
    public $items = 0;
    public $products = [];
    public $list_details = [];
    public $keys = [];
    public $index = 1;

    public function addProduct()
    {
        $added = Product::where('id', $this->index)->get()->toArray();
        $this->list_details[] = [
            'image_path' => Arr::get($added, '0.image_path'),
            'product_name' => Arr::get($added, '0.product_name'),
            'price' => Arr::get($added, '0.price')
        ];
        $this->items++;
    }

    public function render()
    {
        $this->products = Product::all()->toArray();
        return view('livewire.shopping-lists.create');
    }
}
