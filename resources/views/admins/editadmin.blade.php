@extends('layouts.admin')
@section('title', 'Edit Admin')
@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <h3 class="mb-4 text-primary d-flex align-items-center">
                <i class="fas fa-user-edit me-2"></i> Edit Administrator
            </h3>

            @error('error')
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @enderror

            <form action="{{ route('admin.updateadmin', $admin->id) }}" method="POST">
                @csrf
                @method('POST')
                <div class="mb-3 form-floating">
                    <input type="text" name="name" id="edit_name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $admin->name) }}">
                    <label for="name">Full Name</label>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-floating">
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $admin->email) }}">
                    <label for="email">Email Address</label>
                    @error('email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-floating">
                    <input type="text" name="username" id="edit_username" class="form-control @error('username') is-invalid @enderror" 
                           value="{{ old('username', $admin->username) }}">
                    <label for="edit_username">Username</label>
                    @error('username')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-floating">
                    <input type="password" name="password" id="edit_password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter new password (optional)">
                    <label for="password">Password (Leave blank to keep current)</label>
                    <div class="form-text">Minimum 8 characters with at least one uppercase, one lowercase, and one number</div>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-user-edit me-1"></i> Update Admin
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
