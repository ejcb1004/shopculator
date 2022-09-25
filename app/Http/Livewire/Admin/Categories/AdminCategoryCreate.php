<?php

namespace App\Http\Livewire\Admin\Categories;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminCategoryCreate extends Component
{
    public $category_name;
    public $email;

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
        $this->to_confirm = false;
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R1') abort(403);
        else return view('livewire.admin.categories.admin-category-create');
    }

    public function store()
    {
        $this->to_confirm = false;
        if (!empty($this->category_name)) {
            $category = Category::create([
                'category_id' => '',
                'category_name' => $this->category_name
            ]);
            $category->category_id = "C" . str_pad($category->id, 6, "0", STR_PAD_LEFT);
            $category->save();
    
            $this->reset('category_name');
    
            session()->flash('flash.banner', 'Category successfully created!');
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
