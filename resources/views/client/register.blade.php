<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Register</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{asset('css/client/register-login.css')}}">        

</head>

<body>

<div class="card">
    <a href="{{ route('checkout') }}" class="back">
    <i class="fa fa-arrow-left"></i>
</a>

    <div class="logo">
        <img src="/images/logo.png" alt="logo">
        <h2>WELCOME</h2>
    </div>

   <form action="{{ route('customer.register') }}" method="POST">
        @csrf  <!-- CSRF token for security -->

        <div class="input-group">
            <i class="fa fa-user"></i>
            <input type="text" name="name" placeholder="Full Name" required>
        </div>

        <div class="input-group">
            <i class="fa fa-envelope"></i>
            <input type="email" name="email" placeholder="Email address" required>
        </div>

        <div class="input-group">
            <i class="fa fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <div class="input-group">
            <i class="fa fa-lock"></i>
            <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
        </div>

        <div class="terms">
            By signing in, you agree to our <br>
            <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>
        </div>

        <button type="submit" class="btn">REGISTER</button>

        <div class="footer">
            Have an account? <a href="{{ route('login') }}">Login here</a>
        </div>
    </form>
</div>

</body>
</html>
