<?php

namespace App\Http\Livewire\ShoppingLists;

use App\Models\Category;
use App\Models\ListDetail;
use App\Models\Market;
use App\Models\Product;
use App\Models\ShoppingList;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Create extends Component
{
    use WithPagination;
    protected $listeners = ['product_add' => 'product_add'];

    // int
    public $budget, $total, $items = 0;

    // string
    public $prefix;
    public $list_name;

    // array
    public $list_details = [];
    public $new_detail = [];
    public $productchecked = [];

    // collections
    public $markets;
    public $categories;

    // search filters
    public $selectedmarket = null;
    public $selectedcategory = null;
    public $selectedsort = "asc";
    public $searchproduct = "";

    // rules
    protected $rules = [
        'list_name' => [
            'required',
            'unique:shopping_lists,list_name',
            'min:3',
            'max:30'
        ],
        'budget' => [
            'required',
            'min:0'
        ]
    ];

    // livewire methods
    public function mount()
    {
        $this->markets = Market::all();
        $this->categories = Category::all();
        $this->list_details = [];
        $this->productchecked = [];
        $this->budget = 0;
        $this->items = 0;
        $this->total = 0;
        $this->prefix = 'http://127.0.0.1:3000';
    }

    public function render()
    {
        return view('livewire.shopping-lists.create', [
            'products' => Product::with(['market', 'category'])
                ->when($this->selectedmarket, function ($query) {
                    $query->where('market_id', $this->selectedmarket);
                })
                ->when($this->selectedcategory, function ($query) {
                    $query->where('category_id', $this->selectedcategory);
                })
                ->orderBy('price', $this->selectedsort)
                ->search(trim($this->searchproduct))
                ->paginate(8)
        ]);
    }

    public function updated($property_name)
    {
        $this->validateOnly($property_name);
    }

    public function updatedProductChecked()
    {
        $this->totalize();
    }

    public function store()
    {
        $list = ShoppingList::create([
            'list_id'   => '',
            'email'     => Auth::user()->email,
            'list_name' => $this->list_name,
            'budget'    => $this->budget,
            'total'     => $this->total,
        ]);

        $list->list_id = "L" . str_pad($list->id, 8, "0", STR_PAD_LEFT);

        foreach ($this->list_details as $detail) {
            $list_detail = ListDetail::create([
                'detail_id' => '',
                'list_id' => $list->list_id,
                'product_id' => $detail['product_id'],
                'image_path' => $detail['image_path'],
                'quantity' => $detail['quantity'],
                'price' => $detail['quantity'] * $detail['price']
            ]);
            $list_detail->detail_id = "D" . str_pad($list_detail->id, 12, "0", STR_PAD_LEFT);
            $list_detail->save();
        }

        $list->save();

        $this->reset(
            'list_details',
            'list_name',
            'budget',
            'total',
            'items',
            'productchecked',
            'selectedmarket',
            'selectedcategory'
        );
        
        session()->flash('flash.banner', 'List successfully created!');
        session()->flash('flash.bannerStyle', 'success');
        
        return redirect('shopping-lists');
    }

    // user-defined methods
    public function inspect_ld()
    {
        dd($this->list_details);
    }

    public function inspect_prid()
    {
        dd($this->productchecked);
    }

    public function populate()
    {
        // Populate array with list details
        $this->list_details[] = [
            'index'         => empty($this->list_details) ? 0 : array_key_last($this->list_details) + 1,
            'product_id'    => $this->new_detail['product_id'],
            'image_path'    => $this->new_detail['image_path'],
            'quantity'      => 1,
            'product_name'  => $this->new_detail['product_name'],
            'price'         => $this->new_detail['price'],
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

    public function totalize()
    {
        $this->total = 0;
        foreach ($this->list_details as $detail) {
            if (in_array($detail['product_id'], $this->productchecked)) {
                $this->total += ($detail['price'] * $detail['quantity']);
            }
        }
    }

    public function quantity_sub($index)
    {
        ($this->list_details[$index]['quantity'] > 1) ? $this->list_details[$index]['quantity']-- : $this->remove_item($index);
        $this->totalize();
    }

    public function quantity_add($index)
    {
        $this->list_details[$index]['quantity']++;
        $this->totalize();
    }

    public function remove_item($index)
    {
        unset($this->list_details[$index]);
        unset($this->productchecked[$index]);
        $this->items--;

        // Serialize $this->list_details array for error trapping
        $this->list_details = array_values($this->list_details);
        for ($i = 0; $i < count($this->list_details); $i++) $this->list_details[$i]['index'] = $i;

        // Serialize $this->productchecked array for error trapping
        $this->productchecked = array_values($this->productchecked);

        $this->totalize();
    }
}
