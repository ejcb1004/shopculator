<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AdminUserCreate extends Component
{
    public $name;
    public $email;
    public $roles;
    public $password;
    public $confirm_password;
    public $role_id;

    public $to_confirm;
    public $to_confirm_delete;

    protected $rules = [
        'name' => [
            'required',
            'unique:users,name',
            'string',
            'max:255'
        ],
        'email' => [
            'required',
            'string',
            'email',
            'max:255',
            'unique:users,email'
        ],
        'password' => [
            'required',
            'string',
            'min:8',
            'confirmed'
        ],
        'confirm_password' => [
            'required',
            'string',
            'min:8',
            'confirmed'
        ],
        'role_id' => [
            'required',
            'string',
            'max:2'
        ]
    ];

    public function mount()
    {
        $this->roles = Role::where('role_id', '!=', 'R1')->get();
        $this->role_id = 'R2';
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R1') abort(403);
        else return view('livewire.admin.users.admin-user-create');
    }

    public function store()
    {
        $this->to_confirm = false;
        if ($this->password === $this->confirm_password) {
            try {
                User::create([
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'role_id' => $this->role_id
                ]);
                session()->flash('flash.banner', 'User successfully created!');
                session()->flash('flash.bannerStyle', 'success');

                return redirect('admin/users');
            } catch (QueryException $qe) {
                session()->flash('flash.banner', 'These credentials are already taken. Please review your details.');
                session()->flash('flash.bannerStyle', 'danger');

                return redirect('admin/users/create');
            }
        } else {
            session()->flash('flash.banner', 'Incorrect input. Please review your details.');
            session()->flash('flash.bannerStyle', 'danger');

            return redirect('admin/users/create');
        }
    }

    // user-defined functions
    public function confirm()
    {
        $this->to_confirm = true;
    }

    public function delete()
    {
        $this->to_confirm_delete = true;
    }
}
