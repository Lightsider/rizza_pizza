@extends('layouts.app', ['activePage' => 'index', 'title' => __('Menu'),'titlePage' => __('Rizza Pizza')])

@section('content')
    <div class="col-md-12 text-center mt-3">
        <div class="card mb-3">
            <div class="card-header card-header-primary">
                <h4 class="card-title">My Rizza</h4>
                <p class="card-category">it's my dog :)</p>
            </div>
            <div class="row justify-content-center pt-3 mb-5">
                <div class="col-md-3" style="background-image: url('/img/rizza.jpg');background-size: 200% 125%;background-position: 45%;height: 300px; border-radius: 100%" title="it's my dog - Rizza:)"></div>
            </div>
            <br>
            <h2> And our Pizza </h2>
            <div class="row justify-content-center pt-3">
                @foreach($products as $product)
                    <div class="col-md-3 text-center mb-3">
                        <div class="card" style="width: 15rem; margin-left: auto;margin-right: auto;height:90%">
                            <img class="card-img-top" style="height: 150px; width: auto;"
                                 src="{{ asset("/img/".$product->image) }}">
                            <div class="card-body">
                                <h5 class="card-title text-dark">{{ $product->title }}</h5>
                                <p class="card-text">{!! $product->description !!}</p>
                                <h5 class="card-title">{{ $cart->cost($product->cost) }} {{$cart->currency()}}</h5>
                                <add_to_cart-component link="{{ route('addCart',["product_id" => $product->id]) }}"></add_to_cart-component>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/app.js') }}"></script>
@endpush
