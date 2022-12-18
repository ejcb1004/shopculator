<?php

namespace App\Http\Livewire\Shopper;

use App\Models\ListDetail;
use App\Models\ShoppingList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class ShopperView extends Component
{
    public $list;
    public $list_id;
    public $db_details;
    public $list_details;
    public $productchecked;

    public function mount()
    {
        $this->list_details = [];
        $this->productchecked = ListDetail::where('list_id', $this->list_id)
            ->where('is_checked', 1)
            ->where('is_deleted', 0)
            ->pluck('product_id')->toArray();

        $this->db_details = DB::table('list_details')
            ->join('products', 'list_details.product_id', '=', 'products.product_id')
            ->select(
                'list_details.id',
                'list_details.list_index',
                'list_details.is_checked',
                'products.image_path',
                'products.product_id',
                'products.product_name',
                'list_details.current_price',
                'list_details.quantity',
                'list_details.is_deleted',
                'list_details.updated_at'
            )
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

        $this->list = ShoppingList::where('list_id', $this->list_id)->select('list_name', 'budget', 'total', 'list_status', 'created_at', 'updated_at')->get()[0];
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R3' || 
        Auth::user()->email != ShoppingList::where('list_id', $this->list_id)->pluck('email')->first() || 
        ShoppingList::where('list_id', $this->list_id)->pluck('list_status')->first() == 0) abort(403);
        else return view('livewire.shopper.shopper-view');
    }
}
