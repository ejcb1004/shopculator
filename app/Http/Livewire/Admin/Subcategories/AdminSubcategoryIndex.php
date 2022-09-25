<?php

namespace App\Http\Livewire\Admin\Subcategories;

use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminSubcategoryIndex extends Component
{
    public $searchterm = '';
    public $selectall = false;
    public $checkboxticked;
    
    public function mount()
    {
        $this->checkboxticked = [];
    }

    public function updatedSelectAll($value)
    {
        $value ? $this->checkboxticked = Subcategory::pluck('subcategory_id')->toArray() : $this->checkboxticked = [];
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R1') abort(403);
        else return view('livewire.admin.subcategories.admin-subcategory-index', [
            'subcategories' => DB::table('subcategories')
            ->join('categories', 'subcategories.category_id', 'categories.category_id')
            ->where('subcategories.subcategory_name', 'like', '%' . $this->searchterm . '%')
            ->where('subcategories.is_deleted', 0)
            ->select('subcategories.id', 'subcategories.subcategory_id', 'categories.category_name', 'subcategories.subcategory_name', 'subcategories.updated_at')
            ->orderBy('subcategories.updated_at', 'desc')
            ->paginate(10)
        ]);
    }

    public function confirm_delete()
    {
        $this->to_confirm_delete = true;
    }

    public function delete()
    {
        if (count($this->checkboxticked) == 1) {
            Subcategory::where('subcategory_id', $this->checkboxticked[0])->update([
                'is_deleted' => 1
            ]);
            session()->flash('flash.banner', 'Subcategory successfully deleted!');
            session()->flash('flash.bannerStyle', 'success');
        } elseif (count($this->checkboxticked) > 1) {
            foreach ($this->checkboxticked as $subcategory_id) {
                Subcategory::where('subcategory_id', $subcategory_id)->update([
                    'is_deleted' => 1
                ]);
            }
            session()->flash('flash.banner', 'Categories successfully deleted!');
            session()->flash('flash.bannerStyle', 'success');
        }
        return redirect('admin/subcategories');
    }
}
