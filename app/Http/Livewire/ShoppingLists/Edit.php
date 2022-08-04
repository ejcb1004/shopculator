<?php

namespace App\Http\Livewire\ShoppingLists;

use App\Models\Product;
use Livewire\Component;

class Edit extends Component
{
    protected $listeners = ['product_add' => 'product_add'];

    public $budget, $total, $items;
    public $prefix;
    public $products;
    public $list_details;
    public $new_detail;
    public $prices;

    public function inspect_ld()
    {
        //$index = array_search($this->new_detail['product_id'], array_column($this->list_details, 'product_id'));
        //dd(in_array($this->new_detail['product_id'], $this->list_details[$index]));
        dd($this->list_details);
    }

    public function inspect_pr()
    {
        dd($this->prices);
    }

    public function populate()
    {
        // Populate array with list details
        $this->list_details[] = [
            'index' => empty($this->list_details) ? 0 : array_key_last($this->list_details) + 1,
            'product_id' => $this->new_detail['product_id'],
            'image_path' => $this->new_detail['image_path'],
            'quantity' => 1,
            'product_name' => $this->new_detail['product_name'],
            'price' => $this->new_detail['price'],
        ];
        $this->items++;
    }

    public function product_add($id)
    {
        // Retrieve record based on id
        $this->new_detail = Product::where('id', $id)->get()->toArray()[0];

        // if product id of new detail matches an existing record in the array
        $index = array_search($this->new_detail['product_id'], array_column($this->list_details, 'product_id'));
        if (!empty($this->new_detail) && !empty($this->list_details)) {
            if (in_array($this->new_detail['product_id'], $this->list_details[$index]))
                $this->list_details[$index]['quantity']++;
            else $this->populate();
        } else {
            $this->populate();
        }
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
        $this->list_details = array_values($this->list_details);
        for ($i = 0; $i < count($this->list_details); $i++) $this->list_details[$i]['index'] = $i;
    }

    public function mount()
    {
        $this->products = Product::all();
        $this->list_details = [];
        $this->prices = [];
        $this->budget = 0;
        $this->items = 0;
        $this->total = 0;
        $this->prefix = 'http://127.0.0.1:3000';
    }

    public function render()
    {
        return view('livewire.shopping-lists.edit');
    }
}
