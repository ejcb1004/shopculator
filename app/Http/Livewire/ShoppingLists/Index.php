<?php

namespace App\Http\Livewire\ShoppingLists;

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
    public $list_id;

    // boolean
    public $to_confirm_archive;
    public $to_confirm_unarchive;
    public $to_confirm_delete;

    public function check_listid()
    {
        dd($this->checkboxticked);
    }

    public function updatedSelectAll($value)
    {
        $value ? $this->checkboxticked = ShoppingList::pluck('list_id')->toArray() : $this->checkboxticked = [];
    }

    public function mount()
    {
        $this->checkboxticked = [];
        $this->to_confirm_archive = false;
        $this->to_confirm_unarchive = false;
        $this->to_confirm_delete = false;
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
        $pdf = PDF::loadView('pages.list', ['data' => $data]);

        return $pdf->download($list_name . '.pdf');
    }

    public function confirm_archive()
    {
        $this->to_confirm_archive = true;
    }

    public function confirm_unarchive()
    {
        $this->to_confirm_unarchive = true;
    }

    public function confirm_delete()
    {
        $this->to_confirm_delete = true;
    }

    public function archive()
    {

    }

    public function unarchive()
    {

    }

    public function delete()
    {
        $list = ShoppingList::where('list_id', $this->list_id)->get();
        $list->is_deleted = 1;
        $list->save();
        session()->flash('flash.banner', 'List successfully deleted!');
        session()->flash('flash.bannerStyle', 'success');
        return redirect('shopping-lists');
    }

    public function render()
    {
        $this->lists = ShoppingList::where('list_name', 'like', '%' . $this->searchterm . '%')->get();
        return view('livewire.shopping-lists.index');
    }
}
