<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/toastr@3.1.0/build/toastr.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/toastr@3.1.0/build/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>

   <style>
    body {
        font-family: 'Poppins', sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    .card {
        background: #fff;
        padding: 40px;
        border-radius: 16px;
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
        max-width: 400px;
        width: 100%;
        text-align: center;
    }

    .card h2 {
        color: #2575fc;
        font-size: 24px;
        margin-bottom: 20px;
    }

    .form-control {
        border-radius: 8px;
        border: 1px solid #ddd;
        padding: 12px;
        font-size: 14px;
    }

    .form-control:focus {
        border-color: #2575fc;
        box-shadow: 0 0 8px rgba(37, 117, 252, 0.3);
    }

    .btn-primary {
        background: linear-gradient(to right, #2575fc, #6a11cb);
        border: none;
        border-radius: 8px;
        padding: 12px;
        font-size: 16px;
        transition: 0.3s;
    }

    .btn-primary:hover {
        background: linear-gradient(to right, #6a11cb, #2575fc);
        transform: scale(1.05);
    }

    .login-link {
        font-size: 12px;
        margin-top: 10px;
    }
   
    .toast-success {
        background-color: #28a745 !important;
        color: #fff !important;
        font-size: 16px;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    }

    .toast-error {
        background-color: #dc3545 !important;
        color: #fff !important;
        font-size: 16px;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    }

    .toast-info {
        background-color: #17a2b8 !important;
        color: #fff !important;
        font-size: 16px;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    }

    .toast-warning {
        background-color: #ffc107 !important;
        color: #fff !important;
        font-size: 16px;
        border-radius: 8px;
        padding: 20px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
    }

    .toast-message {
        font-family: 'Arial', sans-serif;
        font-weight: 600;
    }

    .toast-top-right {
        top: 10px !important;
        right: 10px !important;
    }
   </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100" data-page="login">

    <div class="card p-4" style="width: 450px;">
        <h3 class="text-center text-primary mb-4">تسجيل الدخول إلى حسابك</h3>
        <form id="loginForm">
            @csrf

            <div class="mb-3">
                <input type="email" name="email" class="form-control" placeholder="أدخل بريدك الإلكتروني" required>
            </div>

            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="أدخل كلمة المرور" required autocomplete="off">
            </div>

            <button type="submit" class="btn btn-primary w-100">تسجيل الدخول</button>
        </form>
        
   
        <p class="mt-3 text-center" style="font-size: 14px; color: #333;">
    ليس لديك حساب؟ 
    <a href="{{ route('register') }}" class="text-decoration-none" style="color: #2575fc; font-weight: 600;">
        سجل الآن
    </a>
</p>

<p class="mt-2 text-center" style="font-size: 14px; color: #555;">
    <a href="{{ route('password.request') }}" class="text-decoration-none" style="color: #dc3545; font-weight: 600;">
        نسيت كلمة المرور؟
    </a>
</p>

    </div>

    <script>
    $(document).ready(function() {
        $('#loginForm').on('submit', async function(e) {
            e.preventDefault(); // Prevent the form from submitting normally

            var formData = $(this).serialize(); // Serialize form data

            try {
                const response = await fetch("{{ route('login') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: formData
                });

                const data = await response.json();

                if (data.success) {
                    console.log(data.token);
                    
                    localStorage.setItem('token', data.token); // Save token here

                    toastr.success(data.message); // Display success toast
                    console.log(data.user.is_admin);
                    
                    
                    if (data.user.is_admin === 1) {
                        window.location.href = "{{ route('admin') }}"; // توجيه الأدمن إلى لوحة التحكم
                    } else if (data.user.role === "trainee") {
                        window.location.href = "{{ route('profile') }}"; // توجيه المتدرب إلى صفحة المدربين
                    } else {
                        window.location.href = "{{ route('profile') }}"; // توجيه المستخدم العادي إلى صفحة التسجيل
                    }
                    
                } else {
                    toastr.error(data.message); // Display error toast
                }

            } catch (error) {
                toastr.error('حدث خطأ ما.'); // Display error toast in case of failure
            }
        });
    });
    </script>

</body>
</html>
