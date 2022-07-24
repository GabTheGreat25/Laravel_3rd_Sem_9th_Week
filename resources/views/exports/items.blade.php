{{-- <h1>List of Items</h1> --}}
<table>
    <thead>
        <tr>
            <th>Item ID</th>
            <th>Name</th>
            <th>Selling Price</th>
            <th>Cost Price</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($items as $item)
            <tr>
                <td>{{ $item->item_id }}</td>
                <td>{{ $item->description }}</td>
                <td>{{ $item->cost_price }}</td>
                <td>{{ $item->sell_price }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
