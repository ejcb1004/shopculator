<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping List</title>
</head>

<body>
    <table class="table w-full">
        <!-- head -->
        <thead class="text-white">
            <tr>
                <th>List Name</th>
                <th>------</th>
                <th>Total</th>
                <th>------</th>
                <th>Budget</th>
                <th>------</th>
                <th>Updated at</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($data as $shoppinglist)
            <tr class="hover table-group">
                <td class="table-item">{{ $shoppinglist->list_name }}</td>
                <td></td>
                <td class="table-item">{{ $shoppinglist->total }}</td>
                <td></td>
                <td class="table-item">{{ $shoppinglist->budget }}</td>
                <td></td>
                <td class="table-item">{{ $shoppinglist->updated_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>