@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">

                <div class="card">
                    <div class="card-header">
                        {{ __('Cart') }}
                        <a href="{{ route('index_product') }}">Back to Product Index</a> <br>
                    </div>
                    
                    <div class="card-body">
                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        @endif
                    </div>

                    @php
                        $total_price = 0;
                    @endphp

                    <div class="card-group m-0">
                        @foreach($carts as $cart)
                            <div class="card m-3" style="width: 17rem;">
                                <img class="card-img-top" src="{{ url('storage/' . $cart->product->image) }}" 
                                    alt="">

                                <div class="card-body">
                                    <h5 class="card-title">{{ $cart->product->name }}</h5>
                                    <form action="{{ route('update_cart', $cart) }}" method="post">
                                        @method('patch')
                                        @csrf
                                        <div class="input-group mb-3"> 
                                            <input class="form-control" aria-describedby="basic-addon2" 
                                            type="number" name="amount" id="" value="{{ $cart->amount }}">

                                            <div class="input-group-append">
                                                <button class="btn btn-outine-secondary" 
                                                type="submit">Update Amount

                                                </button>
                                            </div>
                                        </div>
                                    </form>

                                    <form action="{{ route('delete_cart', $cart) }}" method="post">
                                        @method('delete')
                                        @csrf
                                        <button class="btn btn-danger" type="submit">Delete</button>
                                    </form>
                                </div>
                            </div>

                            @php
                                $total_price += $cart->product->price * $cart->amount;
                            @endphp
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-end">
                        <p class="d-flex flex-column justify-content-end align-items-end"
                            >Rp {{ $total_price }}</p> <br>
                        <form action="{{ route('checkout') }}" method="post">
                            @csrf
                            <button type="submit" class="btn btn-primary me-2 mb-2" @if($carts->isEmpty() )
                                disabled @endif>Checkout</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection