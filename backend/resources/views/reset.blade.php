<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
        <p>Enter your new password below.</p>

        <!-- Form to reset password -->
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <!-- Token hidden input field -->
            <input type="hidden" name="token" value="{{ $token }}">

            <!-- Email Input -->
            <div class="form-group">
                <!-- <label for="email">Email Address</label> -->
                <input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="Enter Email Address">
            </div>

            <!-- Password Input -->
            <div class="form-group">
                <!-- <label for="password">New Password</label> -->
                <input type="password" id="password" class="form-control" name="password" required placeholder="Enter New Password">
            </div>

            <!-- Password Confirmation -->
            <div class="form-group">
                <!-- <label for="password_confirmation">Confirm Password</label> -->
                <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" required placeholder="Enter password_confirmation">
            </div>

            <!-- Error Message -->
            @if ($errors->has('email'))
                <div class="alert alert-danger">
                    {{ $errors->first('email') }}
                </div>
            @endif

            @if ($errors->has('password'))
                <div class="alert alert-danger">
                    {{ $errors->first('password') }}
                </div>
            @endif

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Reset Password</button>
        </form>

        <div class="mt-3 text-center">
            <p>Remembered your password? <a href="{{ route('login') }}">Login here</a></p>
        </div>
    </div>

</body>
</html>
