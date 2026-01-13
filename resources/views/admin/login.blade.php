<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    
    <!-- Bootstrap CDN (optional for quick styling) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        .login-container img {
            width: 100px;
            margin-bottom: 20px;
        }

        .login-container h2 {
            margin-bottom: 25px;
            font-weight: 600;
            color: #333;
        }

        .login-container input[type="email"] {
            margin-bottom: 15px;
        }

        .btn-custom {
            background-color: #1f9f66;
            color: #fff;
            width: 100%;
            font-weight: 500;
        }

        .btn-custom:hover {
            background-color: #19744b;
            color: #fff;

        }

        .error-msg {
            color: red;
            margin-top: 10px;
        }

    </style>
</head>
<body>

    <div class="login-container">
        <!-- Logo -->
        <img src="{{ asset('images/logo.png') }}" alt="Logo">

        <h2>Admin Login</h2>

        <!-- OTP Login Form -->
        <form method="POST" action="{{ route('admin.sendOtp') }}">
            @csrf

            <input type="email" name="email" class="form-control" placeholder="Enter admin email" required>

            <button type="submit" class="btn btn-custom mt-3">Continue</button>
        </form>

        <!-- Error Message -->
        @if(session('error'))
            <p class="error-msg">{{ session('error') }}</p>
        @endif
    </div>

</body>
</html>
