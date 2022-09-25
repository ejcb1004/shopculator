<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class AdminUserEdit extends Component
{
    public $user_id;
    public $name;
    public $email;
    public $roles;
    public $password;
    public $confirm_password;
    public $role_id;

    public $to_confirm;

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
            'unique:users'
        ],
        'password' => [
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

    public function mount($user_id)
    {
        $user = User::where('id', $user_id)->get();
        foreach ($user as $data) {
            $this->name = $data->name;
            $this->email = $data->email;
            $this->role_id = $data->role_id;
        }
        $this->roles = Role::where('role_id', '!=', 'R1')->get();
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R1') abort(403);
        else return view('livewire.admin.users.admin-user-edit');
    }

    public function store()
    {
        $this->to_confirm = false;
        if ($this->password === $this->confirm_password) {
            User::where('id', $this->user_id)->update([
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role_id' => $this->role_id
            ]);

            session()->flash('flash.banner', 'User successfully updated!');
            session()->flash('flash.bannerStyle', 'success');

            return redirect('admin/users');
        } else {
            session()->flash('flash.banner', 'Incorrect input. Please review your details.');
            session()->flash('flash.bannerStyle', 'danger');

            return redirect('admin/users/edit/' . $this->user_id);
        }
    }

    // user-defined functions
    public function confirm()
    {
        $this->to_confirm = true;
    }
}
