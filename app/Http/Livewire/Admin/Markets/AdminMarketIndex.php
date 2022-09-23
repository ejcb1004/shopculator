<?php

namespace App\Http\Livewire\Admin\Markets;

use App\Models\Market;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminMarketIndex extends Component
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
        $value ? $this->checkboxticked = Market::pluck('market_id')->toArray() : $this->checkboxticked = [];
    }

    public function render()
    {
        if (Auth::user()->role_id != 'R1') abort(403);
        else return view('livewire.admin.markets.admin-market-index', [
            'markets' => DB::table('markets')
            ->join('users', 'markets.email', '=', 'users.email')
            ->where('markets.market_name', 'like', '%' . $this->searchterm . '%')
            ->where('markets.is_deleted', 0)
            ->select('markets.id', 'markets.market_id', 'markets.market_name', 'markets.email', 'markets.updated_at', 'users.profile_photo_path')
            ->orderBy('markets.updated_at', 'desc')
            ->paginate(10)
        ]);
    }
}
