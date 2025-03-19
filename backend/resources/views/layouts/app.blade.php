<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            background-color: #f8f9fa;
        }
        .navbar {
            background-color: #fff;
            box-shadow: 0 2px 4px rgba(0,0,0,.08);
        }
        .navbar-brand {
            font-weight: 600;
        }
        .main-content {
            min-height: calc(100vh - 60px);
        }
    </style>

    <!-- Stack for additional styles -->
    @stack('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light">
        <div class="container">
            <a class="navbar-brand" href="/">{{ config('app.name', 'Laravel') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="/">الرئيسية</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="/login" id="loginLink">تسجيل الدخول</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" id="logoutLink" style="display: none;">تسجيل الخروج</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content py-4">
        @yield('content')
    </main>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Check authentication status
        document.addEventListener('DOMContentLoaded', function() {
            const token = localStorage.getItem('token');
            const loginLink = document.getElementById('loginLink');
            const logoutLink = document.getElementById('logoutLink');

            if (token) {
                loginLink.style.display = 'none';
                logoutLink.style.display = 'block';
            } else {
                loginLink.style.display = 'block';
                logoutLink.style.display = 'none';
            }

            // Handle logout
            logoutLink.addEventListener('click', function(e) {
                e.preventDefault();
                localStorage.removeItem('token');
                window.location.href = '/login';
            });
        });
    </script>

    <!-- Stack for additional scripts -->
    @stack('scripts')
</body>
</html> 