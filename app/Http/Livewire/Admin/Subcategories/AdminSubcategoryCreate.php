<?php

namespace App\Http\Livewire\Admin\Subcategories;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminSubcategoryCreate extends Component
{
    public $subcategories;
    public $subcategory_name;
    public $categories;
    public $category_id;

    public $to_confirm;

    protected $rules = [
        'subcategory_name' => [
            'required',
            'unique:subcategories,subcategory_name',
            'string',
            'max:255'
        ],
        'category_id' => [
            'required',
            'unique:categories',
            'string'
        ]
    ];

    public function mount()
    {
        $this->subcategories = Subcategory::all();
        $this->categories = Category::all();
        $this->to_confirm = false;
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R1') abort(403);
        else return view('livewire.admin.subcategories.admin-subcategory-create');
    }

    public function store()
    {
        $this->to_confirm = false;
        if (!empty($this->subcategory_name)) {
            $subcategory = Subcategory::create([
                'subcategory_id' => '',
                'subcategory_name' => $this->subcategory_name,
                'category_id' => $this->category_id
            ]);
            $subcategory->subcategory_id = "S" . str_pad($subcategory->id, 6, "0", STR_PAD_LEFT);
            $subcategory->save();
    
            $this->reset('subcategory_name', 'category_id');
    
            session()->flash('flash.banner', 'Subcategory successfully created!');
            session()->flash('flash.bannerStyle', 'success');
    
            return redirect('admin/subcategories');
        } else {
            session()->flash('flash.banner', 'Incorrect input. Please review your details.');
            session()->flash('flash.bannerStyle', 'danger');

            return redirect('admin/subcategories/create');
        }
    }

    // user-defined method
    public function confirm()
    {
        $this->to_confirm = true;
    }
}
