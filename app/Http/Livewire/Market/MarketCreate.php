<?php

namespace App\Http\Livewire\Market;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class MarketCreate extends Component
{
    // collections
    public $categories;
    public $subcategories;

    // strings
    public $product_id;
    public $market_id;
    public $image_path;
    public $product_name;
    public $subcategory_id;
    public $price;
    public $existing_product;
    public $existing_image;
    
    // boolean
    public $to_confirm;

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
        $this->subcategory_id = "S000001";
        $this->to_confirm = false;
        $this->market_id = DB::table('markets')
        ->join('users', 'markets.email', '=', 'users.email')
        ->where('users.email', Auth::user()->email)
        ->pluck('markets.market_id')
        ->first();
    }

    public function render()
    {
        if(Auth::user()->role_id != 'R2') abort(403);
        else return view('livewire.market.market-create');
    }

    public function updatedProductName()
    {
        $this->existing_product = Product::where('product_name', $this->product_name)
        ->where('is_deleted', 0)
        ->pluck('product_name')
        ->first();
    }

    public function updatedImagePath()
    {
        $this->existing_image = Product::where('image_path', $this->image_path)
        ->where('is_deleted', 0)
        ->pluck('image_path')
        ->first();
    }

    public function store()
    {
        $this->to_confirm = false;
        $this->validate();
        $product = Product::create([
            'product_id' => '',
            'market_id' => $this->market_id,
            'subcategory_id' => $this->subcategory_id,
            'product_name' => $this->product_name,
            'price' => $this->price,
            'image_path' => $this->image_path
        ]);
        $product->product_id = "P" . str_pad($product->id, 8, "0", STR_PAD_LEFT);
        $product->save();

        $this->reset(
            'product_id', 
            'market_id',
            'subcategory_id',
            'product_name',
            'price',
            'image_path'
        );

        session()->flash('flash.banner', 'Product successfully created!');
        session()->flash('flash.bannerStyle', 'success');

        return redirect('market');
    }

    // user-defined method
    public function confirm()
    {
        $this->to_confirm = true;
    }
}
