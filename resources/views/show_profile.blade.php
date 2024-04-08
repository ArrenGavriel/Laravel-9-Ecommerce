@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <a href="{{ route('index_product') }}">Back to Index Product</a> <br>
                <div class="card">
                    <div class="card-header">{{ __('Profile') }}</div>

                    <div class="card-body">
                        @if($errors->any())
                            @foreach($errors->all() as $error)
                                <p>{{ $error }}</p>
                            @endforeach
                        @endif

                        <p>Name: {{ $user->name }}</p>
                        <p>Email: {{ $user->email }}</p>
                        <p>Role: {{ $user->is_admin ? 'Admin' : 'Member' }}</p>

                        <form action="{{ route('edit_profile') }}" method="post">
                            @csrf
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input placeholder="Name" class="form-control" type="text" name="name" id="name" value="{{ $user->name }}">
                            </div>
                            
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input placeholder="Name" class="form-control" type="password" name="password" id="password">
                            </div>

                            <div class="form-group">
                                <label for="password_confirmation">Confirm Password</label>
                                <input placeholder="Name" class="form-control" type="password" name="password_confirmation" id="password_confirmation">
                            </div>
                            
                            <button class="btn btn-primary mt-3" type="submit">Change Profile Details</button>
                        </form>

                        
                    
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection