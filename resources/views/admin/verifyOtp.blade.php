<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify OTP</title>

    <!-- Bootstrap CDN for quick styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f5f6fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .otp-container {
            max-width: 400px;
            margin: 80px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            text-align: center;
        }

        .otp-container img {
            width: 100px;
            margin-bottom: 20px;
        }

        .otp-container h2 {
            margin-bottom: 25px;
            font-weight: 600;
            color: #333;
        }

        .otp-container input[type="text"] {
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

        .info-text {
            font-size: 0.9rem;
            color: #555;
            margin-bottom: 15px;
        }

    </style>
</head>
<body>

    <div class="otp-container">
        <!-- Logo -->
        <img src="{{ asset('images/logo.png') }}" alt="Logo">

        <h2>Verify OTP</h2>

        <p class="info-text">We have sent an OTP to the official admin email.</p>

        <!-- OTP Form -->
        <form method="POST" action="{{ route('admin.verifyOtp') }}">
            @csrf

            <input type="text" name="otp" class="form-control" placeholder="Enter OTP" required>

            <button type="submit" class="btn btn-custom mt-3">Verify OTP</button>
        </form>

        <!-- Error Message -->
        @if(isset($error))
            <p class="error-msg">{{ $error }}</p>
        @endif
    </div>

</body>
</html>
