@extends('layouts.frontlayout')
@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center header-bg" style="background: linear-gradient(to right, #4a90e2, #4c6ef5); color: white;">
                    <h3><i class="fas fa-user-plus"></i> User Registration</h3>
                    <p>Please Register to create your account</p>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.register') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <div class="input-group">
                                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your name">
                            </div>
                            @error('name')
                                <div class="alert alert-danger mt-3 text-center">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <div class="input-group">
                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter your username">
                            </div>
                            @error('username')
                                <div class="alert alert-danger mt-3 text-center">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <div class="input-group">
                                <input type="email" name="email" id="email" class="form-control" placeholder="you@example.com">
                            </div>
                            @error('email')
                                <div class="alert alert-danger mt-3 text-center">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="password">Password</label>
                            <div class="input-group">
                                <input type="password" name="password" id="password" class="form-control" placeholder="********">
                            </div>
                            @error('password')
                                <div class="alert alert-danger mt-3 text-center">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <label for="password_confirmation">Confirm Password</label>
                            <div class="input-group">
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="********">
                            </div>
                            @error('password_confirmation')
                                <div class="alert alert-danger mt-3 text-center">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="form-group mt-3">
                            <button type="submit" class="btn btn-primary w-100">Register</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <a href="{{ route('user.login') }}">Already have an account? Login here</a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection