<div>
    <style>
        * {
            font-family: Lato, sans-serif;
        }

        a {
            text-decoration: none;
            color: white;
        }

        .date {
            text-align: center;
            font-size: small;
        }

        .header {
            font-size: x-large;
            text-align: center;
        }
        
        .sub-header {
            font-size: medium;
            text-align: center;
        }

        .list-table {
            border-collapse: collapse;
            width: 100%;
        }

        .list-table tr:nth-child(even) {
            background: #d1fae5
        }

        .summary-table {
            border-collapse: collapse;
            width: 35%;
            background-color: #e5e7eb;
            margin-left: auto;
            margin-right: auto;
        }

        .summary-table th {
            background-color: #059669;
            color: white;
            font-size: small;
            text-transform: uppercase;
        }

        .main-container {
            width: 100%;
            height: 90%;
        }

        .list-table td,
        .list-table th,
        .summary-table td,
        .summary-table th {
            border: 2px white solid;
            padding: 6px;
        }

        .no-items {
            color: silver;
            text-align: center;
            font-style: italic;
            font-size: medium;
        }

        .list-table th {
            background-color: #059669;
            color: white;
            font-size: small;
            text-transform: uppercase;
        }

        .sc-btn-primary {
            display: block;
            margin: auto;
            padding: 0.25rem 1rem;
            width: 4rem;
            background-color: #059669;
            color: white;
            border: none;
            border-radius: 9999px;
            transition-property: color, background-color, border-color, text-decoration-color, fill, stroke, opacity, box-shadow, transform, filter, backdrop-filter;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 300ms;
        }

        .sc-btn-primary a {
            width: 100%;
            height: 100%;
        }

        footer {
            text-align: center;
            color: silver;
            font-size: small;
            position: absolute;
            bottom: 0;
            right: 0;
            left: 0;
        }

        .page-break {
            page-break-after: always;
        }
    </style>

    <div class="main-container">
        <h1 class="header">Trending Products</h1>
        @if ( strpos($report, 'all-reports') !== false )
            @foreach ($years as $key => $year)
                <!-- Monthly Trending Overall -->
                <h2 class="sub-header">Monthly Trending {{ '(' . date('F') . ' ' . $year . ')' }}</h2>
                <p class="date">Overall</p>
                @php
                $url = "https://quickchart.io/chart?version=3&w=365&h=250&c=" . urlencode($chart_config[$key]['yt']);
                echo '<img src="data:image/png;base64, ' . base64_encode(file_get_contents($url)) . '">';
                @endphp
                <table class="list-table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($monthly_top_trending[array_search($year, $years)] as $item)
                        <tr>
                            <td>
                                {{ $item['product_name'] }}
                            </td>
                            <td>
                                {{ $item['total_count'] }}
                            </td>
                        </tr>
                        @empty
                        <p class="sub-header">No results</p>
                        @endforelse
                    </tbody>
                </table>
                <div class="page-break"></div>
                <!-- Monthly Trending Categories -->
                @foreach ($categories as $ctg_key => $category)
                    <h2 class="sub-header">Monthly Trending {{ '(' . date('F') . ' ' . $year . ')' }}</h2>
                    <p class="date">{{ $category['category_name'] }}</p>
                    @if ( array_key_exists($ctg_key, $chart_config[$key]['mtpc']) )
                    @php
                    $url = "https://quickchart.io/chart?version=3&w=365&h=250&c=" . urlencode($chart_config[$key]['mtpc'][$ctg_key]);
                    echo '<img src="data:image/png;base64, ' . base64_encode(file_get_contents($url)) . '">';
                    @endphp
                    <table class="list-table">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($mtt_category[array_search($category, $categories) + (array_search($year, $years) * count($categories))] as $item)
                            <tr>
                                <td>
                                    {{ $item['product_name'] }}
                                </td>
                                <td>
                                    {{ $item['total_count'] }}
                                </td>
                            </tr>
                            @empty
                            <p class="sub-header">No results</p>
                            @endforelse
                        </tbody>
                    </table>
                    @else
                    <p class="sub-header">No results</p>
                    @endif
                    @if (!($key == array_key_last($years) && $ctg_key == array_key_last($categories)))
                    <div class="page-break"></div>
                    @endif
                @endforeach
            @endforeach
            <div class="page-break"></div>
            @foreach ($years as $key => $year)
                <!-- Yearly Trending Overall -->
                <h2 class="sub-header">Yearly Trending {{ '(' . $year . ')' }}</h2>
                <p class="date">Overall</p>
                @php
                $url = "https://quickchart.io/chart?version=3&w=365&h=250&c=" . urlencode($chart_config[$key]['yt']);
                echo '<img src="data:image/png;base64, ' . base64_encode(file_get_contents($url)) . '">';
                @endphp
                <table class="list-table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>Count</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($yearly_top_trending[array_search($year, $years)] as $item)
                        <tr>
                            <td>
                                {{ $item['product_name'] }}
                            </td>
                            <td>
                                {{ $item['total_count'] }}
                            </td>
                        </tr>
                        @empty
                        <p class="sub-header">No results</p>
                        @endforelse
                    </tbody>
                </table>
                <div class="page-break"></div>
                <!-- Yearly Trending Categories -->
                @foreach ($categories as $ctg_key => $category)
                    <h2 class="sub-header">Yearly Trending {{ '(' . $year . ')' }}</h2>
                    <p class="date">{{ $category['category_name'] }}</p>
                    @if ( array_key_exists($ctg_key, $chart_config[$key]['ytpc']) )
                    @php
                    $url = "https://quickchart.io/chart?version=3&w=365&h=250&c=" . urlencode($chart_config[$key]['ytpc'][$ctg_key]);
                    echo '<img src="data:image/png;base64, ' . base64_encode(file_get_contents($url)) . '">';
                    @endphp
                    <table class="list-table">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Count</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ytt_category[array_search($category, $categories) + (array_search($year, $years) * count($categories))] as $item)
                            <tr>
                                <td>
                                    {{ $item['product_name'] }}
                                </td>
                                <td>
                                    {{ $item['total_count'] }}
                                </td>
                            </tr>
                            @empty
                            <p class="sub-header">No results</p>
                            @endforelse
                        </tbody>
                    </table>
                    @else
                    <p class="sub-header">No results</p>
                    @endif
                    @if (!($key == array_key_last($years) && $ctg_key == array_key_last($categories)))
                    <div class="page-break"></div>
                    @endif
                @endforeach
            @endforeach
        @elseif (strpos($report, 'monthly') !== false)
            @if (strpos($report, 'overall') !== false)
                @foreach ($years as $key => $year)
                    @if (strpos($report, $year) !== false)
                        <h2 class="sub-header">Monthly Trending {{ '(' . date('F') . ' ' . $year . ')' }}</h2>
                        <p class="date">Overall</p>
                        @php
                        $url = "https://quickchart.io/chart?version=3&w=365&h=250&c=" . urlencode($chart_config[$key]['mt']);
                        echo '<img src="data:image/png;base64, ' . base64_encode(file_get_contents($url)) . '">';
                        @endphp
                        <table class="list-table">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($monthly_top_trending[array_search($year, $years)] as $item)
                                <tr>
                                    <td>
                                        {{ $item['product_name'] }}
                                    </td>
                                    <td>
                                        {{ $item['total_count'] }}
                                    </td>
                                </tr>
                                @empty
                                <p class="sub-header">No results</p>
                                @endforelse
                            </tbody>
                        </table>
                    @endif
                @endforeach
            @else
                @foreach ($years as $key => $year)
                    @foreach ($categories as $ctg_key => $category)
                        @if (strpos($report, $year) !== false && strpos($report, $category['category_id']) !== false)
                        <h2 class="sub-header">Monthly Trending {{ '(' . date('F') . ' ' . $year . ')' }}</h2>
                        <p class="date">{{ $category['category_name'] }}</p>
                        @php
                        $url = "https://quickchart.io/chart?version=3&w=365&h=250&c=" . urlencode($chart_config[$key]['mtpc'][$ctg_key]);
                        echo '<img src="data:image/png;base64, ' . base64_encode(file_get_contents($url)) . '">';
                        @endphp
                        <table class="list-table">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($mtt_category[array_search($category, $categories) + (array_search($year, $years) * count($categories))] as $item)
                                <tr>
                                    <td>
                                        {{ $item['product_name'] }}
                                    </td>
                                    <td>
                                        {{ $item['total_count'] }}
                                    </td>
                                </tr>
                                @empty
                                <p class="sub-header">No results</p>
                                @endforelse
                            </tbody>
                        </table>
                        @endif
                    @endforeach
                @endforeach
            @endif
        @elseif (strpos($report, 'yearly') !== false)
            @if (strpos($report, 'overall') !== false)
                @foreach ($years as $key => $year)
                    @if (strpos($report, $year) !== false)
                        <h2 class="sub-header">Yearly Trending {{ '(' . $year . ')' }}</h2>
                        <p class="date">Overall</p>
                        @php
                        $url = "https://quickchart.io/chart?version=3&w=365&h=250&c=" . urlencode($chart_config[$key]['yt']);
                        echo '<img src="data:image/png;base64, ' . base64_encode(file_get_contents($url)) . '">';
                        @endphp
                        <table class="list-table">
                            <!-- head -->
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($yearly_top_trending[array_search($year, $years)] as $item)
                                <tr>
                                    <td>
                                        {{ $item['product_name'] }}
                                    </td>
                                    <td>
                                        {{ $item['total_count'] }}
                                    </td>
                                </tr>
                                @empty
                                <p class="sub-header">No results</p>
                                @endforelse
                            </tbody>
                        </table>
                    @endif
                @endforeach
            @else
                @foreach ($years as $key => $year)
                    @foreach ($categories as $ctg_key => $category)
                        @if (strpos($report, $year) !== false && strpos($report, $category['category_id']) !== false)
                            <h2 class="sub-header">Yearly Trending {{ '(' . $year . ')' }}</h2>
                            <p class="date">{{ $category['category_name'] }}</p>
                            @php
                            $url = "https://quickchart.io/chart?version=3&w=365&h=250&c=" . urlencode($chart_config[$key]['ytpc'][$ctg_key]);
                            echo '<img src="data:image/png;base64, ' . base64_encode(file_get_contents($url)) . '">';
                            @endphp
                            <table class="list-table">
                                <!-- head -->
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th>Count</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($ytt_category[array_search($category, $categories) + (array_search($year, $years) * count($categories))] as $item)
                                    <tr>
                                        <td>
                                            {{ $item['product_name'] }}
                                        </td>
                                        <td>
                                            {{ $item['total_count'] }}
                                        </td>
                                    </tr>
                                    @empty
                                    <p class="sub-header">No results</p>
                                    @endforelse
                                </tbody>
                            </table>
                        @endif
                    @endforeach
                @endforeach
            @endif
        @endif
    </div>
</div>