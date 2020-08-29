@extends('layouts.app', ['activePage' => 'cart', 'title' => __('Cart'),'titlePage' => __('Cart')])

@section('content')
    <div class="col-md-12 text-center mt-3">
        <div class="card mb-0">
            <div class="card-header card-header-success">
                <h4 class="card-title">Thanks for you order!</h4>
            </div>
            <div class="row justify-content-center pt-3">
                <div class="col-md-10 text-center mt-3 mb-3">
                        <h3>Your order number #{{session()->get('order_id')}}</h3>
                        <p>Your order has been received and will soon be processed</p>
                        <a href="{{ route('index') }}" class="btn btn-primary">Return to menu</a>
                </div>
            </div>
        </div>
    </div>
@endsection