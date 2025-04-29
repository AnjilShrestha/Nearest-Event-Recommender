@extends('layouts.frontlayout')
@section('title', 'Login')
@section('content')
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            background-color: #f0f4ff;
        }
        .card {
            border-radius: 10px;
        }
        .header-bg {
            background: linear-gradient(to right, #4a90e2, #4c6ef5);
            color: white;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>

    @include('toast.message')
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
                            <div class="alert alert-danger mt-3 text-center">
                                {{ $message }}
                            </div>
                        @enderror
                        <form action="{{ route('user.login.post') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" name="email" id="email" class="form-control" placeholder="you@example.com">
                                </div>
                            </div>
                            <div class="form-group mt-3">
                                <label for="password">Password</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                    </div>
                                    <input type="password" name="password" id="password" class="form-control" placeholder="********">
                                </div>
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
                        <a href="{{ route('user.register') }}">Don't have an account? Register here</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @error('record')
        <div class="alert alert-danger mt-3 text-center">
            {{ $message }}
        </div>
    @enderror
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
@endsection