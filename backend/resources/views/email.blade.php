<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Request</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f4f6f9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .card {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0px 0px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            max-width: 400px;
            width: 100%;
        }

        .card h2 {
            font-size: 24px;
            color: #2575fc;
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #2575fc;
            border-color: #2575fc;
        }

        .btn-primary:hover {
            background-color: #6a11cb;
            border-color: #6a11cb;
        }
    </style>
</head>
<body>

    <div class="card">
        <h2>Reset Your Password</h2>
        <p>Please enter your email address to receive the password reset link.</p>

        <!-- Form to request password reset -->
        <form method="POST" action="{{ route('password.reset') }}">
            @csrf

            <!-- Email Input -->
            <div class="form-group">
                <!-- <label for="email">Email Address</label> -->
                <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter Email Address">
            </div>

            <!-- Error Message for Invalid Email -->
            @if ($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Send Password Reset Link</button>
        </form>

        <div class="mt-3 text-center">
            <p>Remember your password? <a href="{{ route('login') }}">Login here</a></p>
        </div>
    </div>

</body>
</html>
