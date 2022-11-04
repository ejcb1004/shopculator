<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminCategoryIndex extends Component
{
    public $searchterm = '';
    public $selectall = false;
    public $checkboxticked;

    public $to_confirm_delete;
    
    public function mount()
    {
        $this->checkboxticked = [];
        $this->to_confirm_delete = false;
    }

    public function updatedSelectAll($value)
    {
        $value ? $this->checkboxticked = Category::pluck('category_id')->toArray() : $this->checkboxticked = [];
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R1') abort(403);
        else return view('livewire.admin.categories.admin-category-index', [
            'categories' => Category::where('is_deleted', 0)
            ->where('category_name', 'like', '%' . $this->searchterm . '%')
            ->select('id', 'category_id', 'category_name', 'updated_at')
            ->orderBy('updated_at', 'desc')
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
            Category::where('category_id', $this->checkboxticked[0])->update([
                'is_deleted' => 1
            ]);
            session()->flash('flash.banner', 'Category successfully deleted!');
            session()->flash('flash.bannerStyle', 'success');
        } elseif (count($this->checkboxticked) > 1) {
            foreach ($this->checkboxticked as $category_id) {
                Category::where('category_id', $category_id)->update([
                    'is_deleted' => 1
                ]);
            }
            session()->flash('flash.banner', 'Categories successfully deleted!');
            session()->flash('flash.bannerStyle', 'success');
        }
        return redirect('admin/categories');
    }
}
