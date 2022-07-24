@extends('layouts.master')
@section('title')
    laravel shopping cart
@endsection
@include('layouts.flash-messages')
@section('content')
    @foreach ($products->chunk(4) as $productChunk)
        <div class="row">
            @foreach ($productChunk as $product)
                <div class="col-sm-6 col-md-4">
                    <div class="thumbnail">
                        <img src="{{ storage_path('images/' . $product->img_path) }}" alt="..." class="img-responsive">
                        <div class="caption">
                            <h3>{{ $product->item->description }}<span>${{ $product->item->sell_price }}</span></h3>
                            <p>{{ $product->item->description }}</p>
                            <div class="clearfix">
                                <a href="{{ route('product.addToCart', ['id' => $product->item_id]) }}"
                                    class="btn btn-primary" role="button"><i class="fas fa-cart-plus"></i> Add to Cart</a>
                                <a href="#" class="btn btn-default pull-right" role="button">
                                    <i class="fas fa-info"></i> More Info</a>
                            </div>
                        </div>
                    </div>
                </div>
        </div>
        </div>
        </div>
    @endforeach
    @endforeach
@endsection
