<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
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
        <h2>WELCOME BACK</h2>
    </div>

    <div class="input-group">
        <i class="fa fa-envelope"></i>
        <input type="email" placeholder="Email address">
    </div>

    <div class="input-group">
        <i class="fa fa-lock"></i>
        <input type="password" placeholder="Password">
    </div>

    <button class="btn">LOGIN</button>

    <div class="footer">
        Don’t have an account? <a href="{{ route('register') }}">Register</a>
    </div>
</div>

</body>
</html>
