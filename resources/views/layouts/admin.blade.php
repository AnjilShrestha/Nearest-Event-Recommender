{{-- @php
    abort_unless(auth()->guard('admin')->check(), 404);
@endphp --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title') | NER Admin</title>
    <!-- Bootstrap 5 CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/navbar.css') }}"> 
    @stack('styles')
</head>
<body>
    <!-- Top Navigation -->
    <nav class="topbar navbar navbar-expand">
        <div class="container-fluid">
            <button class="sidebar-toggle d-lg-none me-2" type="button">
                <i class="bi bi-list"></i>
            </button>
            
            <a class="navbar-brand brand-logo" href="{{ route('admin.login') }}">NER Admin</a>
            
            <div class="ms-auto d-flex align-items-center">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle d-flex align-items-center" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-person-circle me-2"></i>
                        Hello, {{ auth()->guard('admin')->user()->username }}
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                        <li><a class="dropdown-item" href="{{ url('/change-password') }}"><i class="bi bi-key me-2"></i>Change Password</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('admin.logout') }}"><i class="bi bi-box-arrow-right me-2"></i>Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <div class="sidebar">
        <div class="sidebar-menu">
            
            <a class="sidebar-link {{ Request::is('admin/dashboard') ? 'active' : '' }}" href="{{ url('/admin/dashboard') }}">
                <i class="bi bi-speedometer2"></i>
                Dashboard
            </a>
            <a class="sidebar-link {{ Request::is('admin/adminlist') ? 'active' : '' }}" href="{{ url('admin/adminlist') }}">
                <i class="bi bi-person-gear"></i>
                Admin
            </a>
            <a class="sidebar-link {{ Request::is('admin/eventorganizer') ? 'active' : '' }}" href="{{ url('admin/eventorganizer') }}">
                <i class="bi bi-people"></i>
                Event Organizers
            </a>
            
            <a class="sidebar-link {{ Request::is('events') ? 'active' : '' }}" href="{{ url('/events') }}">
                <i class="bi bi-calendar-event"></i>
                Events
            </a>
            <a class="sidebar-link {{ Request::is('admin/eventcategories') ? 'active' : '' }}" href="{{ url('/admin/eventcategories') }}">
                <i class="bi bi-calendar-event"></i>
                Event Categories
            </a>
            <a class="sidebar-link {{ Request::is('admin/users') ? 'active' : '' }}" href="{{ url('/admin/users') }}">
                <i class="bi bi-person-lines-fill"></i>
                Users
            </a>
            
            <a class="sidebar-link {{ Request::is('admin/eventorganizer/status') ? 'active' : '' }}" href="{{ url('/admin/eventorganizer/status') }}">
                <i class="bi bi-check-circle"></i>
                Approve Organizers
            </a>
        </div>
    </div>

    <main class="main-content">
        @yield('content')
    </main>

    <footer class="footer mt-auto py-3">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <span class="text-muted">&copy; 2025 NER. All rights reserved.</span>
                </div>
            </div>
        </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            const sidebarToggle = document.querySelector('.sidebar-toggle');
            const sidebar = document.querySelector('.sidebar');
            
            if (sidebarToggle && sidebar) {
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                });
            }
            
            
            document.addEventListener('click', function(event) {
                if (window.innerWidth < 992) {
                    const isClickInsideSidebar = sidebar.contains(event.target);
                    const isClickOnToggle = event.target === sidebarToggle || 
                                          sidebarToggle.contains(event.target);
                    
                    if (!isClickInsideSidebar && !isClickOnToggle && sidebar.classList.contains('show')) {
                        sidebar.classList.remove('show');
                    }
                }
            });
            
            
            sidebar.addEventListener('click', function(event) {
                event.stopPropagation();
            });
        });
    </script>
    @include('toast.message')
</body>
</html>