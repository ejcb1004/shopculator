<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminCategoryEdit extends Component
{
    public $category_id;
    public $category_name;

    public $to_confirm;

    protected $rules = [
        'category_name' => [
            'required',
            'unique:categories,category_name',
            'string',
            'max:255'
        ]
    ];

    public function mount()
    {
        $this->category_name = Category::where('category_id', $this->category_id)->pluck('category_name')->first();
        $this->to_confirm = false;
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R1') abort(403);
        else return view('livewire.admin.categories.admin-category-edit');
    }

    public function store()
    {
        $this->to_confirm = false;
        if (!empty($this->category_name)) {
            Category::where('category_id', $this->category_id)->update([
                'category_name' => $this->category_name
            ]);

            $this->reset('category_name');

            session()->flash('flash.banner', 'Category successfully updated!');
            session()->flash('flash.bannerStyle', 'success');

            return redirect('admin/categories');
        } else {
            session()->flash('flash.banner', 'Incorrect input. Please review your details.');
            session()->flash('flash.bannerStyle', 'danger');

            return redirect('admin/categories/create');
        }
    }

    // user-defined method
    public function confirm()
    {
        $this->to_confirm = true;
    }
}
