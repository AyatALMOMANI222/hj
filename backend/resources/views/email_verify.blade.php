<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f4f6f9;
        }

        .card {
            background: #fff;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);
            max-width: 500px;
            width: 100%;
            text-align: center;
        }

        .card h2 {
            font-size: 24px;
            color: #2575fc;
            margin-bottom: 20px;
        }

        .card p {
            font-size: 16px;
            margin-bottom: 30px;
        }

        .btn {
            padding: 12px;
            font-size: 16px;
            border-radius: 8px;
            background-color: #2575fc;
            color: #fff;
            border: none;
            transition: background-color 0.3s ease;
        }

        .btn:hover {
            background-color: #6a11cb;
            color: white;
        }
    </style>
</head>
<body>

    <div class="card">
        <h2>Email Verification</h2>

        @if($status === 'success')
            <div class="alert alert-success">
                <strong>Success!</strong> {{ $message }}
            </div>
            <p>Your account is now verified. You can <a href="{{ route('login') }}" class="btn">Login</a></p>
        @elseif($status === 'failed')
            <div class="alert alert-danger">
                <strong>Error!</strong> {{ $message }}
            </div>
            <p>Please try again or contact support if the issue persists.</p>
        @endif
    </div>

</body>
</html>
