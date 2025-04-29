@extends('layouts.frontlayout')
@section('title', 'Event Organizer Login')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center header-bg">
                    <h3>Welcome Back</h3>
                    <p>Please sign in to your account</p>
                </div>
                <div class="card-body">
                    @error('error')
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ $message }}
                            
                        </div>
                    @enderror
                    <form action="{{ route('eventorganizer.login.post') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username">
                            @error('username')
                                <div class="alert alert-danger mt-3 text-center">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="password">Password</label>
                            <input type="password" name="password" id="password" class="form-control" placeholder="********">
                            @error('password')
                                <div class="alert alert-danger mt-3 text-center">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary w-100">Sign In</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('eventorganizer.register') }}">Don't have an event organizer account? Register here</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection