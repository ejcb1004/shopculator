<?php

namespace App\Http\Livewire\ShoppingLists;

use App\Models\ListDetail;
use App\Models\Product;
use Illuminate\Support\Arr;
use Livewire\Component;

class Edit extends Component
{
    protected $listeners = ['product_add' => 'product_add'];

    public $budget = 0;
    public $prefix = 'http://127.0.0.1:3000';
    public $total = 69;
    public $items = 0;
    public $products;
    public $list_details = [];
    public $new_detail;

    public function inspect_ld()
    {
        foreach ($this->new_detail as $detail) 
            dd($detail->product_id);
    }

    public function inspect_pr()
    {
        dd($this->products);
    }

    public function product_add($id)
    {
        // Retrieve record based on id
        $this->new_detail = Product::where('id', $id)->get();

        // if product id of new detail matches an existing record in the array

        // Populate array with list details
        $this->list_details[] = [
            'is_checked' => false,
            'index' => empty($this->list_details) ? 0 : array_key_last($this->list_details) + 1,
            'product_id' => Arr::get($this->new_detail, '0.product_id'),
            'image_path' => Arr::get($this->new_detail, '0.image_path'),
            'quantity' => 1,
            'product_name' => Arr::get($this->new_detail, '0.product_name'),
            'price' => Arr::get($this->new_detail, '0.price'),
        ];
        $this->items++;
    }

    public function quantity_sub($index)
    {
        ($this->list_details[$index]['quantity'] > 1) ? $this->list_details[$index]['quantity']-- : $this->remove_item($index);
    }

    public function quantity_add($index)
    {
        $this->list_details[$index]['quantity']++;
    }

    public function remove_item($index)
    {
        unset($this->list_details[$index]);
        $this->items--;
    }

    public function mount()
    {
        $this->products = Product::all();
    }

    public function render()
    {

        return view('livewire.shopping-lists.edit');
    }
}
