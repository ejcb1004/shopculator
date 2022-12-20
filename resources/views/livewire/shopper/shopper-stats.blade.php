<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <section class="mb-6 mt-8">
            <div class="bg-gradient-to-r from-teal-600 to-emerald-400 py-1 rounded-lg text-center">
                <span class="text-2xl text-white font-bold">Frequently Bought Products</span>
            </div>
            <div x-data="tabs" class="col-span-6 lg:col-span-4 mt-3">
                <div class="grid grid-cols-2 cursor-pointer font-bold">
                    <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive(1) ? 'bg-white text-emerald-600': 'bg-emerald-600 text-white'" @click="setActive(1)">Monthly trending</div>
                    <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive(2) ? 'bg-white text-emerald-600': 'bg-emerald-600 text-white'" @click="setActive(2)">Yearly trending</div>
                </div>
                <div class="min-w-full min-h-full lg:min-h-[500px] sm:max-w-md pt-4 bg-white shadow-md overflow-hidden rounded-b-lg">
                    <div x-show="isActive(1)" x-transition:enter.duration.500ms>
                        <div x-data="tabs">
                            <div class="grid grid-cols-{{ count($mo_years) }} cursor-pointer font-bold">
                                @foreach ($mo_years as $year)
                                <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive({{ array_search($year, $mo_years) + 1 }}) ? 'bg-white text-emerald-500': 'bg-emerald-500 text-white'" @click="setActive({{ array_search($year, $mo_years) + 1 }})">{{ date('F') . ' ' . $year }}</div>
                                @endforeach
                            </div>
                            <div class="min-w-full min-h-full sm:max-w-md py-4 px-6">
                                @foreach ($mo_years as $year)
                                <div x-show="isActive({{ array_search($year, $mo_years) + 1 }})" x-transition:enter.duration.500ms>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="grid grid-cols-3 gap-3 mt-3 mb-3">
                                            <div class="mx-auto max-w-full text-center text-gray-600 px-6 py-4 h-full">
                                                <div class="flex flex-col">
                                                    <div class="max-w-[28px]">
                                                        <div class="bg-yellow-400 rounded-full text-xl text-white font-bold">{{ array_search($monthly_top_trending[array_search($year, $mo_years)][0], $monthly_top_trending[array_search($year, $mo_years)]) + 1 }}</div>
                                                    </div>
                                                    <img src="{{ $monthly_top_trending[array_search($year, $mo_years)][0]['image_path'] }}" class="max-w-[175px] mx-auto" />
                                                    <span class="text-lg leading-tight font-bold mb-1">{{ $monthly_top_trending[array_search($year, $mo_years)][0]['product_name'] }}</span>
                                                    <span class="text-md leading-tight">In your lists
                                                        <span class="font-bold text-emerald-600">
                                                            {{ $monthly_top_trending[array_search($year, $mo_years)][0]['total_count'] }}
                                                        </span>
                                                        time(s) this month
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 col-span-2 gap-3">
                                                @for ($i = 1; $i < count($monthly_top_trending[array_search($year, $mo_years)]); $i++) 
                                                <div class="mx-auto w-full text-center text-gray-600 px-4 py-2">
                                                    <div class="flex flex-col">
                                                        <div class="max-w-[20px]">
                                                            <div class="@if ($i + 1 == 2) bg-gray-400 @elseif ($i + 1 == 3) bg-amber-700 @else bg-emerald-600 @endif rounded-full text-sm text-white font-bold">{{ array_search($monthly_top_trending[array_search($year, $mo_years)][$i], $monthly_top_trending[array_search($year, $mo_years)]) + 1 }}</div>
                                                        </div>
                                                        <img src="{{ $monthly_top_trending[array_search($year, $mo_years)][$i]['image_path'] }}" class="max-w-[100px] mx-auto" />
                                                        <span class="text-md leading-tight font-bold mb-1">{{ $monthly_top_trending[array_search($year, $mo_years)][$i]['product_name'] }}</span>
                                                        <span class="text-sm leading-tight">In your lists
                                                            <span class="font-bold text-emerald-600">
                                                                {{ $monthly_top_trending[array_search($year, $mo_years)][$i]['total_count'] }}
                                                            </span>
                                                            time(s) this month
                                                        </span>
                                                    </div>
                                                </div>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3 mt-3 mb-3">
                                            <div>
                                                <canvas id="total-trending-monthly-{{ $year }}"></canvas>
                                            </div>
                                            <div>
                                                <div class="overflow-auto rounded-sm">
                                                    <table class="table-auto w-full">
                                                        <!-- head -->
                                                        <thead class="bg-emerald-400 text-white p-2">
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Count</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-gray-600">
                                                            @foreach ($monthly_top_trending[array_search($year, $an_years)] as $item)
                                                            <tr class="table-group even:bg-emerald-100 odd:bg-white">
                                                                <td class="table-item">
                                                                    {{ $item['product_name'] }}
                                                                </td>
                                                                <td class="table-item">
                                                                    {{ $item['total_count'] }}
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div x-show="isActive(2)" x-transition:enter.duration.500ms>
                        <div x-data="tabs">
                            <div class="grid grid-cols-{{ count($an_years) }} cursor-pointer font-bold">
                                @foreach ($an_years as $year)
                                <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive({{ array_search($year, $an_years) + 1 }}) ? 'bg-white text-emerald-500': 'bg-emerald-500 text-white'" @click="setActive({{ array_search($year, $an_years) + 1 }})">{{ $year }}</div>
                                @endforeach
                            </div>
                            <div class="min-w-full min-h-full sm:max-w-md py-4 px-6">
                                @foreach ($an_years as $year)
                                <div x-show="isActive({{ array_search($year, $an_years) + 1 }})" x-transition:enter.duration.500ms>
                                    <div class="grid grid-cols-2 gap-3">
                                        <div class="grid grid-cols-3 gap-3 mt-3 mb-3">
                                            <div class="mx-auto w-full text-center text-gray-600 px-6 py-4 mt-8 h-full">
                                                <div class="flex flex-col">
                                                    <div class="max-w-[28px]">
                                                        <div class="bg-yellow-400 rounded-full text-xl text-white font-bold">{{ array_search($yearly_top_trending[array_search($year, $an_years)][0], $yearly_top_trending[array_search($year, $an_years)]) + 1 }}</div>
                                                    </div>
                                                    <img src="{{ $yearly_top_trending[array_search($year, $an_years)][0]['image_path'] }}" class="max-w-[175px] mx-auto" />
                                                    <span class="text-lg leading-tight font-bold mb-1">{{ $yearly_top_trending[array_search($year, $an_years)][0]['product_name'] }}</span>
                                                    <span class="text-md leading-tight">In your lists
                                                        <span class="font-bold text-emerald-600">
                                                            {{ $yearly_top_trending[array_search($year, $an_years)][0]['total_count'] }}
                                                        </span>
                                                        time(s) this year
                                                    </span>
                                                </div>
                                            </div>
                                            <div class="grid grid-cols-2 col-span-2 gap-3">
                                                @for ($i = 1; $i < count($yearly_top_trending[array_search($year, $an_years)]); $i++) 
                                                <div class="mx-auto w-full text-center text-gray-600 px-4 py-2">
                                                    <div class="flex flex-col">
                                                        <div class="max-w-[20px]">
                                                            <div class="@if ($i + 1 == 2) bg-gray-400 @elseif ($i + 1 == 3) bg-amber-700 @else bg-emerald-600 @endif rounded-full text-sm text-white font-bold">{{ array_search($yearly_top_trending[array_search($year, $an_years)][$i], $yearly_top_trending[array_search($year, $an_years)]) + 1 }}</div>
                                                        </div>
                                                        <img src="{{ $yearly_top_trending[array_search($year, $an_years)][$i]['image_path'] }}" class="max-w-[100px] mx-auto" />
                                                        <span class="text-md leading-tight font-bold mb-1">{{ $yearly_top_trending[array_search($year, $an_years)][$i]['product_name'] }}</span>
                                                        <span class="text-sm leading-tight">In your lists
                                                            <span class="font-bold text-emerald-600">
                                                                {{ $yearly_top_trending[array_search($year, $an_years)][$i]['total_count'] }}
                                                            </span>
                                                            time(s) this year
                                                        </span>
                                                    </div>
                                                </div>
                                                @endfor
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-1 gap-3 mt-3 mb-3">
                                            <div>
                                                <canvas id="total-trending-yearly-{{ $year }}"></canvas>
                                            </div>
                                            <div>
                                                <div class="overflow-auto rounded-sm">
                                                    <table class="table-auto w-full">
                                                        <!-- head -->
                                                        <thead class="bg-emerald-400 text-white p-2">
                                                            <tr>
                                                                <th>Product</th>
                                                                <th>Count</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-gray-600">
                                                            @foreach ($yearly_top_trending[array_search($year, $an_years)] as $item)
                                                            <tr class="table-group even:bg-emerald-100 odd:bg-white">
                                                                <td class="table-item">
                                                                    {{ $item['product_name'] }}
                                                                </td>
                                                                <td class="table-item">
                                                                    {{ $item['total_count'] }}
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="bg-gradient-to-r from-teal-600 to-emerald-400 py-1 mt-2 rounded-lg text-center">
                <span class="text-2xl text-white font-bold">List Count</span>
            </div>
            <div class="grid grid-cols-6 gap-3 mt-3 mb-12">
                <div class="col-span-6 lg:col-span-2 min-w-full min-h-full sm:max-w-md bg-white shadow-md overflow-hidden rounded-lg">
                    <div class="py-1 text-center">
                        <span class="text-emerald-600 font-bold">Total Lists</span>
                    </div>
                    <div class="mx-auto p-4 max-w-[350px] lg:max-w-full lg:min-h-[250px]">
                        <canvas id="total-lists"></canvas>
                        <div class="grid grid-cols-2 gap-2 pt-8">
                            <div class="flex flex-col items-center">
                                <span class="font-bold text-emerald-600 text-[50px] leading-none">{{ $total_lists['data'][0] / ($total_lists['data'][0] + $total_lists['data'][1]) * 100}}%</span>
                                <span class="font-bold text-emerald-600">Active Lists</span>
                            </div>
                            <div class="flex flex-col items-center">
                                <span class="font-bold text-blue-600 text-[50px] leading-none">{{ $total_lists['data'][1] / ($total_lists['data'][0] + $total_lists['data'][1]) * 100}}%</span>
                                <span class="font-bold text-blue-600">Completed Lists</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div x-data="tabs" class="col-span-6 lg:col-span-4">
                    <div class="grid grid-cols-2 cursor-pointer font-bold">
                        <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive(1) ? 'bg-white text-emerald-600': 'bg-emerald-600 text-white'" @click="setActive(1)">Monthly lists</div>
                        <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive(2) ? 'bg-white text-emerald-600': 'bg-emerald-600 text-white'" @click="setActive(2)">Yearly lists</div>
                    </div>
                    <div class="min-w-full min-h-full lg:min-h-[500px] sm:max-w-md pt-4 bg-white shadow-md overflow-hidden rounded-b-lg">
                        <div x-show="isActive(1)" x-transition:enter.duration.500ms>
                            <div x-data="tabs">
                                <div class="grid grid-cols-{{ count($an_years) }} cursor-pointer font-bold">
                                    @foreach ($an_years as $year)
                                    <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive({{ array_search($year, $an_years) + 1 }}) ? 'bg-white text-emerald-500': 'bg-emerald-500 text-white'" @click="setActive({{ array_search($year, $an_years) + 1 }})">{{ $year }}</div>
                                    @endforeach
                                </div>
                                <div class="min-w-full min-h-full sm:max-w-md py-4 px-6">
                                    @foreach ($an_years as $year)
                                    <div x-show="isActive({{ array_search($year, $an_years) + 1 }})" x-transition:enter.duration.500ms>
                                        <div class="grid grid-cols-3 gap-3 w-full pt-4">
                                            <div class="col-span-3 lg:col-span-2">
                                                <canvas id="total-lists-monthly-{{ $year }}"></canvas>
                                            </div>
                                            <div class="col-span-3 lg:col-span-1 mx-auto min-w-full">
                                                <div class="overflow-auto rounded-sm">
                                                    <table class="table-auto w-full">
                                                        <!-- head -->
                                                        <thead class="bg-emerald-400 text-white p-2">
                                                            <tr>
                                                                <th>Month</th>
                                                                <th>Status</th>
                                                                <th>No. of Lists</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="text-gray-600">
                                                            @foreach ($total_lists_monthly[array_search($year, $an_years)] as $item)
                                                            <tr class="table-group">
                                                                <td class="table-item">
                                                                    {{ DateTime::createFromFormat('!m', $item['month'])->format('M') }}
                                                                </td>
                                                                <td class="table-item {{ $item['list_status'] == 1 ? 'text-emerald-700' : 'text-blue-700' }}">
                                                                    {{ $item['list_status'] == 1 ? 'Active' : 'Completed' }}
                                                                </td>
                                                                <td class="table-item">
                                                                    {{ $item['month_count'] }}
                                                                </td>
                                                            </tr>
                                                            @endforeach
                                                            <tr class="table-group bg-emerald-500 text-white">
                                                                <td></td>
                                                                <td class="font-bold">Active</td>
                                                                <td class="table-item">
                                                                    {{ $this->monthly_active_list_sum($total_lists_monthly[array_search($year, $an_years)]) }}
                                                                </td>
                                                            </tr>
                                                            <tr class="table-group bg-blue-600 text-white">
                                                                <td></td>
                                                                <td class="font-bold">Completed</td>
                                                                <td class="table-item">
                                                                    {{ $this->monthly_completed_list_sum($total_lists_monthly[array_search($year, $an_years)]) }}
                                                                </td>
                                                            </tr>
                                                            <tr class="table-group bg-gray-700 text-white">
                                                                <td></td>
                                                                <td class="font-bold">Total</td>
                                                                <td class="table-item">
                                                                    {{ $this->monthly_list_sum($total_lists_monthly[array_search($year, $an_years)]) }}
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div x-show="isActive(2)" class="h-[475px] flex items-center justify-center" x-transition:enter.duration.500ms>
                            <div class="grid grid-cols-3 p-4">
                                <div class="mx-auto min-w-[475px] col-span-2">
                                    <canvas id="total-lists-yearly"></canvas>
                                </div>
                                <div class="mx-auto min-w-full my-auto">
                                    <table class="table-auto w-full">
                                        <!-- head -->
                                        <thead class="bg-emerald-400 text-white p-2">
                                            <tr>
                                                <th>Year</th>
                                                <th>Status</th>
                                                <th>No. of Lists</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-gray-600">
                                            @foreach ($total_lists_yearly as $item)
                                            <tr class="table-group even:bg-emerald-100 odd:bg-white">
                                                <td class="table-item">
                                                    {{ $item['year'] }}
                                                </td>
                                                <td class="table-item">
                                                    {{ $item['list_status'] == 1 ? 'Active' : 'Completed' }}
                                                </td>
                                                <td class="table-item">
                                                    {{ $item['year_count'] }}
                                                </td>
                                            </tr>
                                            @endforeach
                                            <tr class="table-group bg-emerald-500 text-white">
                                                <td></td>
                                                <td class="font-bold">Active</td>
                                                <td class="table-item">
                                                    {{ $this->yearly_active_list_sum($total_lists_yearly) }}
                                                </td>
                                            </tr>
                                            <tr class="table-group bg-blue-600 text-white">
                                                <td></td>
                                                <td class="font-bold">Completed</td>
                                                <td class="table-item">
                                                    {{ $this->yearly_completed_list_sum($total_lists_yearly) }}
                                                </td>
                                            </tr>
                                            <tr class="table-group bg-gray-700 text-white">
                                                <td></td>
                                                <td class="font-bold">Total</td>
                                                <td class="table-item">
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

        // total lists 
        var totalLists = {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($total_lists['labels']); ?>,
                datasets: [{
                    label: 'Total lists',
                    backgroundColor: [
                        '#10b981',
                        '#3b82f6'
                    ],
                    data: <?php echo json_encode($total_lists['data']); ?>
                }]
            }
        }
        var ctx = document.getElementById('total-lists').getContext('2d');
        new Chart(ctx, totalLists);

        // monthly lists
        <?php
        for ($i = 0; $i < count($an_years); $i++) {
            echo "var monthlyLists" . ($i + 1) . " = {
                type: 'line',
                data: {
                    labels: ";
            $labels = [];
            foreach ($total_lists_monthly[$i] as $item) {
                $dateObj = DateTime::createFromFormat('!m', $item['month']);
                array_push($labels, $dateObj->format('F'));
            }
            echo json_encode($labels);
            echo ",
                    datasets: [{
                            label: 'Active',
                            backgroundColor: '#10b981',
                            data: ";
            $active_data = [];
            foreach ($total_lists_monthly[$i] as $item) {
                if ($item['list_status'] == 1)
                    array_push($active_data, $item['month_count']);
                else array_push($active_data, 0);
            }
            echo json_encode($active_data);
            echo "},
                        {
                            label: 'Completed',
                            backgroundColor: '#3b82f6',
                            data: ";
            $completed_data = [];
            foreach ($total_lists_monthly[$i] as $item) {
                if ($item['list_status'] == 2)
                    array_push($completed_data, $item['month_count']);
                else array_push($completed_data, 0);
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
            var ctx = document.getElementById('total-lists-monthly-" . $an_years[$i] . "').getContext('2d');
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
            array_push($labels, $total_lists_yearly[$i]['year']);
        }
        echo json_encode($labels);
        echo ",
                datasets: [
                    {
                        label: 'Active',
                        backgroundColor: '#10b981',
                        data: ";
        $active_data = [];
        for ($i = count($total_lists_yearly) - 1; $i > -1; $i--) {
            if ($total_lists_yearly[$i]['list_status'] == 1)
                array_push($active_data, $total_lists_yearly[$i]['year_count']);
            else array_push($active_data, 0);
        }
        echo json_encode($active_data);
        echo "},
                    {
                        label: 'Completed',
                        backgroundColor: '#3b82f6',
                        data: ";
        $completed_data = [];
        for ($i = count($total_lists_yearly) - 1; $i > -1; $i--) {
            if ($total_lists_yearly[$i]['list_status'] == 2)
                array_push($completed_data, $total_lists_yearly[$i]['year_count']);
            else array_push($completed_data, 0);
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
        var ctx = document.getElementById('total-lists-yearly').getContext('2d');
        new Chart(ctx, chartdata5);"
        ?>

        // monthly trending
        <?php
        for ($i = 0; $i < count($mo_years); $i++) {
            echo "var monthlyTrending" . ($i + 1) . " = {
                type: 'bar',
                data: {
                    labels: ['Count'],
                    datasets: [";
            for ($j = 0; $j < count($monthly_top_trending[$i]); $j++) {
                echo "{
                                label: '" . $monthly_top_trending[$i][$j]['product_name'] . "' ";
                echo ",
                                backgroundColor: '" . $colors[$j] . "',
                                data: [" .
                    $monthly_top_trending[$i][$j]['total_count'] .
                    "]},";
            }
            echo "]
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
            var ctx = document.getElementById('total-trending-monthly-" . $mo_years[$i] . "').getContext('2d');
            new Chart(ctx, monthlyTrending" . ($i + 1) . ");";
        }
        ?>

        // yearly trending
        <?php
        for ($i = 0; $i < count($an_years); $i++) {
            echo "var yearlyTrending" . ($i + 1) . " = {
                type: 'bar',
                data: {
                    labels: ['Count'],
                    datasets: [";
            for ($j = 0; $j < count($yearly_top_trending[$i]); $j++) {
                echo "{
                                label: '" . $yearly_top_trending[$i][$j]['product_name'] . "' ";
                echo ",
                                backgroundColor: '" . $colors[$j] . "',
                                data: [" .
                    $yearly_top_trending[$i][$j]['total_count'] .
                    "]},";
            }
            echo "]
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
            var ctx = document.getElementById('total-trending-yearly-" . $an_years[$i] . "').getContext('2d');
            new Chart(ctx, yearlyTrending" . ($i + 1) . ");";
        }
        ?>
    </script>
</div>