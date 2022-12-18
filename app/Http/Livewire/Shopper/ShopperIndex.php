<?php

namespace App\Http\Livewire\Shopper;

use App\Models\ListDetail;
use App\Models\Product;
use App\Models\ShoppingList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use PDF;

class ShopperIndex extends Component
{
    use WithPagination;

    // int
    public $list_status;

    public $searchterm = '';
    public $selectall = false;
    public $checkboxticked;
    public $list_count;
    public $active_list_count;
    public $completed_list_count;
    public $spendings;

    // boolean
    public $to_confirm;
    public $to_confirm_delete;

    // public $list_details;
    public $db_trending;
    public $top_trending;

    // Livewire lifecycle hooks
    public function mount()
    {
        $this->checkboxticked = [];
        $this->to_confirm_delete = false;
        $this->to_confirm = false;
        $this->list_details = ListDetail::pluck('product_id')->toArray();

        $this->db_trending = DB::table('list_details')
            ->join('products', 'list_details.product_id', '=', 'products.product_id')
            ->join('shopping_lists', 'list_details.list_id', '=', 'shopping_lists.list_id')
            ->select('products.product_name', 'products.image_path', DB::raw('COUNT(*) as count'))
            ->where('shopping_lists.email', Auth::user()->email)
            ->limit(5)
            ->groupBy('products.product_name', 'products.image_path')
            ->orderBy('count', 'desc')
            ->get()
            ->toArray();
        $this->top_trending = [];
        foreach ($this->db_trending as $trend) {
            array_push($this->top_trending, get_object_vars($trend));
        }

        $this->list_count = count(ShoppingList::where('email', Auth::user()->email)
            ->where('list_status', 1)
            ->orWhere('list_status', 2)
            ->where('email', Auth::user()->email)
            ->pluck('list_id')->toArray());

        $this->active_list_count = [
            'total' => count(ShoppingList::where('email', Auth::user()->email)
                ->where('list_status', 1)
                ->pluck('list_id')->toArray()),
            'this_month' => count(ShoppingList::where('email', Auth::user()->email)
                ->where('list_status', 1)
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->pluck('list_id')->toArray())
        ];

        $this->completed_list_count = [
            'total' => count(ShoppingList::where('email', Auth::user()->email)
                ->where('list_status', 2)
                ->pluck('list_id')->toArray()),
            'this_month' => count(ShoppingList::where('email', Auth::user()->email)
                ->where('list_status', 2)
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->pluck('list_id')->toArray())
        ];

        $this->spendings = [
            'total' => ShoppingList::where('email', Auth::user()->email)
                ->where('list_status', 2)
                ->sum('total'),
            'this_month' => ShoppingList::where('email', Auth::user()->email)
                ->where('list_status', 2)
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month)
                ->sum('total'),
            'last_month' => ShoppingList::where('email', Auth::user()->email)
                ->where('list_status', 2)
                ->whereYear('created_at', now()->year)
                ->whereMonth('created_at', now()->month - 1)
                ->sum('total')
        ];
    }

    public function updatedSelectAll($value)
    {
        $value ? $this->checkboxticked = ShoppingList::where('email', Auth::user()->email)
            ->where('list_status', 1)
            ->pluck('list_id')->toArray() : $this->checkboxticked = [];
    }

    public function render()
    {
        // dd($this->list_count);
        if (Auth::user()->role_id != 'R3') abort(403);
        else return view('livewire.shopper.shopper-index', [
            'lists' => ShoppingList::where('list_name', 'like', '%' . $this->searchterm . '%')
                ->where('email', Auth::user()->email)
                ->where('list_status', 1)
                ->orWhere('list_status', 2)
                ->where('email', Auth::user()->email)
                ->orderBy('updated_at', 'desc')
                ->paginate(10)
        ]);
    }

    // methods
    public function list_is_completed()
    {
        switch (count($this->checkboxticked)) {
            case 1:
                if (ShoppingList::where('list_id', $this->checkboxticked[0])->pluck('list_status')->first() == 2) return true;
                break;
            default:
                $completed = false;
                foreach ($this->checkboxticked as $list_id) {
                    if (ShoppingList::where('list_id', $list_id)->pluck('list_status')->first() == 2) {
                        $completed = true;
                        break;
                    }
                }
                return $completed;
        }
    }

    public function generatepdf($list_id)
    {
        $list_name = ShoppingList::where('list_id', $list_id)->pluck('list_name')[0];
        $data = DB::table('list_details')
            ->join('products', 'list_details.product_id', '=', 'products.product_id')
            ->select('list_details.*', 'products.product_name', 'products.price')
            ->where('list_details.list_id', $list_id)
            ->where('list_details.is_deleted', 0)
            ->orderBy('list_index')
            ->get();
        $budget = ShoppingList::where('list_id', $list_id)->pluck('budget')[0];
        $total = ShoppingList::where('list_id', $list_id)->pluck('total')[0];
        $created_at = ShoppingList::where('list_id', $list_id)->pluck('created_at')[0];
        return $pdf = PDF::loadView('livewire.shopper.page', [
            'list_name' => $list_name,
            'list_id' => $list_id,
            'data' => $data,
            'budget' => $budget,
            'total' => $total,
            'created_at' => $created_at
        ])->setOptions(['defaultFont' => 'Nunito'])->setPaper('letter', 'portrait')->stream();
    }

    public function confirm_delete()
    {
        $this->to_confirm_delete = true;
    }

    public function confirm($list_status)
    {
        $this->list_status = $list_status;
        $this->to_confirm = true;
    }

    // public function register_prices()
    // {
    //     for ($i = 1650; $i < count($this->list_details); $i++) {
    //         ListDetail::where('product_id', $this->list_details[$i])->update([
    //             'current_price' => Product::where('product_id', $this->list_details[$i])->pluck('price')[0]
    //         ]);
    //     }
    //     session()->flash('flash.banner', 'Prices successfully registered!');
    //     session()->flash('flash.bannerStyle', 'success');
    //     return redirect('shopper');
    // }

    public function mark_complete()
    {
        switch (count($this->checkboxticked)) {
            case 1:
                ShoppingList::where('list_id', $this->checkboxticked[0])->update([
                    'list_status' => 2
                ]);
                session()->flash('flash.banner', 'List successfully marked complete!');
                session()->flash('flash.bannerStyle', 'success');
                break;
            default:
                foreach ($this->checkboxticked as $list_id) {
                    ShoppingList::where('list_id', $list_id)->update([
                        'list_status' => 2
                    ]);
                }
                session()->flash('flash.banner', 'Lists successfully marked complete!');
                session()->flash('flash.bannerStyle', 'success');
        }
        return redirect('shopper');
    }

    public function delete()
    {
        if (count($this->checkboxticked) == 1) {
            ShoppingList::where('list_id', $this->checkboxticked[0])->update([
                'list_status' => 0
            ]);
            ListDetail::where('list_id', $this->checkboxticked[0])->update([
                'is_deleted' => 1
            ]);
            session()->flash('flash.banner', 'List successfully deleted!');
            session()->flash('flash.bannerStyle', 'success');
        } elseif (count($this->checkboxticked) > 1) {
            foreach ($this->checkboxticked as $list_id) {
                ShoppingList::where('list_id', $list_id)->update([
                    'list_status' => 0
                ]);
                ListDetail::where('list_id', $list_id)->update([
                    'is_deleted' => 1
                ]);
            }
            session()->flash('flash.banner', 'Lists successfully deleted!');
            session()->flash('flash.bannerStyle', 'success');
        }
        return redirect('shopper');
    }
}
