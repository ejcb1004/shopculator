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

        .active {
            background-color: #d1fae5;
        }

        .completed {
            background-color: #bfdbfe;
        }

        .expired {
            background-color: #fef08a;
        }

        .sum {
            background-color: #d1d5db;
        }

        .active-sum {
            background-color: #6ee7b7;
            font-weight: bold;
        }

        .completed-sum {
            background-color: #60a5fa;
            font-weight: bold;
        }

        .expired-sum {
            background-color: #facc15;
            font-weight: bold;
        }

        .total {
            background-color: #374151;
            color: white;
            font-weight: bold;
        }
    </style>

    <div class="main-container">
        <h1 class="header">List Activity</h1>
        @if ( strpos($report, 'all-reports') !== false )
            @foreach ($years as $key => $year)
                <p class="date">{{ $year }}</p>
                @php
                $url = "https://quickchart.io/chart?version=3&w=365&h=170&c=" . urlencode($chart_config['monthly'][$key]);
                echo '<img src="data:image/png;base64, ' . base64_encode(file_get_contents($url)) . '">';
                @endphp
                <table class="list-table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th style="background-color:#4b5563">Month</th>
                            <th style="background-color:#059669">Active</th>
                            <th style="background-color:#2563eb">Completed</th>
                            <th style="background-color:#ca8a04">Expired</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($total_lists_monthly[array_search($year, $years)] as $item)
                        <tr>
                            <td>
                                {{ DateTime::createFromFormat('!m', $item['month'])->format('F') }}
                            </td>
                            <td class="active">
                                {{ $item['active_count'] }}
                            </td>
                            <td class="completed">
                                {{ $item['completed_count'] }}
                            </td>
                            <td class="expired">
                                {{ $item['expired_count'] }}
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td class="sum">Sum</td>
                            <td class="active-sum">{{ $active_list_sum['monthly'][$key] }}</td>
                            <td class="completed-sum">{{ $completed_list_sum['monthly'][$key] }}</td>
                            <td class="expired-sum">{{ $expired_list_sum['monthly'][$key] }}</td>
                        </tr>
                        <tr class="total">
                            <td>Total</td>
                            <td></td>
                            <td></td>
                            <td>
                                {{ $monthly_list_sum[$key] }}
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="page-break"></div>
            @endforeach
            <p class="date">Yearly</p>
            @php
            $url = "https://quickchart.io/chart?version=3&w=365&h=200&c=" . urlencode($chart_config['yearly']);
            echo '<img src="data:image/png;base64, ' . base64_encode(file_get_contents($url)) . '">';
            @endphp
            <table class="list-table">
                <!-- head -->
                <thead>
                    <tr>
                        <th style="background-color:#4b5563">Year</th>
                        <th style="background-color:#059669">Active</th>
                        <th style="background-color:#2563eb">Completed</th>
                        <th style="background-color:#ca8a04">Expired</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($total_lists_yearly as $item)
                    <tr>
                        <td>
                            {{ $item['year'] }}
                        </td>
                        <td class="active">
                            {{ $item['active_count'] }}
                        </td>
                        <td class="completed">
                            {{ $item['completed_count'] }}
                        </td>
                        <td class="expired">
                            {{ $item['expired_count'] }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="sum">Sum</td>
                        <td class="active-sum">{{ $active_list_sum['yearly'] }}</td>
                        <td class="completed-sum">{{ $completed_list_sum['yearly'] }}</td>
                        <td class="expired-sum">{{ $expired_list_sum['yearly'] }}</td>
                    </tr>
                    <tr class="total">
                        <td>Total</td>
                        <td></td>
                        <td></td>
                        <td style="text-align:end;">
                            {{ $yearly_list_sum }}
                        </td>
                    </tr>
                </tbody>
            </table>
        @elseif ( strpos($report, 'monthly') !== false )
            @foreach ($years as $key => $year)
                @if ( strpos($report, $year) !== false )
                    <p class="date">{{ $year }}</p>
                    @php
                    $url = "https://quickchart.io/chart?version=3&w=365&h=180&c=" . urlencode($chart_config['monthly'][$key]);
                    echo '<img src="data:image/png;base64, ' . base64_encode(file_get_contents($url)) . '">';
                    @endphp
                    <table class="list-table">
                        <!-- head -->
                        <thead>
                            <tr>
                                <th style="background-color:#4b5563">Month</th>
                                <th style="background-color:#059669">Active</th>
                                <th style="background-color:#2563eb">Completed</th>
                                <th style="background-color:#ca8a04">Expired</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($total_lists_monthly[array_search($year, $years)] as $item)
                            <tr>
                                <td>
                                    {{ DateTime::createFromFormat('!m', $item['month'])->format('F') }}
                                </td>
                                <td class="active">
                                    {{ $item['active_count'] }}
                                </td>
                                <td class="completed">
                                    {{ $item['completed_count'] }}
                                </td>
                                <td class="expired">
                                    {{ $item['expired_count'] }}
                                </td>
                            </tr>
                            @endforeach
                            <tr>
                                <td class="sum">Sum</td>
                                <td class="active-sum">{{ $active_list_sum['monthly'][$key] }}</td>
                                <td class="completed-sum">{{ $completed_list_sum['monthly'][$key] }}</td>
                                <td class="expired-sum">{{ $expired_list_sum['monthly'][$key] }}</td>
                            </tr>
                            <tr class="total">
                                <td>Total</td>
                                <td></td>
                                <td></td>
                                <td>
                                    {{ $monthly_list_sum[$key] }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                @endif
            @endforeach
        @elseif ( strpos($report, 'yearly') !== false )
            <p class="date">Yearly</p>
            @php
            $url = "https://quickchart.io/chart?version=3&w=365&h=200&c=" . urlencode($chart_config['yearly']);
            echo '<img src="data:image/png;base64, ' . base64_encode(file_get_contents($url)) . '">';
            @endphp
            <table class="list-table">
                <!-- head -->
                <thead>
                    <tr>
                        <th style="background-color:#4b5563">Year</th>
                        <th style="background-color:#059669">Active</th>
                        <th style="background-color:#2563eb">Completed</th>
                        <th style="background-color:#ca8a04">Expired</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($total_lists_yearly as $item)
                    <tr>
                        <td>
                            {{ $item['year'] }}
                        </td>
                        <td class="active">
                            {{ $item['active_count'] }}
                        </td>
                        <td class="completed">
                            {{ $item['completed_count'] }}
                        </td>
                        <td class="expired">
                            {{ $item['expired_count'] }}
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="sum">Sum</td>
                        <td class="active-sum">{{ $active_list_sum['yearly'] }}</td>
                        <td class="completed-sum">{{ $completed_list_sum['yearly'] }}</td>
                        <td class="expired-sum">{{ $expired_list_sum['yearly'] }}</td>
                    </tr>
                    <tr class="total">
                        <td>Total</td>
                        <td></td>
                        <td></td>
                        <td style="text-align:end;">
                            {{ $yearly_list_sum }}
                        </td>
                    </tr>
                </tbody>
            </table>
        @endif
    </div>
</div>
