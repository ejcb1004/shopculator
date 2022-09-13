<div>
    <table class="table w-full text-base">
        <!-- head -->
        <tr class="hover table-group">
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td class="table-item">{{ $created_at }}</td>
        </tr>
        <thead class="text-white">
            <tr>
                <th>No.</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Base Price</th>
                <th>Net Price</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $detail)
            <tr class="hover table-group">
                <td class="table-item">{{ $detail->list_index + 1 }}</td>
                <td class="table-item">{{ $detail->product_name }}</td>
                <td class="table-item">PHP {{ $detail->price }}</td>
                <td class="table-item">x {{ $detail->quantity }}</td>
                <td class="table-item">PHP {{ number_format($detail->price * $detail->quantity, 2) }}</td>
            </tr>
            @endforeach
            <tr class="hover table-group">
            </tr>
            <tr class="hover table-group">
                <td></td>
                <td></td>
                <td></td>
                <td class="table-item">Budget =</td>
                <td class="table-item">PHP {{ $budget }}</td>
            </tr>
            <tr class="hover table-group">
                <td></td>
                <td></td>
                <td></td>
                <td class="table-item">Total =</td>
                <td class="table-item">PHP {{ $total }}</td>
            </tr>
            <tr class="hover table-group">
                <td></td>
                <td></td>
                <td></td>
                <td class="table-item">Remaining =</td>
                <td class="table-item">PHP {{ number_format($budget - $total, 2, '.', ',') }}</td>
            </tr>
        </tbody>
    </table>
</div>