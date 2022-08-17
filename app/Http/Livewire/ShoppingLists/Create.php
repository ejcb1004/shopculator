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
    public $budget, $total, $items ,$compitems = 0;
    public $complow = 0;

    // string
    public $list_name;

    // boolean
    public $to_confirm;

    // array
    public $list_details = [];
    public $new_detail = [];
    public $newcompare_detail = [];
    public $productchecked = [];
    public $compare_details = [];
    public $compareprice = [];

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
        $this->compare_details = [];
        $this->productchecked = [];
        $this->compareprice =[];
        $this->budget = 0;
        $this->items = 0;
        $this->total = 0;
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
        $this->to_confirm = false;
        if ($this->budget >= $this->total) {
            $list = ShoppingList::create([
                'list_id'       => '',
                'email'         => Auth::user()->email,
                'list_name'     => $this->list_name,
                'budget'        => $this->budget,
                'total'         => $this->total,
                'is_deleted'    => 0
            ]);

            $list->list_id = "L" . str_pad($list->id, 8, "0", STR_PAD_LEFT);

            foreach ($this->list_details as $detail) {
                $list_detail = ListDetail::create([
                    'is_checked' => (in_array($detail['product_id'], $this->productchecked)) ? 1 : 0,
                    'list_index' => $detail['list_index'],
                    'detail_id' => '',
                    'list_id' => $list->list_id,
                    'product_id' => $detail['product_id'],
                    'image_path' => $detail['image_path'],
                    'is_deleted' => $detail['is_deleted'],
                    'quantity' => $detail['quantity']
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
        else {
            session()->flash('flash.banner', 'Looks like you don\'t have enough budget. You can either increase budget or reduce the total cost.');
            session()->flash('flash.bannerStyle', 'danger');

            return redirect('shopping-lists/create');
        }
    }

    // user-defined methods
    public function inspect_ld()
    {
        dd($this->list_details);
    }

    public function inspect_checked()
    {
        dd($this->productchecked);
    }

    public function populate()
    {
        // Populate array with list details
        $this->list_details[] = [
            'is_checked'    => 0,
            'list_index'    => empty($this->list_details) ? 0 : array_key_last($this->list_details) + 1,
            'product_id'    => $this->new_detail['product_id'],
            'image_path'    => $this->new_detail['image_path'],
            'quantity'      => 1,
            'is_deleted'    => 0,
            'product_name'  => $this->new_detail['product_name'],
            'price'         => $this->new_detail['price'],
        ];
        $this->items++;
    }

    public function populatecompare()
    {
        // Populate array with list details
        $this->compare_details[] = [
            'is_checked'    => 0,
            'list_index'    => empty($this->compare_details) ? 0 : array_key_last($this->compare_details) + 1,
            'product_id'    => $this->newcompare_detail['product_id'],
            'image_path'    => $this->newcompare_detail['image_path'],
            'quantity'      => 1,
            'is_deleted'    => 0,
            'product_name'  => $this->newcompare_detail['product_name'],
            'price'         => $this->newcompare_detail['price'],
        ];
        $this->compitems++;
    }


    public function product_add($id)
    {
        // Retrieve record based on id
        $this->new_detail = Product::where('id', $id)->get()->toArray()[0];

        // if product_id of $new_detail matches an existing record in $list_details array
        $list_index = array_search($this->new_detail['product_id'], array_column($this->list_details, 'product_id'));
        if (!empty($this->new_detail) && !empty($this->list_details)) {
            if (in_array($this->new_detail['product_id'], $this->list_details[$list_index])) {
                $this->list_details[$list_index]['quantity']++;
                $this->totalize();
            } else $this->populate();
        } else {
            $this->populate();
        }
    }

    public function compare_add($id)
    {
        // Retrieve record based on id
        $this->newcompare_detail = Product::where('id', $id)->get()->toArray()[0];

        // if product_id of $new_detail matches an existing record in $list_details array
        $comparelist_index = array_search($this->newcompare_detail['product_id'], array_column($this->compare_details, 'product_id'));
        if (!empty($this->newcompare_detail) && !empty($this->compare_details)) {
            if (in_array($this->newcompare_detail['product_id'], $this->compare_details[$comparelist_index])) {
                $this->compare_details[$comparelist_index]['quantity']++;
                $this->totalizecompare();
            } else $this->populatecompare();
        } else {
            $this->populatecompare();
        }

    }

    public function totalizecompare()
    {
        $this->complow = 0;
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

    public function getlow(){
        foreach($this->compare_details as $item)
        array_push($this->compareprice, $item['price']);
        $this->complow = min($this->compareprice);
        
    }


    public function comparequantity_sub($comparelist_index)
    {
        ($this->compare_details[$comparelist_index]['quantity'] > 1) ? $this->compare_details[$comparelist_index]['quantity']-- : $this->remove_compitem($comparelist_index);
        $this->totalizecompare();
    }


    public function comparequantity_add($comparelist_index)
    {
        $this->compare_details[$comparelist_index]['quantity']++;
        $this->totalizecompare();
    }

    public function quantity_sub($list_index)
    {
        ($this->list_details[$list_index]['quantity'] > 1) ? $this->list_details[$list_index]['quantity']-- : $this->remove_item($list_index);
        $this->totalize();
    }

    public function quantity_add($list_index)
    {
        $this->list_details[$list_index]['quantity']++;
        $this->totalize();
    }

    public function remove_compitem($comparelist_index)
    {
        unset($this->compare_details[$comparelist_index]);
        unset($this->compareprice[$comparelist_index]);
        $this->compitems--;

        // Serialize $this->list_details array for error trapping
        $this->compare_details = array_values($this->compare_details);
        for ($i = 0; $i < count($this->compare_details); $i++) $this->compare_details[$i]['list_index'] = $i;

        // Serialize $this->productchecked array for error trapping

        $this->totalizecompare();
    }

    public function remove_item($list_index)
    {
        unset($this->list_details[$list_index]);
        unset($this->productchecked[$list_index]);
        $this->items--;

        // Serialize $this->list_details array for error trapping
        $this->list_details = array_values($this->list_details);
        for ($i = 0; $i < count($this->list_details); $i++) $this->list_details[$i]['list_index'] = $i;

        // Serialize $this->productchecked array for error trapping
        $this->productchecked = array_values($this->productchecked);

        $this->totalize();
    }

    public function confirm()
    {
        $this->to_confirm = true;
    }
}
