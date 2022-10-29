<?php

namespace App\Http\Livewire\Market;

use App\Models\Category;
use App\Models\Market;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class MarketEdit extends Component
{
    // collections
    public $categories;
    public $subcategories;

    // boolean
    public $confirm_edit;
    public $confirm_delete;

    // strings
    public $image_path;
    public $product_id;
    public $market_id;
    public $product_info;
    public $current_subcategory;
    public $product_name;
    public $subcategory_id;
    public $price;
    public $existing_product;
    public $existing_image;

    // rules
    protected $rules = [
        'subcategory_id' => [
            'required',
            'string',
            'max:255'
        ],
        'product_name' => [
            'required',
            'string',
            'min:3',
            'max:255'
        ],
        'price' => [
            'required',
            'min:0'
        ],
        'image_path' => [
            'string',
            'required'
        ]
    ];

    public function mount()
    {
        $this->categories = Category::all();
        $this->subcategories = Subcategory::all();
        $this->product_info = Product::where('product_id', $this->product_id)->get();
        $this->product_name = $this->product_info[0]->product_name;
        $this->subcategory_id = $this->product_info[0]->subcategory_id;
        $this->price = $this->product_info[0]->price;
        $this->image_path = $this->product_info[0]->image_path;
        $this->current_subcategory = $this->product_info[0]->subcategory_id;
        $this->market_id = Market::where('email', Auth::user()->email)->pluck('market_id')->first();
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R2' || Product::where('product_id', $this->product_id)->pluck('market_id')->first() != $this->market_id ) abort(403);
        else return view('livewire.market.market-edit');
    }

    public function confirm_edit_fn()
    {
        $this->confirm_edit = true;
    }

    public function confirm_delete_fn()
    {
        $this->confirm_delete = true;
    }

    public function updatedProductName()
    {
        $this->existing_product = Product::where('product_name', $this->product_name)
        ->where('product_id', '!=', $this->product_id)
        ->pluck('product_name')
        ->first();
    }

    public function updatedImagePath()
    {
        $this->existing_image = Product::where('image_path', $this->image_path)
        ->where('product_id', '!=', $this->product_id)
        ->pluck('image_path')
        ->first();
    }

    public function store()
    {
        $this->confirm_edit = false;
        Product::where('product_id', $this->product_id)->update([
            'product_name' => $this->product_name,
            'subcategory_id' => $this->subcategory_id,
            'price' => $this->price,
            'image_path' => $this->image_path
        ]);

        $this->reset(
            'product_name',
            'subcategory_id',
            'price',
            'image_path',
        );

        session()->flash('flash.banner', 'Product successfully updated!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect('market');
    }

    public function delete()
    {
        $this->confirm_delete = false;
        Product::where('product_id', $this->product_id)->update([
            'is_deleted' => 1
        ]);

        session()->flash('flash.banner', 'Product successfully deleted!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect('market');
    }
}
