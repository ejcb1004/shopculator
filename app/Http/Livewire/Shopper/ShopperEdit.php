<?php

namespace App\Http\Livewire\Shopper;

use App\Models\Category;
use App\Models\ListDetail;
use App\Models\Market;
use App\Models\Product;
use App\Models\ShoppingList;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ShopperEdit extends Component
{
    use WithPagination;

    // int
    public $budget, $total, $items, $compitems;

    // string
    public $list_name;
    public $list_id;
    public $image;

    // boolean
    public $to_confirm;
    public $product_added;
    public $comp_added;

    // array
    public $db_details = [];
    public $list_details = [];
    public $newcompare_detail = [];
    public $new_detail = [];
    public $productchecked = [];
    public $compare_details = [];
    public $compareprice = [];
    public $complow = [];

    // collections
    public $markets;
    public $categories;

    // search filters
    public $selectedmarket = null;
    public $selectedsubcategory = null;
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
        $this->subcategories = Subcategory::all();

        $this->db_details = DB::table('list_details')
            ->join('products', 'list_details.product_id', '=', 'products.product_id')
            ->select('list_details.*', 'products.product_name', 'products.price', 'products.image_path')
            ->where('list_details.list_id', $this->list_id)
            ->orderBy('list_index')
            ->get()
            ->toArray();

        foreach ($this->db_details as $db_detail) {
            if (get_object_vars($db_detail)['is_deleted'] == 0)
                array_push($this->list_details, get_object_vars($db_detail));
        }
        $this->list_details = array_values($this->list_details);
        for ($i = 0; $i < count($this->list_details); $i++) $this->list_details[$i]['list_index'] = $i;

        $this->compare_details = [];
        $this->productchecked = ListDetail::where('list_id', $this->list_id)
            ->where('is_checked', 1)
            ->where('is_deleted', 0)
            ->pluck('product_id')->toArray();
        $this->compareprice = [];
        $this->list_name = ShoppingList::where('list_id', $this->list_id)->pluck('list_name')[0];
        $this->budget = ShoppingList::where('list_id', $this->list_id)->pluck('budget')[0];
        $this->items = count($this->list_details);
        $this->total = ShoppingList::where('list_id', $this->list_id)->pluck('total')[0];
        $this->compitems = 0;
        $this->complow = [];
        $this->product_added = false;
        $this->comp_added = false;
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R3' || Auth::user()->email != ShoppingList::where('list_id', $this->list_id)->pluck('email')->first()) abort(403);
        else return view('livewire.shopper.shopper-edit', [
            'products' => Product::with(['market', 'subcategory'])
                ->when($this->selectedmarket, function ($query) {
                    $query->where('market_id', $this->selectedmarket);
                })
                ->when($this->selectedsubcategory, function ($query) {
                    $query->where('subcategory_id', $this->selectedsubcategory);
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
                if (
                    ListDetail::select('product_id')
                    ->where('product_id', $detail['product_id'])
                    ->where('list_id', $this->list_id)
                    ->exists()
                ) {
                    ListDetail::where('detail_id', $detail['detail_id'])->update([
                        'is_checked' => (in_array($detail['product_id'], $this->productchecked)) ? 1 : 0,
                        'list_index' => $detail['list_index'],
                        'product_id' => $detail['product_id'],
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
                        'is_deleted' => $detail['is_deleted'],
                        'quantity' => $detail['quantity']
                    ]);
                    $list_detail->detail_id = "D" . str_pad($list_detail->id, 12, "0", STR_PAD_LEFT);
                    $list_detail->save();
                }
            }

            // for items that have had related history in the database
            foreach (array_diff(
                array_column($this->db_details, 'product_id'),
                array_column($this->list_details, 'product_id')
            ) as $difference) {
                ListDetail::where('list_id', $this->list_id)
                    ->where('product_id', $difference)
                    ->update([
                        'is_deleted' => 1
                    ]);
            }

            $this->reset(
                'list_details',
                'list_name',
                'budget',
                'total',
                'items',
                'productchecked',
                'selectedmarket',
                'selectedsubcategory'
            );

            session()->flash('flash.banner', 'List successfully updated!');
            session()->flash('flash.bannerStyle', 'success');

            return redirect('shopper');
        } else {
            session()->flash('flash.banner', 'Looks like you don\'t have enough budget. You can either increase budget or reduce the total cost.');
            session()->flash('flash.bannerStyle', 'danger');

            return redirect('shopper/create');
        }
    }

    // user-defined methods
    public function logo($market_id)
    {
        $this->image = DB::table('users')
            ->join('markets', 'users.email', '=', 'markets.email')
            ->join('products', 'markets.market_id', '=', 'products.market_id')
            ->where('markets.market_id', $market_id)
            ->pluck('users.profile_photo_path');
        return $this->image[0];
    }

    public function get_product_id($product_id)
    {
        if (in_array($product_id, array_column($this->list_details, 'product_id')))
            return $product_id;
    }

    public function get_product_comp_id($product_id)
    {
        if (in_array($product_id, array_column($this->compare_details, 'product_id')))
            return $product_id;
    }

    public function get_product_name($product_id)
    {
        $product_name = Product::where('product_id', $product_id)->pluck('product_name')->first();
        return $product_name;
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

    public function populate_multi($quantity)
    {
        // Populate array with list details
        $this->list_details[] = [
            'is_checked'    => 0,
            'list_index'    => empty($this->list_details) ? 0 : array_key_last($this->list_details) + 1,
            'product_id'    => $this->new_detail['product_id'],
            'image_path'    => $this->new_detail['image_path'],
            'quantity'      => $quantity,
            'is_deleted'    => 0,
            'product_name'  => $this->new_detail['product_name'],
            'price'         => $this->new_detail['price'],
        ];
        $this->items++;
    }

    public function product_add($id)
    {
        $this->product_added = false;
        $this->comp_added = false;

        // Retrieve record based on id
        $this->new_detail = Product::where('id', $id)->get()->toArray()[0];

        if (in_array($this->new_detail['product_id'], array_column($this->db_details, 'product_id'))) {
            $past_detail = ListDetail::where('product_id', $this->new_detail['product_id'])
                ->where('list_id', $this->list_id)->get()->toArray()[0];
            $past_detail['is_deleted'] = 0;
            $past_detail['quantity'] = 1;
            $past_detail['is_checked'] = 0;
            $pieces = Product::select('product_name', 'price')->where('product_id', $this->new_detail['product_id'])->get()->toArray()[0];
            $past_detail['product_name'] = $pieces['product_name'];
            $past_detail['price'] = $pieces['price'];
            array_push($this->list_details, $past_detail);
            $this->items++;
            $this->serialize_list();
        } else {
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

        $this->product_added = true;
    }

    public function complow_add()
    {
        $this->product_added = false;
        $this->comp_added = false;

        // Retrieve record based on id
        $this->new_detail = Product::where('product_id', $this->complow['product_id'])->get()->first()->toArray();

        // if product_id of $new_detail matches an existing record in $list_details array
        $list_index = array_search($this->new_detail['product_id'], array_column($this->list_details, 'product_id'));
        if (!empty($this->new_detail) && !empty($this->list_details)) {
            if (in_array($this->new_detail['product_id'], $this->list_details[$list_index])) {
                $this->list_details[$list_index]['quantity'] = $this->complow['quantity'];
                $this->totalize();
            } else $this->populate_multi($this->complow['quantity']);
        } else {
            $this->populate_multi($this->complow['quantity']);
        }
        $this->list_details[$list_index]['quantity'] = $this->complow['quantity'];
        $this->product_added = true;
    }

    public function compare_add($id)
    {
        $this->product_added = false;
        $this->comp_added = false;

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

        $this->comp_added = true;
    }

    public function add_compprod($list_index)
    {
        $this->product_added = false;
        $this->comp_added = false;

        // Retrieve record based on id
        $this->new_detail = Product::where('product_id', $this->compare_details[$list_index]['product_id'])->get()->toArray()[0];

        if (in_array($this->new_detail['product_id'], array_column($this->db_details, 'product_id'))) {
            $past_detail = ListDetail::where('product_id', $this->new_detail['product_id'])
                ->where('list_id', $this->list_id)->get()->toArray()[0];
            $past_detail['is_deleted'] = 0;
            $past_detail['quantity'] = 1;
            $past_detail['is_checked'] = 0;
            $pieces = Product::select('product_name', 'price')->where('product_id', $this->new_detail['product_id'])->get()->toArray()[0];
            $past_detail['product_name'] = $pieces['product_name'];
            $past_detail['price'] = $pieces['price'];
            array_push($this->list_details, $past_detail);
            $this->items++;
            $this->serialize_list();
        } else {
            // if product_id of $new_detail matches an existing record in $list_details array
            $comprod_list_index = array_search($this->new_detail['product_id'], array_column($this->list_details, 'product_id'));
            if (!empty($this->new_detail) && !empty($this->list_details)) {
                if (in_array($this->new_detail['product_id'], $this->list_details[$comprod_list_index])) {
                    $this->list_details[$comprod_list_index]['quantity'] = $this->compare_details[$list_index]['quantity'];
                    $this->totalize();
                } else $this->populate_multi($this->compare_details[$list_index]['quantity']);
            } else {
                $this->populate_multi($this->compare_details[$list_index]['quantity']);
            }
            $this->list_details[$list_index]['quantity'] = $this->compare_details[$list_index]['quantity'];
        }

        $this->product_added = true;
    }

    public function logo_from_product($product_id)
    {
        $this->image = DB::table('users')
            ->join('markets', 'users.email', '=', 'markets.email')
            ->join('products', 'markets.market_id', '=', 'products.market_id')
            ->where('products.product_id', $product_id)
            ->pluck('users.profile_photo_path');
        return $this->image[0];
    }

    public function totalizecompare()
    {
        $this->product_added = false;
        $this->comp_added = false;
    }

    public function totalize()
    {
        $this->product_added = false;
        $this->comp_added = false;
        $this->total = 0;
        foreach ($this->list_details as $detail) {
            if (in_array($detail['product_id'], $this->productchecked)) {
                $this->total += ($detail['price'] * $detail['quantity']);
            }
        }
    }

    public function getlow()
    {
        if (!empty($this->compare_details)) {
            $this->compareprice = [];
            foreach ($this->compare_details as $item)
                array_push($this->compareprice, $item['price'] * $item['quantity']);
            $this->complow = $this->compare_details[array_keys($this->compareprice, min($this->compareprice))[0]];
        }
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
        $this->serialize_list();

        // Serialize $this->productchecked array for error trapping
        $this->productchecked = array_values($this->productchecked);

        $this->totalize();
    }

    public function confirm()
    {
        $this->to_confirm = true;
    }

    public function serialize_list()
    {
        $this->list_details = array_values($this->list_details);
        for ($i = 0; $i < count($this->list_details); $i++) $this->list_details[$i]['list_index'] = $i;
    }
}
