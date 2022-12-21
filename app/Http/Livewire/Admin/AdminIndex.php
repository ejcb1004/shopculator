<?php

namespace App\Http\Livewire\Admin;

use App\Models\ShoppingList;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class AdminIndex extends Component
{
    public $shoppers;
    public $markets;
    public $lists;
    public $years;
    public $list_statuses;
    public $total_lists_monthly;

    public function mount()
    {
        $this->years = ShoppingList::select(DB::raw('YEAR(updated_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')->toArray();

        $this->shoppers = User::where('role_id', 'R3')->count();
        $this->markets = User::where('role_id', 'R2')->count();
        $this->lists = [
            'total' => ShoppingList::count(),
            'monthly' => ShoppingList::selectRaw('COUNT(*) as count, YEAR(updated_at) as year')
                ->whereMonth('updated_at', DB::raw('MONTH(NOW())'))
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->get()->toArray(),
            'yearly' => ShoppingList::selectRaw('COUNT(*) as count, YEAR(updated_at) as year')
                ->groupBy('year')
                ->orderBy('year', 'desc')
                ->get()->toArray()
        ];

        $this->list_statuses = ['Active', 'Completed'];
        $this->total_lists_monthly = [];

        foreach ($this->years as $year) {
            array_push(
                $this->total_lists_monthly,
                ShoppingList::whereYear('updated_at', $year)
                    ->select(
                        DB::raw('MONTH(updated_at) AS month'), 
                        'list_status',
                        DB::raw('COUNT(*) AS month_count'))
                    ->groupBy('month', 'list_status')
                    ->get()
                    ->toArray()
            );
        }

        $this->total_lists_yearly = ShoppingList::select(
            DB::raw('YEAR(updated_at) AS year'),
            'list_status',
            DB::raw('COUNT(*) AS year_count')
        )
            ->groupBy('year', 'list_status')
            ->orderBy('year', 'desc')
            ->get()
            ->toArray();
    }

    public function render()
    {
        //dd($this->total_lists_yearly);
        if (Auth::user()->role_id != 'R1') abort(403);
        else return view('livewire.admin.admin-index');
    }

    public function monthly_list_sum($arr)
    {
        $list_sum = 0;
        foreach ($arr as $item) {
            $list_sum += $item['month_count'];
        }
        return $list_sum;
    }

    public function monthly_active_list_sum($arr)
    {
        $list_sum = 0;
        foreach ($arr as $item) {
            if ($item['list_status'] == 1)
                $list_sum += $item['month_count'];
        }
        return $list_sum;
    }

    public function monthly_completed_list_sum($arr)
    {
        $list_sum = 0;
        foreach ($arr as $item) {
            if ($item['list_status'] == 2)
                $list_sum += $item['month_count'];
        }
        return $list_sum;
    }

    public function yearly_list_sum($arr)
    {
        $list_sum = 0;
        foreach ($arr as $item) {
            $list_sum += $item['year_count'];
        }
        return $list_sum;
    }

    public function yearly_active_list_sum($arr)
    {
        $list_sum = 0;
        foreach ($arr as $item) {
            if ($item['list_status'] == 1)
                $list_sum += $item['year_count'];
        }
        return $list_sum;
    }

    public function yearly_completed_list_sum($arr)
    {
        $list_sum = 0;
        foreach ($arr as $item) {
            if ($item['list_status'] == 2)
                $list_sum += $item['year_count'];
        }
        return $list_sum;
    }
}
