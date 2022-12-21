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
            <div class="grid grid-cols-2 gap-3">
                <div class="grid grid-cols-3 mx-auto w-full text-left text-emerald-500 px-6 py-4 bg-white shadow-md h-full sm:rounded-xl">
                    <div class="col-span-2 flex flex-col h-full justify-center">
                        <span class="text-4xl">{{ number_format($total_products, 0, '', ',') }}</span>
                        <span class="text-lg">Total Products</span>
                    </div>
                    <div class="flex justify-end items-center">
                        <i class="fa-solid fa-boxes-stacked text-[50px]"></i>
                    </div>
                </div>
                <div class="grid grid-cols-3 mx-auto w-full text-left px-6 py-4 bg-white shadow-md h-full sm:rounded-xl">
                    <div class="col-span-2 flex flex-col h-full justify-center">
                        <span class="text-4xl text-amber-500">{{ number_format($total_cp, 0, '', ',') }}</span>
                        <span class="text-lg text-amber-500">Total Customer Purchases</span>
                        @if (!empty($monthly_purchases))
                        <span class="text-sm text-gray-500">
                            <span class="font-bold">{{ $monthly_purchases[0]['purchases'] }}</span> this month&nbsp;
                            @if (count($monthly_purchases) > 1)
                            @if ($monthly_purchases[0]['purchases'] > $monthly_purchases[1]['purchases'])
                            <i class="fa-solid fa-caret-up text-green-600"></i>
                            <span class="text-green-600">{{ number_format(($monthly_purchases[0]['purchases'] / $monthly_purchases[1]['purchases']) * 100 - 100, 2) }}%</span>
                            @else
                            <i class="fa-solid fa-caret-down text-red-600"></i>
                            <span class="text-red-600">{{ number_format(($monthly_purchases[0]['purchases'] / $monthly_purchases[1]['purchases']) * 100 - 100, 2) }}%</span>
                            @endif
                            @endif
                        </span>
                        @endif
                        @if (!empty($yearly_purchases))
                        <span class="text-sm text-gray-500">
                            <span class="font-bold">{{ $yearly_purchases[0]['purchases'] }}</span> this year&nbsp;
                            @if (count($yearly_purchases) > 1)
                            @if ($yearly_purchases[0]['purchases'] > $yearly_purchases[1]['purchases'])
                            <i class="fa-solid fa-caret-up text-green-600"></i>
                            <span class="text-green-600">{{ number_format(($yearly_purchases[0]['purchases'] / $yearly_purchases[1]['purchases']) * 100 - 100, 2) }}%</span>
                            @else
                            <i class="fa-solid fa-caret-down text-red-600"></i>
                            <span class="text-red-600">{{ number_format(($yearly_purchases[0]['purchases'] / $yearly_purchases[1]['purchases']) * 100 - 100, 2) }}%</span>
                            @endif
                            @endif
                        </span>
                        @endif
                    </div>
                    <div class="flex justify-end items-center">
                        <i class="fa-solid fa-bag-shopping text-amber-500 text-[50px]"></i>
                    </div>
                </div>
            </div>
        </section>
        <section class="mb-6">
            <div class="bg-gradient-to-r from-teal-600 to-emerald-400 py-1 rounded-lg text-center">
                <span class="text-2xl text-white font-bold">Trending Products</span>
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
                            <div class="min-w-full min-h-full sm:max-w-md py-4">
                                @foreach ($mo_years as $year)
                                <div x-show="isActive({{ array_search($year, $mo_years) + 1 }})" x-transition:enter.duration.500ms>
                                    <div x-data="tabs">
                                        <div class="grid grid-cols-{{ count($categories) + 1 }} cursor-pointer font-bold">
                                            <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive(1) ? 'bg-white text-emerald-400': 'bg-emerald-400 text-white'" @click="setActive(1)">Overall</div>
                                            @foreach ($categories as $category)
                                            <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive({{ array_search($category, $categories) + 2 }}) ? 'bg-white text-emerald-400': 'bg-emerald-400 text-white'" @click="setActive({{ array_search($category, $categories) + 2 }})">{{ $category['category_name'] }}</div>
                                            @endforeach
                                        </div>
                                        <div class="min-w-full min-h-full sm:max-w-md py-4 px-6">
                                            <div x-show="isActive(1)" x-transition:enter.duration.500ms>
                                                <div class="flex flex-row-reverse my-3">
                                                    <div class="flex min-w-full justify-end">
                                                        <button class="sc-btn-red-ghost">
                                                            <a href="{{ route('shopper/create') }}">
                                                                <i class="fa-solid fa-file-pdf"></i>&nbsp;Export
                                                            </a>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div class="grid grid-cols-3 gap-3 mt-3 mb-3">
                                                        <div class="mx-auto max-w-full text-center text-gray-600 px-6 py-4 h-full">
                                                            <div class="flex flex-col">
                                                                <div class="max-w-[28px]">
                                                                    <div class="bg-yellow-400 rounded-full text-xl text-white font-bold">{{ array_search($monthly_top_trending[array_search($year, $mo_years)][0], $monthly_top_trending[array_search($year, $mo_years)]) + 1 }}</div>
                                                                </div>
                                                                <img src="{{ $monthly_top_trending[array_search($year, $mo_years)][0]['image_path'] }}" class="max-w-[175px] mx-auto" />
                                                                <span class="text-lg leading-tight font-bold mb-1">{{ $monthly_top_trending[array_search($year, $mo_years)][0]['product_name'] }}</span>
                                                                <span class="text-md leading-tight">Picked
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
                                                                    <span class="text-sm leading-tight">Picked
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
                                                                        @foreach ($monthly_top_trending[array_search($year, $mo_years)] as $item)
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
                                            @foreach ($categories as $category)
                                            <div x-show="isActive({{ array_search($category, $categories) + 2 }})" x-transition:enter.duration.500ms>
                                                @if ( !empty($mtt_category[array_search($category, $categories) + (array_search($year, $mo_years) * count($categories))]) )
                                                <div class="flex flex-row-reverse my-3">
                                                    <div class="flex min-w-full justify-end">
                                                        <button class="sc-btn-red-ghost">
                                                            <a href="{{ route('shopper/create') }}">
                                                                <i class="fa-solid fa-file-pdf"></i>&nbsp;Export
                                                            </a>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div class="grid grid-cols-3 gap-3 mt-3 mb-3">
                                                        <div class="mx-auto max-w-full text-center text-gray-600 px-6 py-4 h-full">
                                                            <div class="flex flex-col">
                                                                <div class="max-w-[28px]">
                                                                    <div class="bg-yellow-400 rounded-full text-xl text-white font-bold">{{ array_search($mtt_category[array_search($category, $categories) + (array_search($year, $mo_years) * count($categories))][0], $mtt_category[array_search($category, $categories) + (array_search($year, $mo_years) * count($categories))]) + 1 }}</div>
                                                                </div>
                                                                <img src="{{ $mtt_category[array_search($category, $categories) + (array_search($year, $mo_years) * count($categories))][0]['image_path'] }}" class="max-w-[175px] mx-auto" />
                                                                <span class="text-lg leading-tight font-bold mb-1">{{ $mtt_category[array_search($category, $categories) + (array_search($year, $mo_years) * count($categories))][0]['product_name'] }}</span>
                                                                <span class="text-md leading-tight">Picked
                                                                    <span class="font-bold text-emerald-600">
                                                                        {{ $mtt_category[array_search($category, $categories) + (array_search($year, $mo_years) * count($categories))][0]['total_count'] }}
                                                                    </span>
                                                                    time(s) this month
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-2 col-span-2 gap-3">
                                                            @for ($i = 1; $i < count($mtt_category[array_search($category, $categories) + (array_search($year, $mo_years) * count($categories))]); $i++) 
                                                            <div class="mx-auto w-full text-center text-gray-600 px-4 py-2">
                                                                <div class="flex flex-col">
                                                                    <div class="max-w-[20px]">
                                                                        <div class="@if ($i + 1 == 2) bg-gray-400 @elseif ($i + 1 == 3) bg-amber-700 @else bg-emerald-600 @endif rounded-full text-sm text-white font-bold">{{ array_search($mtt_category[array_search($category, $categories) + (array_search($year, $mo_years) * count($categories))][$i], $mtt_category[array_search($category, $categories) + (array_search($year, $mo_years) * count($categories))]) + 1 }}</div>
                                                                    </div>
                                                                    <img src="{{ $mtt_category[array_search($category, $categories) + (array_search($year, $mo_years) * count($categories))][$i]['image_path'] }}" class="max-w-[100px] mx-auto" />
                                                                    <span class="text-md leading-tight font-bold mb-1">{{ $mtt_category[array_search($category, $categories) + (array_search($year, $mo_years) * count($categories))][$i]['product_name'] }}</span>
                                                                    <span class="text-sm leading-tight">Picked
                                                                        <span class="font-bold text-emerald-600">
                                                                            {{ $mtt_category[array_search($category, $categories) + (array_search($year, $mo_years) * count($categories))][$i]['total_count'] }}
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
                                                            <canvas id="total-trending-monthly-{{ $year }}-{{ $category['category_id'] }}"></canvas>
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
                                                                        @foreach ($mtt_category[array_search($category, $categories) + (array_search($year, $mo_years) * count($categories))] as $item)
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
                                                @else
                                                <h1 class="italic text-center text-4xl pt-36">No records found</h1>
                                                @endif
                                            </div>
                                            @endforeach
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
                            <div class="min-w-full min-h-full sm:max-w-md py-4">
                                @foreach ($an_years as $year)
                                <div x-show="isActive({{ array_search($year, $an_years) + 1 }})" x-transition:enter.duration.500ms>
                                    <div x-data="tabs">
                                        <div class="grid grid-cols-{{ count($categories) + 1 }} cursor-pointer font-bold">
                                            <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive(1) ? 'bg-white text-emerald-400': 'bg-emerald-400 text-white'" @click="setActive(1)">Overall</div>
                                            @foreach ($categories as $category)
                                            <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive({{ array_search($category, $categories) + 2 }}) ? 'bg-white text-emerald-400': 'bg-emerald-400 text-white'" @click="setActive({{ array_search($category, $categories) + 2 }})">{{ $category['category_name'] }}</div>
                                            @endforeach
                                        </div>
                                        <div class="min-w-full min-h-full sm:max-w-md py-4 px-6">
                                            <div x-show="isActive(1)" x-transition:enter.duration.500ms>
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div class="grid grid-cols-3 gap-3 mt-3 mb-3">
                                                        <div class="mx-auto max-w-full text-center text-gray-600 px-6 py-4 h-full">
                                                            <div class="flex flex-col">
                                                                <div class="max-w-[28px]">
                                                                    <div class="bg-yellow-400 rounded-full text-xl text-white font-bold">{{ array_search($yearly_top_trending[array_search($year, $an_years)][0], $yearly_top_trending[array_search($year, $an_years)]) + 1 }}</div>
                                                                </div>
                                                                <img src="{{ $yearly_top_trending[array_search($year, $an_years)][0]['image_path'] }}" class="max-w-[175px] mx-auto" />
                                                                <span class="text-lg leading-tight font-bold mb-1">{{ $yearly_top_trending[array_search($year, $an_years)][0]['product_name'] }}</span>
                                                                <span class="text-md leading-tight">Picked
                                                                    <span class="font-bold text-emerald-600">
                                                                        {{ $yearly_top_trending[array_search($year, $an_years)][0]['total_count'] }}
                                                                    </span>
                                                                    time(s) this month
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
                                                                    <span class="text-sm leading-tight">Picked
                                                                        <span class="font-bold text-emerald-600">
                                                                            {{ $yearly_top_trending[array_search($year, $an_years)][$i]['total_count'] }}
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
                                            @foreach ($categories as $category)
                                            <div x-show="isActive({{ array_search($category, $categories) + 2 }})" x-transition:enter.duration.500ms>
                                                @if ( !empty($ytt_category[array_search($category, $categories) + (array_search($year, $an_years) * count($categories))]) )
                                                <div class="grid grid-cols-2 gap-3">
                                                    <div class="grid grid-cols-3 gap-3 mt-3 mb-3">
                                                        <div class="mx-auto max-w-full text-center text-gray-600 px-6 py-4 h-full">
                                                            <div class="flex flex-col">
                                                                <div class="max-w-[28px]">
                                                                    <div class="bg-yellow-400 rounded-full text-xl text-white font-bold">{{ array_search($ytt_category[array_search($category, $categories) + (array_search($year, $an_years) * count($categories))][0], $ytt_category[array_search($category, $categories) + (array_search($year, $an_years) * count($categories))]) + 1 }}</div>
                                                                </div>
                                                                <img src="{{ $ytt_category[array_search($category, $categories) + (array_search($year, $an_years) * count($categories))][0]['image_path'] }}" class="max-w-[175px] mx-auto" />
                                                                <span class="text-lg leading-tight font-bold mb-1">{{ $ytt_category[array_search($category, $categories) + (array_search($year, $an_years) * count($categories))][0]['product_name'] }}</span>
                                                                <span class="text-md leading-tight">Picked
                                                                    <span class="font-bold text-emerald-600">
                                                                        {{ $ytt_category[array_search($category, $categories) + (array_search($year, $an_years) * count($categories))][0]['total_count'] }}
                                                                    </span>
                                                                    time(s) this month
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="grid grid-cols-2 col-span-2 gap-3">
                                                            @for ($i = 1; $i < count($ytt_category[array_search($category, $categories) + (array_search($year, $an_years) * count($categories))]); $i++) 
                                                            <div class="mx-auto w-full text-center text-gray-600 px-4 py-2">
                                                                <div class="flex flex-col">
                                                                    <div class="max-w-[20px]">
                                                                        <div class="@if ($i + 1 == 2) bg-gray-400 @elseif ($i + 1 == 3) bg-amber-700 @else bg-emerald-600 @endif rounded-full text-sm text-white font-bold">{{ array_search($ytt_category[array_search($category, $categories) + (array_search($year, $an_years) * count($categories))][$i], $ytt_category[array_search($category, $categories) + (array_search($year, $an_years) * count($categories))]) + 1 }}</div>
                                                                    </div>
                                                                    <img src="{{ $ytt_category[array_search($category, $categories) + (array_search($year, $an_years) * count($categories))][$i]['image_path'] }}" class="max-w-[100px] mx-auto" />
                                                                    <span class="text-md leading-tight font-bold mb-1">{{ $ytt_category[array_search($category, $categories) + (array_search($year, $an_years) * count($categories))][$i]['product_name'] }}</span>
                                                                    <span class="text-sm leading-tight">Picked
                                                                        <span class="font-bold text-emerald-600">
                                                                            {{ $ytt_category[array_search($category, $categories) + (array_search($year, $an_years) * count($categories))][$i]['total_count'] }}
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
                                                            <canvas id="total-trending-yearly-{{ $year }}-{{ $category['category_id'] }}"></canvas>
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
                                                                        @foreach ($ytt_category[array_search($category, $categories) + (array_search($year, $an_years) * count($categories))] as $item)
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
                                                @else
                                                <h1 class="italic text-center text-4xl pt-36">No records found</h1>
                                                @endif
                                            </div>
                                            @endforeach
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

        // monthly trending per category
        <?php
        for ($i = 0; $i < count($mo_years); $i++) {
            for ($j = 0; $j < count($categories); $j++) {
                if (!empty($mtt_category[(count($categories) * $i) + $j])) {
                    echo "var monthlyCategoryTrending" . (count($categories) * $i) + ($j + 1) . " = {
                        type: 'bar',
                        data: {
                            labels: ['Count'],
                            datasets: [";
                    for ($k = 0; $k < count($mtt_category[(count($categories) * $i) + $j]); $k++) {
                        echo "{
                                        label: '" . $mtt_category[(count($categories) * $i) + $j][$k]['product_name'] . "' ";
                        echo ",
                                        backgroundColor: '" . $colors[$k] . "',
                                        data: [" .
                            $mtt_category[(count($categories) * $i) + $j][$k]['total_count'] .
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
                    var ctx = document.getElementById('total-trending-monthly-" . $mo_years[$i] . "-" . $categories[$j]['category_id'] . "').getContext('2d');
                    new Chart(ctx, monthlyCategoryTrending" . (count($categories) * $i) + ($j + 1) . ");";
                }
            }
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

        // yearly trending per category
        <?php
        for ($i = 0; $i < count($an_years); $i++) {
            for ($j = 0; $j < count($categories); $j++) {
                if (!empty($ytt_category[(count($categories) * $i) + $j])) {
                    echo "var yearlyCategoryTrending" . (count($categories) * $i) + ($j + 1) . " = {
                        type: 'bar',
                        data: {
                            labels: ['Count'],
                            datasets: [";
                    for ($k = 0; $k < count($ytt_category[(count($categories) * $i) + $j]); $k++) {
                        echo "{
                                        label: '" . $ytt_category[(count($categories) * $i) + $j][$k]['product_name'] . "' ";
                        echo ",
                                        backgroundColor: '" . $colors[$k] . "',
                                        data: [" .
                            $ytt_category[(count($categories) * $i) + $j][$k]['total_count'] .
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
                    var ctx = document.getElementById('total-trending-yearly-" . $an_years[$i] . "-" . $categories[$j]['category_id'] . "').getContext('2d');
                    new Chart(ctx, yearlyCategoryTrending" . (count($categories) * $i) + ($j + 1) . ");";
                }
            }
        }
        ?>
    </script>
</div>