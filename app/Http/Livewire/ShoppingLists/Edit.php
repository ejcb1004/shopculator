<?php

namespace App\Http\Livewire\ShoppingLists;

use Livewire\Component;

class Edit extends Component
{
    public $budget;
    public $total = 69;
    public $items = 1;
    public $term;


    public $products = [
        [
            'image' => 'Photo',
            'name' => 'Maling',
            'price' => '197.00',
        ]
    ];


    public function addProduct()
    {
        $this->products[] = [
            'image' => 'Photo',
            'name' => 'New Product',
            'price' => '000.00',
            $this->items++
        ];
    }

    public function render()
    {
        return view('livewire.shopping-lists.edit');
    }
}
