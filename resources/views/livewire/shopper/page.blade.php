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

        .list-name {
            font-size: x-large;
            text-align: center;
        }

        .list-table {
            border-collapse: collapse;
            width: 100%;
            background-color: #e5e7eb;
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
    </style>
    
    <div class="main-container">
        <p class="list-name">{{ $list_name }}</p>
        <p class="date">
            @php
            $dt = new DateTime($created_at);
            $dt->setTimezone(new DateTimeZone('Asia/Manila'));
            echo $dt->format('M d, Y - h:i:s A');
            @endphp
        </p>
        @if ($data->isEmpty())
        <p class="no-items">Your list seems to be empty. Please check your items here:</p>
        <button type="button" class="sc-btn-primary">
            <a href="{{ url('shopper/edit/' . $list_id) }}">Edit</a>
        </button>
        @else
        <table class="list-table">
            <!-- head -->
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Base Price</th>
                    <th>Quantity</th>
                    <th>Net Price</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($data as $detail)
                @if ($detail->is_checked == 1)
                <tr>
                    <td style="background-color:#bbf7d0">{{ $detail->product_name }}</td>
                    <td style="background-color:#bbf7d0; text-align: center;">PHP {{ $detail->current_price }}</td>
                    <td style="background-color:#bbf7d0; text-align: center;">×{{ $detail->quantity }}</td>
                    <td style="background-color:#bbf7d0; text-align: center;">PHP {{ number_format($detail->current_price * $detail->quantity, 2) }}</td>
                </tr>
                @else
                <tr>
                    <td style="background-color:#fecaca;">{{ $detail->product_name }}</td>
                    <td style="background-color:#fecaca; text-align: center;">PHP {{ $detail->current_price }}</td>
                    <td style="background-color:#fecaca; text-align: center;">×{{ $detail->quantity }}</td>
                    <td style="background-color:#fecaca; text-align: center;">PHP {{ number_format($detail->current_price * $detail->quantity, 2) }}</td>
                </tr>
                @endif
                @endforeach
            </tbody>
        </table>
        <br>
        <table class="summary-table">
            <thead>
                <tr>
                    <th colspan="2">Summary</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Budget</td>
                    <td style="text-align: center">PHP {{ number_format($budget, 2, '.', ',') }}</td>
                </tr>
                <tr>
                    <td>Total</td>
                    <td style="text-align: center">PHP {{ $total }}</td>
                </tr>
                <tr>
                    <td>Remaining</td>
                    <td style="text-align: center">PHP {{ number_format($budget - $total, 2, '.', ',') }}</td>
                </tr>
            </tbody>
        </table>
        @endif
        <footer>Shopculator © {{ date("Y") }} Team W. All rights reserved.</footer>
    </div>
</div>