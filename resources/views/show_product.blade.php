@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{ route('index_product') }}">Back to Index Product</a> <br>
                <div class="card">
                    <div class="card-header">{{ __('Product Detail') }}</div>

                    <div class="card-body">
                        <div class="d-flex justify-content-around">
                            <div class="">
                                <img src="{{ url('storage/' . $product->image) }}" alt="" height="200px">
                            </div>
                            <div class="">                                    
                                <h1>{{ $product->name }}</h1>
                                <h6>{{ $product->description }}</h6>
                                <h3>Rp{{ $product->price }}</h3>
                                <hr>
                                <p>{{ $product->stock }} left</p>
                                @if(!Auth::user()->is_admin)
                                    <form action="{{ route('add_to_cart', $product) }}" method="post">
                                        @csrf
                                        <div class="input-group mb-3">
                                            <input type="number" class="form-control" aria-describedby="basic-addon2" name="amount" id="" value=1>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary" type="submit">Add to Cart</button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <form action="{{ route('edit_product', $product) }}" method="get">
                                        <button class="btn btn-primary" type="submit">Edit Product</button>
                                    </form>
                                @endif  
                                
                            </div>
                        </div>

                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        @endif          
                    
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection