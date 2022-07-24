@extends('layouts.master')
@section('title')
    item
@endsection
@section('content')
    <div class="container">
        <br />
        @include('layouts.flash-messages')
        <div class="col-xs-6">
            <form method="post" enctype="multipart/form-data" action="{{ url('/import') }}">
                {{ csrf_field() }}
                <input type="file" id="uploadName" name="item_upload" required>
                <button type="submit" class="btn btn-info btn-primary ">Import Excel File</button>
            </form>
            {{ link_to_route('item.export', 'Export to Excel') }}
        </div>
    </div>
    <tr>{{ link_to_route('item.create', 'Add new item:') }}</tr>
    <div class="container">
        <table class="table table-striped" id="item-table">
            <thead>
                <tr>
                    <th>Item ID</th>
                    <th>Name</th>
                    <th>Selling Price</th>
                    <th>Cost Price</th>
                </tr>
            </thead>
        </table>
    @endsection
    @section('scripts')
        <script>
            $(document).ready(function() {
                $('#item-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: '{!! route('item.getItem') !!}',
                    columns: [{
                            data: 'item_id',
                            name: 'item_id'
                        },
                        {
                            data: 'description',
                            name: 'item.description'
                        },
                        {
                            data: 'cost_price',
                            name: 'item.cost_price'
                        },
                        {
                            data: 'sell_price',
                            name: 'item.sell_price'
                        }
                    ]
                });
            });
        </script>
    @endsection
    {{-- @foreach ($items as $item)
      <tr>
        <td>{{$item->item_id}}</td>
        <td>{{$item->description}}</td>
        <td>{{$item->cost_price}}</td>
        <td>{{$item->sell_price}}</td>
        <td><a href = "{{ route('item.show', $item->item_id ) }}"  class="btn btn-warning">show</a></td>
        <td>
        <td><a href="{{ action('ItemController@edit', $item->item_id)}}" class="btn btn-warning">Edit</a></td>
        <td>
          <form action="{{ action('ItemController@destroy', $item->item_id)}}" method="post">
           {{ csrf_field() }}
            <input name="_method" type="hidden" value="DELETE">
            <button class="btn btn-danger" type="submit">Delete</button>
          </form>
        </td>
      </tr>
      @endforeach 
        </div>
 <div class="container"> {{ $items->links() }}
  </div> --}}
