<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | NER System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
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
</head>
<body>
    @include('toast.message')
    <nav class="topbar navbar navbar-expand" style="background-color: #003776;">
        <div class="container-fluid">
            <a class="navbar-brand brand-logo" href="{{ route('admin.login') }}">NER Admin</a>
        </div>  
    </nav>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header text-center header-bg">
                        <h3><i class="fas fa-lock"></i> Admin Portal</h3>
                        <p>Please sign in to your account</p>
                    </div>
                    <div class="card-body">
                        @error('error')
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ $message }}
                                
                            </div>
                        @enderror
                            
                        <form action="{{ route('admin.login') }}" method="POST" autocomplete="off">
                            @csrf
                            
                            <div class="form-group">
                                <label for="username" class="font-weight-bold">Username</label>
                                <input type="text" name="username" id="username" class="form-control input-with-icon" 
                                        placeholder="Enter your username" required value="{{ old('username') }}">
                                
                                @error('username')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="form-group mt-4">
                                <label for="password" class="font-weight-bold">Password</label>
                                <div class="input-group">
                                    <input type="password" name="password" id="password" class="form-control input-with-icon" 
                                           placeholder="Enter your password" value="{{ old('password') }}">
                                </div>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            
                            <div class="form-group mt-4 remember-me">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input">
                                <label for="remember">Remember Me</label>
                            </div>
                            
                            <div class="form-group mt-4">
                                <button type="submit" class="btn btn-primary btn-login btn-block">
                                    <i class="fas fa-sign-in-alt"></i> Login
                                </button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const passwordField = document.getElementById('password');
        const togglePassword = document.createElement('span');
        togglePassword.classList.add('input-group-text', 'toggle-password');
        togglePassword.innerHTML = '<i class="fas fa-eye"></i>';
        
        togglePassword.addEventListener('click', function() {
            if (passwordField.type === 'password') {
                passwordField.type = 'text';
                togglePassword.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordField.type = 'password';
                togglePassword.innerHTML = '<i class="fas fa-eye"></i>';
            }
        });
        document.querySelector('.input-group').appendChild(togglePassword);
    });
</script>
</body>
</html>