<?php

namespace App\Http\Livewire\ShoppingLists;

use App\Models\Category;
use App\Models\ListDetail;
use App\Models\Market;
use App\Models\Product;
use App\Models\ShoppingList;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Edit extends Component
{
    use WithPagination;
    protected $listeners = ['product_add' => 'product_add'];

    // int
    public $budget, $total, $items = 0;

    // string
    public $prefix;
    public $list_name;
    public $list_id;

    // boolean
    public $to_confirm;

    // array
    public $db_details = [];
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

        $this->db_details = DB::table('list_details')
            ->join('products', 'list_details.product_id', '=', 'products.product_id')
            ->select('list_details.*', 'products.product_name', 'products.price')
            ->where('list_details.list_id', $this->list_id)
            //->where('list_details.is_deleted', 0)
            ->orderBy('list_index')
            ->get()
            ->toArray();

        foreach ($this->db_details as $db_detail) {
            if (get_object_vars($db_detail)['is_deleted'] == 0)
            array_push($this->list_details, get_object_vars($db_detail));
        }
        $this->list_details = array_values($this->list_details);
        for ($i = 0; $i < count($this->list_details); $i++) $this->list_details[$i]['list_index'] = $i;

        $this->productchecked = ListDetail::where('list_id', $this->list_id)->where('is_checked', 1)->pluck('product_id')->toArray();
        $this->list_name = ShoppingList::where('list_id', $this->list_id)->pluck('list_name')[0];
        $this->budget = ShoppingList::where('list_id', $this->list_id)->pluck('budget')[0];
        $this->items = count($this->list_details);
        $this->total = ShoppingList::where('list_id', $this->list_id)->pluck('total')[0];
        $this->prefix = 'http://127.0.0.1:3000';
    }

    public function render()
    {
        return view('livewire.shopping-lists.edit', [
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
            ShoppingList::where('list_id', $this->list_id)->update([
                'list_name' => $this->list_name,
                'budget'    => $this->budget,
                'total'     => $this->total
            ]);

            foreach ($this->list_details as $detail) {
                if (ListDetail::select('product_id')
                    ->where('product_id', $detail['product_id'])
                    ->where('list_id', $this->list_id)
                    ->exists()
                ) {
                    ListDetail::where('detail_id', $detail['detail_id'])->update([
                        'is_checked' => (in_array($detail['product_id'], $this->productchecked)) ? 1 : 0,
                        'list_index' => $detail['list_index'],
                        'product_id' => $detail['product_id'],
                        'image_path' => $detail['image_path'],
                        'is_deleted' => $detail['is_deleted'],
                        'quantity' => $detail['quantity']
                    ]);
                } else {
                    $list_detail = ListDetail::create([
                        'is_checked' => (in_array($detail['product_id'], $this->productchecked)) ? 1 : 0,
                        'list_index' => $detail['list_index'],
                        'detail_id' => '',
                        'list_id' => $this->list_id,
                        'product_id' => $detail['product_id'],
                        'image_path' => $detail['image_path'],
                        'is_deleted' => $detail['is_deleted'],
                        'quantity' => $detail['quantity']
                    ]);
                    $list_detail->detail_id = "D" . str_pad($list_detail->id, 12, "0", STR_PAD_LEFT);
                    $list_detail->save();
                }
            }

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

            session()->flash('flash.banner', 'List successfully updated!');
            session()->flash('flash.bannerStyle', 'success');

            return redirect('shopping-lists');
        } else {
            session()->flash('flash.banner', 'Looks like you don\'t have enough budget. You can either increase budget or reduce the total cost.');
            session()->flash('flash.bannerStyle', 'danger');

            return redirect('shopping-lists/create');
        }
    }

    // user-defined methods
    public function inspect_dbd()
    {
        dd($this->db_details);
    }

    public function inspect_ld()
    {
        dd($this->list_details);
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

    public function product_add($id)
    {
        // Retrieve record based on id
        $this->new_detail = Product::where('id', $id)->get()->toArray()[0];

        // if(in_array($this->new_detail['product_id'], array_column($this->db_details, 'product_id'))) {
            
        // }
        
        // if product_id of $new_detail matches an existing record in $list_details array
        $index = array_search($this->new_detail['product_id'], array_column($this->list_details, 'product_id'));

        if (!empty($this->new_detail) && !empty($this->list_details)) {
            if (in_array($this->new_detail['product_id'], $this->list_details[$index])) {
                $this->list_details[$index]['quantity']++;
                $this->totalize();
            } else $this->populate();
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
