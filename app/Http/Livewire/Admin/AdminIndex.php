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

        $total_lists_monthly = [];
        $this->total_lists_monthly = [];
        $this->total_lists_yearly = [];

        foreach ($this->years as $x => $year) {
            $this->total_lists_monthly[$x] = [];
            for ($j = 0; $j < 12; $j++) {
                array_push($this->total_lists_monthly[$x], [
                    'month' => $j + 1,
                    'active_count' => 0,
                    'completed_count' => 0,
                    'month_count' => 0
                ]);
            }

            array_push($this->total_lists_yearly, [
                'year' => $year,
                'active_count' => 0,
                'completed_count' => 0,
                'year_count' => 0
            ]);

            array_push(
                $total_lists_monthly,
                ShoppingList::whereYear('updated_at', $year)
                    ->select(
                        DB::raw('MONTH(updated_at) AS month'),
                        'list_status',
                        DB::raw('COUNT(*) AS month_count')
                    )
                    ->groupBy('month', 'list_status')
                    ->get()
                    ->toArray()
            );

            foreach ($total_lists_monthly[$x] as $value) {
                if ($value['list_status'] == 1) $this->total_lists_monthly[$x][$value['month'] - 1]['active_count'] = $value['month_count'];
                elseif ($value['list_status'] == 2) $this->total_lists_monthly[$x][$value['month'] - 1]['completed_count'] = $value['month_count'];
                $this->total_lists_monthly[$x][$value['month'] - 1]['month_count'] = $this->total_lists_monthly[$x][$value['month'] - 1]['active_count'] + $this->total_lists_monthly[$x][$value['month'] - 1]['completed_count'];
            }
        }

        $total_lists_yearly = ShoppingList::select(
            DB::raw('YEAR(updated_at) AS year'),
            'list_status',
            DB::raw('COUNT(*) AS year_count')
        )
            ->groupBy('year', 'list_status')
            ->orderBy('year', 'desc')
            ->get()
            ->toArray();

        foreach ($total_lists_yearly as $value) {
            if ($value['list_status'] == 1) $this->total_lists_yearly[array_search($value['year'], $this->years)]['active_count'] = $value['year_count'];
            elseif ($value['list_status'] == 2) $this->total_lists_yearly[array_search($value['year'], $this->years)]['completed_count'] = $value['year_count'];
            $this->total_lists_yearly[array_search($value['year'], $this->years)]['year_count'] = $this->total_lists_yearly[array_search($value['year'], $this->years)]['active_count'] + $this->total_lists_yearly[array_search($value['year'], $this->years)]['completed_count'];
        }
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

    public function yearly_list_sum($arr)
    {
        $list_sum = 0;
        foreach ($arr as $item) {
            $list_sum += $item['year_count'];
        }
        return $list_sum;
    }

    public function active_list_sum($arr)
    {
        $list_sum = 0;
        foreach ($arr as $item) {
            $list_sum += $item['active_count'];
        }
        return $list_sum;
    }

    public function completed_list_sum($arr)
    {
        $list_sum = 0;
        foreach ($arr as $item) {
            $list_sum += $item['completed_count'];
        }
        return $list_sum;
    }
}
