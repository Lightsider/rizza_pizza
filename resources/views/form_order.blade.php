@extends('layouts.app', ['activePage' => 'cart', 'title' => __('Order'),'titlePage' => __('Order')])

@section('content')
    <div class="col-md-12 text-center mt-3">
        <div class="card mb-0">
            <div class="card-header card-header-success">
                <h4 class="card-title">Your order</h4>
            </div>
            <div class="row justify-content-center pt-3">
                <div class="col-md-10 text-center mt-3 mb-3">
                    @if(!empty($cart->items()) && $cart->count() > 0)
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
                                    <td>
                                        <cart_item_count-component :id="{{$item->product->id}}"
                                                                   :count="{{ $item->quantity }}"></cart_item_count-component>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <h3>Cart price:
                            <cart_total-component :total="{{$cart->total()}}" :currency="'{{$cart->currency()}}'"></cart_total-component>
                </div>
            </div>
        </div>
        <form method="post" action="{{ route('saveOrder') }}" class="form-horizontal">
            @csrf
            <div class="card ">
                <div class="card-header card-header-primary">
                    <h4 class="card-title">{{ __('Your information') }}</h4>
                    <p class="card-category">{{ __('User information') }}</p>
                </div>
                <div class="card-body ">
                    @if (session('status'))
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="alert alert-success">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <i class="material-icons">close</i>
                                    </button>
                                    <span>{{ session('status') }}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <label class="col-sm-2 col-form-label">{{ __('Address') }} <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('address') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}"
                                       name="address" id="input-address" type="text" placeholder="{{ __('Address') }}"
                                       value="{{ old('address', '') }}" required="true" aria-required="true"/>
                                @if ($errors->has('address'))
                                    <span id="address-error" class="error text-danger"
                                          for="input-address">{{ $errors->first('address') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">{{ __('Fullname') }} <span class="text-danger">*</span></label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('fullname') ? ' has-danger' : '' }}">
                                <input class="form-control{{ $errors->has('fullname') ? ' is-invalid' : '' }}"
                                       name="fullname" id="input-fullname" type="text"
                                       placeholder="{{ __('Fullname') }}" value="{{ old('fullname', '') }}" required/>
                                @if ($errors->has('fullname'))
                                    <span id="fullname-error" class="error text-danger"
                                          for="input-fullname">{{ $errors->first('fullname') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <label class="col-sm-2 col-form-label">{{ __('Additional info') }}</label>
                        <div class="col-sm-7">
                            <div class="form-group{{ $errors->has('additional_information') ? ' has-danger' : '' }}">
                                <textarea class="form-control{{ $errors->has('additional_information') ? ' is-invalid' : '' }}"
                                       name="additional_information" id="input-additional_information"
                                          placeholder="{{ __('Additional info') }}" >{{ old('additional_information', '') }}</textarea>
                                @if ($errors->has('additional_information'))
                                    <span id="additional_information-error" class="error text-danger"
                                          for="input-additional_information">{{ $errors->first('additional_information') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <h4> Delivery cost: {{$cart->cost($cart->delivery())}} {{$cart->currency()}}</h4>
                <h3>Total price:
                    <cart_total-component :total="{{$cart->total(true)}}"
                                          :currency="'{{$cart->currency()}}'"></cart_total-component>
                </h3>
                <div class="card-footer ml-auto mr-auto">
                    <button type="submit" class="btn btn-primary">{{ __('Send order') }}</button>
                </div>
            </div>
        </form>
        @else
            <script>
                window.location = "/";
            </script>
        @endif
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/app.js') }}"></script>
@endpush