@extends('layouts.master')
@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <h1>user profile {{ Auth::user()->name }}</h1>
            <hr>
            <h2>My Orders</h2>
            {{-- {{dd($orders)}} --}}
            @foreach ($orders as $order)
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h2>Order {{ $order->orderinfo_id }}</h2>
                        <ul class="list-group">
                            {{-- dd($order->items) --}}
                            @php
                                $total = 0;
                            @endphp
                            @foreach ($order->items as $item)
                                <li class="list-group-item">
                                    <span class="badge">{{ $item['sell_price'] }} $</span>
                                    {{ $item['description'] }} | {{ $item->pivot['quantity'] }} Units
                                </li>
                                @php
                                    $total += $item['sell_price'] * $item->pivot['quantity'];
                                @endphp
                            @endforeach
                        </ul>
                    </div>
                    <div class="panel-footer">
                        <strong>Total Price: ${{ $total }}{{-- $order->cart->totalPrice --}} </strong>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
