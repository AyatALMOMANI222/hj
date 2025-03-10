<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Password Reset Failed</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f4f7fc;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            background-color: #fff;
            border-radius: 8px;
            padding: 40px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            color: #dc3545;
            font-size: 2.5rem;
            margin-bottom: 20px;
        }
        p {
            color: #333;
            font-size: 1rem;
        }
        .button {
            display: inline-block;
            background-color: #007bff;
            color: white;
            padding: 12px 24px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 1rem;
            margin-top: 20px;
            transition: background-color 0.3s;
        }
        .button:hover {
            background-color: #0056b3;
        }
        @media (max-width: 768px) {
            .container {
                padding: 30px;
            }
            h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Password Reset Failed</h1>
        <p>There was an issue resetting your password. Please try again later or contact support.</p>
        <a href="/password/reset" class="button">Try Again</a>
    </div>
</body>
</html>
