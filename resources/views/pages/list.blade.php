<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping List</title>
</head>

<body>
    <table class="table w-full text-base">
        <!-- head -->
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
        </tbody>
    </table>
</body>

</html>