@extends('client.layout')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{asset('css/client/register-login.css')}}">

@if($errors->any())
<div class="error-msg" id="errorMessage">
    <i class="fa-solid fa-circle-xmark"></i>
    <span>{{ $errors->first() }}</span>
</div>
@endif

<div class="auth-page">
    <div class="auth-card">

        <a a href="{{ route('login') }}" class="back-btn">
            <i class="fa fa-arrow-left"></i>
        </a>

        <div class="auth-logo">
            <img src="/images/logo.png" alt="logo">
            <div class="auth-label">CREATE ACCOUNT</div>
            <h1 class="auth-title">Welcome <em>Aboard</em></h1>
        </div>

        <form action="{{ route('customer.register') }}" method="POST" class="auth-form">
            @csrf

            <div class="field-group">
                <i class="fa fa-user"></i>
                <input type="text" name="name" id="name" placeholder=" " required>
                <label for="name">Full Name</label>
                <div class="field-line"></div>
            </div>

            <div class="field-group">
                <i class="fa fa-envelope"></i>
                <input type="email" name="email" id="email" placeholder=" " required>
                <label for="email">Email Address</label>
                <div class="field-line"></div>
            </div>

            <div class="field-group">
                <i class="fa fa-lock"></i>
                <input type="password" name="password" id="password" placeholder=" " required>
                <label for="password">Password</label>
                <div class="field-line"></div>
            </div>

            <div class="field-group">
                <i class="fa fa-lock"></i>
                <input type="password" name="password_confirmation" id="password_confirmation" placeholder=" " required>
                <label for="password_confirmation">Confirm Password</label>
                <div class="field-line"></div>
            </div>

            <div class="auth-terms">
                By registering, you agree to our
                <a href="#">Terms & Conditions</a> and <a href="#">Privacy Policy</a>
            </div>

            <button type="submit" class="auth-btn">
                <span>Register</span>
                <i class="fa-solid fa-user-plus"></i>
            </button>
        </form>

        <div class="auth-footer">
            Already have an account? <a href="{{ route('login') }}">Login here</a>
        </div>

    </div>
</div>

<script>
    const el = document.getElementById('errorMessage');
    if (el) {
        setTimeout(() => {
            el.style.transition = 'opacity 0.5s ease';
            el.style.opacity = '0';
            setTimeout(() => el.remove(), 500);
        }, 3000);
    }
</script>

@endsection