<?php

namespace App\Http\Livewire\Admin\Users;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminUserIndex extends Component
{
    public $searchterm = '';
    public $selectall = false;
    public $checkboxticked;

    public $to_confirm;
    public $to_confirm_delete;

    public $market_name;
    public $email;

    public function confirm_delete()
    {
        $this->to_confirm_delete = true;
    }

    public function mount()
    {
        $this->checkboxticked = [];
    }

    public function updatedSelectAll($value)
    {
        $value ? $this->checkboxticked = User::pluck('id')->toArray() : $this->checkboxticked = [];
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R1') abort(403);
        else return view('livewire.admin.users.admin-user-index', [
            'users' => DB::table('users')
                ->join('roles', 'users.role_id', '=', 'roles.role_id')
                ->where('is_deleted', 0)
                ->where('name', 'like', '%' . $this->searchterm . '%')
                ->where('users.role_id', '!=', 'R1')
                ->select('users.id', 'users.role_id', 'roles.role_name', 'users.name', 'users.email', 'users.profile_photo_path', 'users.created_at')
                ->orderBy('users.updated_at', 'desc')
                ->paginate(10)
        ]);
    }

    public function delete()
    {
        if (count($this->checkboxticked) == 1) {
            User::where('id', $this->checkboxticked[0])->update([
                'is_deleted' => 1
            ]);
            session()->flash('flash.banner', 'User successfully deleted!');
            session()->flash('flash.bannerStyle', 'success');
        } elseif (count($this->checkboxticked) > 1) {
            foreach ($this->checkboxticked as $user_id) {
                User::where('id', $user_id)->update([
                    'is_deleted' => 1
                ]);
            }
            session()->flash('flash.banner', 'Users successfully deleted!');
            session()->flash('flash.bannerStyle', 'success');
        }

        return redirect('admin/users');
    }

    public function confirm()
    {
        $this->to_confirm = true;
    }
}
