<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'عنوان الموقع')</title>


    <!-- تضمين مكتبات Toastr -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
</head>
<body>
    <!-- المحتوى المشترك مثل الرأس -->
    <header>
        <!-- المحتوى في الرأس -->
    </header>

    <!-- المحتوى الرئيسي -->
    <main>
        @yield('content')

    </main>

    <!-- المحتوى المشترك مثل التذييل -->
    <footer>
        <!-- محتوى التذييل -->
    </footer>
</body>
</html>
