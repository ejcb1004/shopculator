<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminIndex extends Component
{
    public $shoppers;
    public $markets;

    public function mount()
    {
        $this->shoppers = [
            'labels' => User::where('role_id', 'R3')
                ->select(DB::raw("DATE_FORMAT(created_at, '%M %d, %Y') as date"))
                ->groupBy('date')
                ->pluck('date')
                ->toArray(),
            'data' => User::where('role_id', 'R3')
                ->select(DB::raw('count(*) as total'))
                ->groupBy(DB::raw("DAY(created_at)"))
                ->pluck('total')
                ->toArray()
        ];
        $this->markets = [
            'labels' => User::where('role_id', 'R2')
                ->select(DB::raw("DATE_FORMAT(created_at, '%M %d, %Y') as date"))
                ->groupBy('date')
                ->pluck('date')
                ->toArray(),
            'data' => User::where('role_id', 'R2')
                ->select(DB::raw('count(*) as total'))
                ->groupBy(DB::raw("DAY(created_at)"))
                ->pluck('total')
                ->toArray()
        ];
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R1') abort(403);
        else return view('livewire.admin.admin-index');
    }
}
