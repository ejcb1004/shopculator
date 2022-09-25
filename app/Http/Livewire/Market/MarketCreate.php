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
    
    public $to_confirm;

    protected $rules = [
        'subcategory_id' => [
            'required',
            'unique:subcategories,subcategory_id',
            'string',
            'max:255'
        ],
        'product_name' => [
            'required',
            'unique:products,product_name',
            'string',
            'max:255'
        ],
        'price' => [
            'required',
            'min:0'
        ],
        'image_path' => [
            'string'
        ],
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            'unique:users'
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

    public function store()
    {
        $this->to_confirm = false;
        $product = Product::create([
            'product_id' => '',
            'market_id' => $this->market_id,
            'subcategory_id' => $this->subcategory_id,
            'product_name' => $this->product_name,
            'price' => $this->price,
            'image_path' => $this->image_path
        ]);
        $product->product_id = "M" . str_pad($product->id, 8, "0", STR_PAD_LEFT);
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
