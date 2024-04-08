@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Create Product') }}</div>
                    <div class="card-body">
                        <form action="{{ route('store_product') }}" method="post" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label> <br>
                                <input class="form-control" type="text" name="name" id="name" placeholder="Name"> <br> 
                            </div>
                            
                            <div class="form-group">
                                <label for="description">Description</label> <br>
                                <input class="form-control" type="text" name="description" id="description" placeholder="Description"> <br>
                            </div>

                            <div class="form-group">
                                <label for="price">Price</label> <br>
                                <input class="form-control" type="number" name="price" id="price" placeholder="Price"> <br>
                            </div>

                            <div class="form-group">
                                <label for="stock">Stock</label> <br>
                                <input class="form-control" type="number" name="stock" id="stock" placeholder="Stock"> <br>
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label> <br>
                                <input class="form-control" type="file" name="image" id=""> <br>
                            </div>

                            <button type="submit" class="btn btn-primary mt-3">Submit</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection