<?php

namespace App\Http\Livewire\Admin\Subcategories;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class AdminSubcategoryEdit extends Component
{
    public $subcategory_id;
    public $subcategory_name;
    public $subcategories;
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
        $this->subcategories = Subcategory::where('subcategory_id', $this->subcategory_id)->select('subcategory_name', 'category_id')->get();
        foreach ($this->subcategories as $subcategory) {
            $this->subcategory_name = $subcategory->subcategory_name;
            $this->category_id = $subcategory->category_id;
        }
        $this->categories = Category::all();
        $this->to_confirm = false;
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R1') abort(403);
        else return view('livewire.admin.subcategories.admin-subcategory-edit');
    }

    public function store()
    {
        $this->to_confirm = false;
        if (!empty($this->subcategory_name)) {
            Subcategory::where('subcategory_id', $this->subcategory_id)->update([
                'subcategory_name' => $this->subcategory_name,
                'category_id' => $this->category_id
            ]);

            $this->reset('subcategory_name');

            session()->flash('flash.banner', 'Subcategory successfully updated!');
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
