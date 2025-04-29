@extends('layouts.admin')
@section('title', 'Add Admin')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <h3 class="mb-4 text-primary d-flex align-items-center">
                <i class="fas fa-user-plus me-2"></i> Register New Administrator
            </h3>

            @error('error')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @enderror

            <form action="{{ route('admin.addadmin.post') }}" method="POST">
                @csrf

                <div class="mb-3 form-floating">
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                           id="name" placeholder="Full Name" value="{{ old('name') }}">
                    <label for="name">Full Name</label>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-floating">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                           id="email" placeholder="Email Address" value="{{ old('email') }}">
                    <label for="email">Email Address</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-floating">
                    <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                           id="username" placeholder="Username" value="{{ old('username') }}">
                    <label for="username">Username</label>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-floating">
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                           id="password" placeholder="Password">
                    <label for="password">Password</label>
                    <div class="form-text">Minimum 8 characters with at least one uppercase, one lowercase, and one number</div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="reset" class="btn btn-outline-secondary">
                        <i class="fas fa-undo me-1"></i> Reset
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-plus me-1"></i> Register Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
