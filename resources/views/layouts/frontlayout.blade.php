<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')|Nearest Event Recommender</title>
    <!-- Bootstrap CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    @yield('style')
    <style>
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }
        .nav-link {
            font-weight: 500;
            padding: 0.5rem 1rem;
        }
    </style>
    @stack('styles')
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('/') }}">NER</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">  
                        <a class="nav-link active" href="{{ route('/') }}">
                            <i class="fas fa-home me-1"></i>
                            Home
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-calendar-alt me-1"></i>Events</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">
                            <i class="fas fa-info-circle me-1"></i> About
                        </a>
                    </li>

                    @auth('user')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.dashboard') }}">
                            <i class="fas fa-tachometer-alt me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.ticket') }}">
                            <i class="fas fa-ticket-alt me-1"></i>Tickets
                        </a>
                    </li>
                    <div class="ms-auto d-flex align-items-center">
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-2"></i>
                                Hello, {{ auth()->guard('user')->user()->username }}
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="{{ url('/change-password') }}"><i class="bi bi-key me-2"></i>Change Password</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="{{ route('user.logout') }}"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                            </ul>
                        </div>
                    @else

                    
                    <li class="nav-item">
                        <a class="nav-link btn-login" href="{{ route('user.login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-register" href="{{ route('user.register') }}">
                            <i class="fas fa-user-plus me-1"></i> Register
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-login" href="{{ route('eventorganizer.login') }}">
                            <i class="fas fa-sign-in-alt me-1"></i> Organizer Login
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn-register" href="{{ route('eventorganizer.register') }}">
                            <i class="fas fa-user-plus me-1"></i> Organizer Register
                        </a> 
                    </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <div class="container my-5">
        @yield('content')
    </div>
    
    <!-- Footer -->
    <footer class="bg-primary text-white text-center py-3 absolute-bottom-0 w-100">
        <div class="container">
            <h5>Stay Connected</h5>
            <p>Join our community and never miss an event!</p>
            <a href="#" class="btn btn-light btn-login">Contact Us</a>
        </div>
        <hr class="my-4" style="border-color: rgba(255, 255, 255, 0.5);">
        <div class="container mb-3">
            <p class="mb-0">Follow us on:
                <a href="#" class="text-white"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-white"><i class="fab fa-twitter"></i></a>
                <a href="#" class="text-white"><i class="fab fa-instagram"></i></a>
            </p>
        <p>&copy; {{ date('Y') }} Nearest Event Recommender. All rights reserved.</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeo5Zl3h9tj8z5gU4tF1bUJzfsrzV7MkGpHgtAKqM0C2jNgF" crossorigin="anonymous"></script>
</body>
</html>
