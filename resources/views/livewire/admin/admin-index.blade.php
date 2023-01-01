<div>
    <div class="max-w-7xl mx-auto px-3 pb-4 sm:px-6 lg:px-8">
        <div class="flex flex-row-reverse mt-8 mb-4">
            <div class="flex min-w-full justify-end">
                <button class="sc-btn-red-ghost">
                    <a href="{{ route('shopper/create') }}">
                        <i class="fa-solid fa-file-pdf"></i>&nbsp;Export Summary
                    </a>
                </button>
            </div>
        </div>
        <section class="mb-6">
            <div class="grid grid-cols-3 gap-3">
                <div class="grid grid-cols-3 mx-auto w-full text-left text-emerald-500 px-6 py-4 bg-white shadow-md h-full sm:rounded-xl">
                    <div class="col-span-2 flex flex-col h-full justify-center">
                        <span class="text-4xl">{{ number_format($shoppers, 0, '', ',') }}</span>
                        <span class="text-lg">Total Shoppers</span>
                    </div>
                    <div class="flex justify-end items-center">
                        <i class="fa-solid fa-user text-[50px]"></i>
                    </div>
                </div>
                <div class="grid grid-cols-3 mx-auto w-full text-left text-amber-500 px-6 py-4 bg-white shadow-md h-full sm:rounded-xl">
                    <div class="col-span-2 flex flex-col h-full justify-center">
                        <span class="text-4xl">{{ number_format($markets, 0, '', ',') }}</span>
                        <span class="text-lg">Total Markets</span>
                    </div>
                    <div class="flex justify-end items-center">
                        <i class="fa-solid fa-shop text-[50px]"></i>
                    </div>
                </div>
                <div class="grid grid-cols-3 mx-auto w-full text-left text-gray-500 px-6 py-4 bg-white shadow-md h-full sm:rounded-xl">
                    <div class="col-span-2 flex flex-col h-full justify-center">
                        <span class="text-4xl">{{ number_format($lists['total'], 0, '', ',') }}</span>
                        <span class="text-lg">Total Lists</span>
                        @if (!empty($lists['monthly']))
                        <span class="text-sm text-gray-500">
                            <span class="font-bold">{{ $lists['monthly'][0]['count'] }}</span> this month&nbsp;
                            @if (count($lists['monthly']) > 1)
                            @if ($lists['monthly'][0]['count'] > $lists['monthly'][1]['count'])
                            <i class="fa-solid fa-caret-up text-green-600"></i>
                            <span class="text-green-600">{{ number_format(($lists['monthly'][0]['count'] / $lists['monthly'][1]['count']) * 100 - 100, 2) }}%</span>
                            @else
                            <i class="fa-solid fa-caret-down text-red-600"></i>
                            <span class="text-red-600">{{ number_format(($lists['monthly'][0]['count'] / $lists['monthly'][1]['count']) * 100 - 100, 2) }}%</span>
                            @endif
                            @endif
                        </span>
                        @endif
                        @if (!empty($lists['yearly']))
                        <span class="text-sm text-gray-500">
                            <span class="font-bold">{{ $lists['yearly'][0]['count'] }}</span> this month&nbsp;
                            @if (count($lists['yearly']) > 1)
                            @if ($lists['yearly'][0]['count'] > $lists['yearly'][1]['count'])
                            <i class="fa-solid fa-caret-up text-green-600"></i>
                            <span class="text-green-600">{{ number_format(($lists['yearly'][0]['count'] / $lists['yearly'][1]['count']) * 100 - 100, 2) }}%</span>
                            @else
                            <i class="fa-solid fa-caret-down text-red-600"></i>
                            <span class="text-red-600">{{ number_format(($lists['yearly'][0]['count'] / $lists['yearly'][1]['count']) * 100 - 100, 2) }}%</span>
                            @endif
                            @endif
                        </span>
                        @endif
                    </div>
                    <div class="flex justify-end items-center">
                        <i class="fa-solid fa-list text-[50px]"></i>
                    </div>
                </div>
            </div>
        </section>
        <section class="mb-6">
            <div class="bg-gradient-to-r from-teal-600 to-emerald-400 py-1 rounded-lg text-center">
                <span class="text-2xl text-white font-bold">List Activity</span>
            </div>
            <div x-data="tabs" class="col-span-6 lg:col-span-4 mt-3">
                <div class="grid grid-cols-2 cursor-pointer font-bold">
                    <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive(1) ? 'bg-white text-emerald-600': 'bg-emerald-600 text-white'" @click="setActive(1)">Monthly activity</div>
                    <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive(2) ? 'bg-white text-emerald-600': 'bg-emerald-600 text-white'" @click="setActive(2)">Yearly activity</div>
                </div>
                <div class="min-w-full min-h-full lg:min-h-[500px] sm:max-w-md pt-4 bg-white shadow-md overflow-hidden rounded-b-lg">
                    <div x-show="isActive(1)" x-transition:enter.duration.500ms>
                        <div x-data="tabs">
                            <div class="grid grid-cols-{{ count($years) }} cursor-pointer font-bold">
                                @foreach ($years as $year)
                                <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive({{ array_search($year, $years) + 1 }}) ? 'bg-white text-emerald-500': 'bg-emerald-500 text-white'" @click="setActive({{ array_search($year, $years) + 1 }})">{{ $year }}</div>
                                @endforeach
                            </div>
                            <div class="min-w-full min-h-full sm:max-w-md py-4">
                                @foreach ($years as $year)
                                <div x-show="isActive({{ array_search($year, $years) + 1 }})" x-transition:enter.duration.500ms>
                                    <div class="flex flex-row-reverse my-3 mr-4">
                                        <div class="flex min-w-full justify-end">
                                            <button class="sc-btn-red-ghost">
                                                <a href="{{ route('shopper/create') }}">
                                                    <i class="fa-solid fa-file-pdf"></i>&nbsp;Export
                                                </a>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-2 gap-6 px-6">
                                        <div>
                                            <canvas id="total-lists-monthly-{{ $year }}"></canvas>
                                        </div>
                                        <div class="overflow-auto rounded-sm">
                                            <table class="table-auto w-full">
                                                <!-- head -->
                                                <thead class="bg-emerald-400 text-white p-2">
                                                    <tr>
                                                        <th>Month</th>
                                                        <th>Active</th>
                                                        <th>Completed</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="text-gray-600">
                                                    @foreach ($total_lists_monthly[array_search($year, $years)] as $item)
                                                    <tr class="table-group">
                                                        <td class="table-item">
                                                            {{ DateTime::createFromFormat('!m', $item['month'])->format('F') }}
                                                        </td>
                                                        <td class="table-item text-end bg-emerald-100">
                                                            {{ $item['active_count'] }}
                                                        </td>
                                                        <td class="table-item text-end bg-blue-200">
                                                            {{ $item['completed_count'] }}
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    <tr class="table-group">
                                                        <td class="table-item font-bold bg-gray-300">Sum</td>
                                                        <td class="table-item text-end font-bold bg-emerald-300">{{ $this->active_list_sum($total_lists_monthly[array_search($year, $years)]) }}</td>
                                                        <td class="table-item text-end font-bold bg-blue-400">{{ $this->completed_list_sum($total_lists_monthly[array_search($year, $years)]) }}</td>
                                                    </tr>
                                                    <tr class="table-group bg-gray-700 text-white">
                                                        <td class="font-bold">Total</td>
                                                        <td></td>
                                                        <td class="table-item text-end font-bold">
                                                            {{ $this->monthly_list_sum($total_lists_monthly[array_search($year, $years)]) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div x-show="isActive(2)" x-transition:enter.duration.500ms>
                        <div class="flex flex-row-reverse my-3 mr-4">
                            <div class="flex min-w-full justify-end">
                                <button class="sc-btn-red-ghost">
                                    <a href="{{ route('shopper/create') }}">
                                        <i class="fa-solid fa-file-pdf"></i>&nbsp;Export
                                    </a>
                                </button>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 p-4">
                            <div>
                                <canvas id="total-lists-yearly"></canvas>
                            </div>
                            <div class="overflow-auto rounded-sm">
                                <table class="table-auto w-full">
                                    <!-- head -->
                                    <thead class="bg-emerald-400 text-white p-2">
                                        <tr>
                                            <th>Year</th>
                                            <th>Active</th>
                                            <th>Completed</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-gray-600">
                                        @foreach ($total_lists_yearly as $item)
                                        <tr class="table-group">
                                            <td class="table-item">
                                                {{ $item['year'] }}
                                            </td>
                                            <td class="table-item text-end bg-emerald-100">
                                                {{ $item['active_count'] }}
                                            </td>
                                            <td class="table-item text-end bg-blue-200">
                                                {{ $item['completed_count'] }}
                                            </td>
                                        </tr>
                                        @endforeach
                                        <tr class="table-group">
                                            <td class="table-item font-bold bg-gray-300">Sum</td>
                                            <td class="table-item text-end font-bold bg-emerald-300">{{ $this->active_list_sum($total_lists_yearly) }}</td>
                                            <td class="table-item text-end font-bold bg-blue-400">{{ $this->completed_list_sum($total_lists_yearly) }}</td>
                                        </tr>
                                        <tr class="table-group bg-gray-700 text-white">
                                            <td class="font-bold">Total</td>
                                            <td></td>
                                            <td class="table-item text-end font-bold">
                                                {{ $this->yearly_list_sum($total_lists_yearly) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        function tabs() {
            return {
                active: 1,
                isActive(tab) {
                    return tab == this.active;
                },
                setActive(value) {
                    this.active = value;
                }
            }
        }
        // monthly lists
        <?php
        for ($i = 0; $i < count($years); $i++) {
            echo "var monthlyLists" . ($i + 1) . " = {
                type: 'line',
                data: {
                    labels: ";
            $labels = [];
            foreach ($total_lists_monthly[$i] as $item) {
                $dateObj = DateTime::createFromFormat('!m', $item['month']);
                if (!in_array($dateObj->format('F'), $labels, true)){
                    array_push($labels, $dateObj->format('F'));
                }
            }
            echo json_encode($labels);
            echo ",
                    datasets: [{
                            label: 'Active',
                            borderColor: '#10b981',
                            backgroundColor: '#10b981',
                            data: ";
            $active_data = array_fill(0, 12, 0);
            for ($j = 0; $j < count($active_data); $j++) {
                $active_data[$j] = $total_lists_monthly[$i][$j]['active_count'];
            }
            echo json_encode($active_data);
            echo "},
                        {
                            label: 'Completed',
                            borderColor: '#3b82f6',
                            backgroundColor: '#3b82f6',
                            data: ";
            $completed_data = array_fill(0, 12, 0);
            for ($j = 0; $j < count($completed_data); $j++) {
                $completed_data[$j] = $total_lists_monthly[$i][$j]['completed_count'];
            }
            echo json_encode($completed_data);
            echo "}
                    ]
                },
                options: {
                    scales: {
                        y: {
                            suggestedMin: 0,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            }
            var ctx = document.getElementById('total-lists-monthly-" . $years[$i] . "').getContext('2d');
            new Chart(ctx, monthlyLists" . ($i + 1) . ");";
        }
        ?>

        // yearly lists
        <?php
        echo "var chartdata5 = {
            type: 'line',
            data: {
                labels: ";
        $labels = [];
        for ($i = count($total_lists_yearly) - 1; $i > -1; $i--) {
            if (!in_array($total_lists_yearly[$i]['year'], $labels, true)){
                array_push($labels, $total_lists_yearly[$i]['year']);
            }
        }
        echo json_encode($labels);
        echo ",
                datasets: [
                    {
                        label: 'Active',
                        borderColor: '#10b981',
                        backgroundColor: '#10b981',
                        data: ";
        $active_data = array_fill(0, count($years), 0);
        for ($j = 0; $j < count($active_data); $j++) {
            $active_data[$j] = $total_lists_yearly[$j]['active_count'];
        }
        echo json_encode(array_reverse($active_data));
        echo "},
                    {
                        label: 'Completed',
                        borderColor: '#3b82f6',
                        backgroundColor: '#3b82f6',
                        data: ";
        $completed_data = array_fill(0, count($years), 0);
        for ($j = 0; $j < count($completed_data); $j++) {
            $completed_data[$j] = $total_lists_yearly[$j]['completed_count'];
        }
        echo json_encode(array_reverse($completed_data));
        echo "}
                ]
            },
            options: {
                scales: {
                    y: {
                        suggestedMin: 0,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        }
        var ctx = document.getElementById('total-lists-yearly').getContext('2d');
        new Chart(ctx, chartdata5);"
        ?>
    </script>
</div>