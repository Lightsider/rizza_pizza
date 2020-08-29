@extends('layouts.app', ['activePage' => 'cart', 'title' => __('Cart'),'titlePage' => __('Cart')])

@section('content')
    <div class="col-md-12 text-center mt-3">
        <div class="card mb-0">
            <div class="card-header card-header-warning">
                <h4 class="card-title">Your cart</h4>
            </div>
            <div class="row justify-content-center pt-3">
                <div class="col-md-10 text-center mt-3 mb-3">
                    @if(!empty($cart->items()) && count($cart->items()) > 0)
                        <table class="table table-hover">
                            <thead class="text-warning">
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Cost</th>
                                <th>Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($cart->items() as $key => $item)
                                <tr id="product{{$item->product->id}}">
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->product->title }}</td>
                                    <td>{!! $item->product->description  !!}</td>
                                    <td>{{ $cart->cost($item->product->cost) }} {{ $cart->currency() }}</td>
                                    <td> <remove_from_cart_icon-component link="{{ route('removeCart',["product_id" => $item->product->id]) }}"></remove_from_cart_icon-component><cart_item_count-component :id="{{$item->product->id}}" :count="{{ $item->quantity }}"></cart_item_count-component><add_to_cart_icon-component link="{{ route('addCart',["product_id" => $item->product->id]) }}"></add_to_cart_icon-component></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <h3>Total price: <cart_total-component :total="{{$cart->total()}}" :currency="'{{$cart->currency()}}'"></cart_total-component></h3>

                        <a href="{{ route('formOrder') }}" class="btn btn-success" >Form an order</a>

                    @else
                        <h3>You cart is empty</h3>

                        <a href="{{ route('index') }}" class="btn btn-primary">Return to menu</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/app.js') }}"></script>
@endpush