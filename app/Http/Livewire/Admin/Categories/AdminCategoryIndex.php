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
    
    public function mount()
    {
        $this->checkboxticked = [];
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
}
