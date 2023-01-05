<?php

namespace App\Http\Livewire\Admin;

use App\Models\ShoppingList;
use App\Models\User;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use PDF;

class AdminIndex extends Component
{
    public $shoppers;
    public $markets;
    public $lists;
    public $years;
    public $total_lists_monthly;
    public $total_lists_yearly;
    public $chart_config;

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
                    'expired_count' => 0,
                    'month_count' => 0
                ]);
            }

            array_push($this->total_lists_yearly, [
                'year' => $year,
                'active_count' => 0,
                'completed_count' => 0,
                'expired_count' => 0,
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
                elseif ($value['list_status'] == 3) $this->total_lists_monthly[$x][$value['month'] - 1]['expired_count'] = $value['month_count'];
                $this->total_lists_monthly[$x][$value['month'] - 1]['month_count'] = $this->total_lists_monthly[$x][$value['month'] - 1]['active_count'] + $this->total_lists_monthly[$x][$value['month'] - 1]['completed_count'] + $this->total_lists_monthly[$x][$value['month'] - 1]['expired_count'];
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
            elseif ($value['list_status'] == 3) $this->total_lists_yearly[array_search($value['year'], $this->years)]['expired_count'] = $value['year_count'];
            $this->total_lists_yearly[array_search($value['year'], $this->years)]['year_count'] = $this->total_lists_yearly[array_search($value['year'], $this->years)]['active_count'] + $this->total_lists_yearly[array_search($value['year'], $this->years)]['completed_count'] + $this->total_lists_yearly[array_search($value['year'], $this->years)]['expired_count'];
        }

        $this->chart_config = [];

        foreach ($this->years as $key => $year) {
            $this->chart_config['monthly'][$key] = "{type:'line',data:{labels:";
            $monthly_labels = [];
            foreach ($this->total_lists_monthly[$key] as $item) {
                $dateObj = DateTime::createFromFormat('!m', $item['month']);
                if (!in_array($dateObj->format('F'), $monthly_labels, true)){
                    array_push($monthly_labels, $dateObj->format('F'));
                }
            }
            $this->chart_config['monthly'][$key] .= json_encode($monthly_labels);
            $this->chart_config['monthly'][$key] .= ",datasets:[{label:'Active',borderColor:'#34d399',backgroundColor:'#34d399',data:";
            $active_data = array_fill(0, 12, 0);
            for ($j = 0; $j < count($active_data); $j++) {
                $active_data[$j] = $this->total_lists_monthly[$key][$j]['active_count'];
            }
            $this->chart_config['monthly'][$key] .= json_encode($active_data);
            $this->chart_config['monthly'][$key] .= "},{label:'Completed',borderColor:'#60a5fa',backgroundColor:'#60a5fa',data:";
            $completed_data = array_fill(0, 12, 0);
            for ($j = 0; $j < count($completed_data); $j++) {
                $completed_data[$j] = $this->total_lists_monthly[$key][$j]['completed_count'];
            }
            $this->chart_config['monthly'][$key] .= json_encode($completed_data);
            $this->chart_config['monthly'][$key] .= "},{label:'Expired',borderColor:'#facc15',backgroundColor:'#facc15',data:";
            $expired_data = array_fill(0, 12, 0);
            for ($j = 0; $j < count($expired_data); $j++) {
                $expired_data[$j] = $this->total_lists_monthly[$key][$j]['expired_count'];
            }
            $this->chart_config['monthly'][$key] .= json_encode($expired_data);
            $this->chart_config['monthly'][$key] .= "}]},options:{scales:{y:{suggestedMin:0,ticks:{stepSize:1}}}}}";
        }

        $this->chart_config['yearly'] = "{type:'line',data:{labels:";
        $yearly_labels = [];
        for ($i = count($this->total_lists_yearly) - 1; $i > -1; $i--) {
            if (!in_array($this->total_lists_yearly[$i]['year'], $yearly_labels, true)){
                array_push($yearly_labels, $this->total_lists_yearly[$i]['year']);
            }
        }
        $this->chart_config['yearly'] .= json_encode($yearly_labels);
        $this->chart_config['yearly'] .= ",datasets:[{label:'Active',borderColor:'#10b981',backgroundColor:'#10b981',data:";
        $active_data = array_fill(0, count($this->years), 0);
        for ($j = 0; $j < count($active_data); $j++) {
            $active_data[$j] = $this->total_lists_yearly[$j]['active_count'];
        }
        $this->chart_config['yearly'] .= json_encode(array_reverse($active_data));
        $this->chart_config['yearly'] .= "},{label:'Completed',borderColor:'#3b82f6',backgroundColor:'#3b82f6',data:";
        $completed_data = array_fill(0, count($this->years), 0);
        for ($j = 0; $j < count($completed_data); $j++) {
            $completed_data[$j] = $this->total_lists_yearly[$j]['completed_count'];
        }
        $this->chart_config['yearly'] .= json_encode(array_reverse($completed_data));
        $this->chart_config['yearly'] .= "},{label:'Expired',borderColor:'#fde047',backgroundColor:'#fde047',data:";
        $expired_data = array_fill(0, count($this->years), 0);
        for ($j = 0; $j < count($expired_data); $j++) {
            $expired_data[$j] = $this->total_lists_yearly[$j]['expired_count'];
        }
        $this->chart_config['yearly'] .= json_encode(array_reverse($expired_data));
        $this->chart_config['yearly'] .= "}]},options:{scales:{y:{suggestedMin:0,ticks:{stepSize:1}}}}}";
    }

    public function render()
    {
        //dd($this->total_lists_monthly);
        if (Auth::user()->role_id != 'R1') abort(403);
        else return view('livewire.admin.admin-index');
    }

    public function generatepdf($report) {
        $years = ShoppingList::select(DB::raw('YEAR(updated_at) as year'))
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')->toArray();

        $total_lists_monthly = [];
        $final_total_lists_monthly = [];
        $final_total_lists_yearly = [];

        foreach ($years as $x => $year) {
            $final_total_lists_monthly[$x] = [];
            for ($j = 0; $j < 12; $j++) {
                array_push($final_total_lists_monthly[$x], [
                    'month' => $j + 1,
                    'active_count' => 0,
                    'completed_count' => 0,
                    'expired_count' => 0,
                    'month_count' => 0
                ]);
            }

            array_push($final_total_lists_yearly, [
                'year' => $year,
                'active_count' => 0,
                'completed_count' => 0,
                'expired_count' => 0,
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
                if ($value['list_status'] == 1) $final_total_lists_monthly[$x][$value['month'] - 1]['active_count'] = $value['month_count'];
                elseif ($value['list_status'] == 2) $final_total_lists_monthly[$x][$value['month'] - 1]['completed_count'] = $value['month_count'];
                elseif ($value['list_status'] == 3) $final_total_lists_monthly[$x][$value['month'] - 1]['expired_count'] = $value['month_count'];
                $final_total_lists_monthly[$x][$value['month'] - 1]['month_count'] = $final_total_lists_monthly[$x][$value['month'] - 1]['active_count'] + $final_total_lists_monthly[$x][$value['month'] - 1]['completed_count'] + $final_total_lists_monthly[$x][$value['month'] - 1]['expired_count'];
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
            if ($value['list_status'] == 1) $final_total_lists_yearly[array_search($value['year'], $years)]['active_count'] = $value['year_count'];
            elseif ($value['list_status'] == 2) $final_total_lists_yearly[array_search($value['year'], $years)]['completed_count'] = $value['year_count'];
            elseif ($value['list_status'] == 3) $final_total_lists_yearly[array_search($value['year'], $years)]['expired_count'] = $value['year_count'];
            $final_total_lists_yearly[array_search($value['year'], $years)]['year_count'] = $final_total_lists_yearly[array_search($value['year'], $years)]['active_count'] + $final_total_lists_yearly[array_search($value['year'], $years)]['completed_count'] + $final_total_lists_yearly[array_search($value['year'], $years)]['expired_count'];
        }

        $chart_config = [];

        foreach ($years as $key => $year) {
            $chart_config['monthly'][$key] = "{type:'line',data:{labels:";
            $monthly_labels = [];
            foreach ($final_total_lists_monthly[$key] as $item) {
                $dateObj = DateTime::createFromFormat('!m', $item['month']);
                if (!in_array($dateObj->format('F'), $monthly_labels, true)){
                    array_push($monthly_labels, $dateObj->format('F'));
                }
            }
            $chart_config['monthly'][$key] .= json_encode($monthly_labels);
            $chart_config['monthly'][$key] .= ",datasets:[{label:'Active',borderColor:'#34d399',backgroundColor:'#34d399',data:";
            $active_data = array_fill(0, 12, 0);
            for ($j = 0; $j < count($active_data); $j++) {
                $active_data[$j] = $final_total_lists_monthly[$key][$j]['active_count'];
            }
            $chart_config['monthly'][$key] .= json_encode($active_data);
            $chart_config['monthly'][$key] .= "},{label:'Completed',borderColor:'#60a5fa',backgroundColor:'#60a5fa',data:";
            $completed_data = array_fill(0, 12, 0);
            for ($j = 0; $j < count($completed_data); $j++) {
                $completed_data[$j] = $final_total_lists_monthly[$key][$j]['completed_count'];
            }
            $chart_config['monthly'][$key] .= json_encode($completed_data);
            $chart_config['monthly'][$key] .= "},{label:'Expired',borderColor:'#facc15',backgroundColor:'#facc15',data:";
            $expired_data = array_fill(0, 12, 0);
            for ($j = 0; $j < count($expired_data); $j++) {
                $expired_data[$j] = $final_total_lists_monthly[$key][$j]['expired_count'];
            }
            $chart_config['monthly'][$key] .= json_encode($expired_data);
            $chart_config['monthly'][$key] .= "}]},options:{scales:{y:{suggestedMin:0,ticks:{stepSize:1}}}}}";
        }

        $chart_config['yearly'] = "{type:'line',data:{labels:";
        $yearly_labels = [];
        for ($i = count($final_total_lists_yearly) - 1; $i > -1; $i--) {
            if (!in_array($final_total_lists_yearly[$i]['year'], $yearly_labels, true)){
                array_push($yearly_labels, $final_total_lists_yearly[$i]['year']);
            }
        }
        $chart_config['yearly'] .= json_encode($yearly_labels);
        $chart_config['yearly'] .= ",datasets:[{label:'Active',borderColor:'#10b981',backgroundColor:'#10b981',data:";
        $active_data = array_fill(0, count($years), 0);
        for ($j = 0; $j < count($active_data); $j++) {
            $active_data[$j] = $final_total_lists_yearly[$j]['active_count'];
        }
        $chart_config['yearly'] .= json_encode(array_reverse($active_data));
        $chart_config['yearly'] .= "},{label:'Completed',borderColor:'#3b82f6',backgroundColor:'#3b82f6',data:";
        $completed_data = array_fill(0, count($years), 0);
        for ($j = 0; $j < count($completed_data); $j++) {
            $completed_data[$j] = $final_total_lists_yearly[$j]['completed_count'];
        }
        $chart_config['yearly'] .= json_encode(array_reverse($completed_data));
        $chart_config['yearly'] .= "},{label:'Expired',borderColor:'#fde047',backgroundColor:'#fde047',data:";
        $expired_data = array_fill(0, count($years), 0);
        for ($j = 0; $j < count($expired_data); $j++) {
            $expired_data[$j] = $final_total_lists_yearly[$j]['expired_count'];
        }
        $chart_config['yearly'] .= json_encode(array_reverse($expired_data));
        $chart_config['yearly'] .= "}]},options:{scales:{y:{suggestedMin:0,ticks:{stepSize:1}}}}}";
        
        $monthly_list_sum = [];
        $yearly_list_sum = 0;
        $active_list_sum = [];
        $completed_list_sum = [];
        $expired_list_sum = [];

        foreach ($years as $key => $year) {
            $monthly_list_sum[$key] = $this->monthly_list_sum($final_total_lists_monthly[$key]);
            $yearly_list_sum = $this->yearly_list_sum($final_total_lists_yearly);
            
            $active_list_sum['monthly'][$key] = $this->active_list_sum($final_total_lists_monthly[$key]);
            $completed_list_sum['monthly'][$key] = $this->completed_list_sum($final_total_lists_monthly[$key]);
            $expired_list_sum['monthly'][$key] = $this->expired_list_sum($final_total_lists_monthly[$key]);

            $active_list_sum['yearly'] = $this->active_list_sum($final_total_lists_yearly);
            $completed_list_sum['yearly'] = $this->completed_list_sum($final_total_lists_yearly);
            $expired_list_sum['yearly'] = $this->expired_list_sum($final_total_lists_yearly);
        }
        
        return PDF::loadView('livewire.admin.report', [
            'report' => $report,
            'years' => $years,
            'total_lists_monthly' => $final_total_lists_monthly,
            'total_lists_yearly' => $final_total_lists_yearly,
            'chart_config' => $chart_config,
            'monthly_list_sum' => $monthly_list_sum,
            'yearly_list_sum' => $yearly_list_sum,
            'active_list_sum' => $active_list_sum,
            'completed_list_sum' => $completed_list_sum,
            'expired_list_sum' => $expired_list_sum
        ])->setOptions([
            'defaultFont' => 'Nunito',
            'isHtml5ParserEnabled' => true,
            'isRemoteEnabled' => true
        ])->setPaper('letter', 'portrait')->stream();
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

    public function expired_list_sum($arr)
    {
        $list_sum = 0;
        foreach ($arr as $item) {
            $list_sum += $item['expired_count'];
        }
        return $list_sum;
    }
}
