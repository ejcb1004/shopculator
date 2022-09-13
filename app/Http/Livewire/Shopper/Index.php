<?php

namespace App\Http\Livewire\Shopper;

use App\Models\ListDetail;
use App\Models\ShoppingList;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use PDF;

class Index extends Component
{
    public $searchterm = '';
    public $selectall = false;
    public $lists;
    public $checkboxticked;

    // boolean
    public $to_confirm_archive;
    public $to_confirm_unarchive;
    public $to_confirm_delete;

    // Livewire lifecycle hooks
    public function mount()
    {
        $this->checkboxticked = [];
        $this->to_confirm_archive = false;
        $this->to_confirm_unarchive = false;
        $this->to_confirm_delete = false;
    }

    public function updatedSelectAll($value)
    {
        $value ? $this->checkboxticked = ShoppingList::pluck('list_id')->toArray() : $this->checkboxticked = [];
    }

    public function render()
    {
        $this->lists = ShoppingList::where('list_name', 'like', '%' . $this->searchterm . '%')
            ->where('is_deleted', 0)
            ->orderBy('updated_at', 'desc')->get();
        return view('livewire.shopper.index');
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
        $pdf = PDF::loadView('livewire.shopper.page', [
            'data' => $data,
            'budget' => $budget,
            'total' => $total,
            'created_at' => $created_at
        ]);

        return $pdf->download($list_name . '.pdf');
    }

    public function confirm_delete()
    {
        $this->to_confirm_delete = true;
    }

    public function inspect_checkboxticked()
    {
        dd($this->checkboxticked[0]);
    }

    public function delete()
    {
        if (count($this->checkboxticked) == 1) {
            ShoppingList::where('list_id', $this->checkboxticked[0])->update([
                'is_deleted' => 1
            ]);
            ListDetail::where('list_id', $this->checkboxticked[0])->update([
                'is_deleted' => 1
            ]);
        } elseif (count($this->checkboxticked) > 1) {
            foreach ($this->checkboxticked as $list_id) {
                ShoppingList::where('list_id', $list_id)->update([
                    'is_deleted' => 1
                ]);
                ListDetail::where('list_id', $list_id)->update([
                    'is_deleted' => 1
                ]);
            }
        }

        session()->flash('flash.banner', 'List successfully deleted!');
        session()->flash('flash.bannerStyle', 'success');
        return redirect('shopper');
    }
}
