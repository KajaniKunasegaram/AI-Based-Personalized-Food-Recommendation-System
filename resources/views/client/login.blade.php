@extends('client.layout')
@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{asset('css/client/register-login.css')}}">

@if(session('success'))
<div id="successMessage" class="success-msg">
    <i class="fa-solid fa-circle-check"></i>
    <span>{{ session('success') }}</span>
</div>
@endif

@if($errors->any())
<div class="error-msg" id="errorMessage">
    <i class="fa-solid fa-circle-xmark"></i>
    <span>{{ $errors->first() }}</span>
</div>
@endif

<div class="auth-page">
    <div class="auth-card">

        <a href="{{ route('checkout') }}" class="back-btn">
            <i class="fa fa-arrow-left"></i>
        </a>

        <div class="auth-logo">
            <img src="/images/logo.png" alt="logo">
            <div class="auth-label">WELCOME BACK</div>
            <h1 class="auth-title">Sign <em>In</em></h1>
        </div>

        <form action="{{ route('customer.login') }}" method="POST" class="auth-form">
            @csrf
            <input type="hidden" name="redirect" value="{{ request('redirect') }}">

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

            <button type="submit" class="auth-btn">
                <span>Login</span>
                <i class="fa-solid fa-arrow-right-to-bracket"></i>
            </button>
        </form>

        <div class="auth-footer">
            Don't have an account? <a href="{{ route('register') }}">Register</a>
        </div>
    </div>
</div>

<script>
    ['successMessage', 'errorMessage'].forEach(id => {
        const el = document.getElementById(id);
        if (el) {
            setTimeout(() => {
                el.style.transition = 'opacity 0.5s ease';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 500);
            }, 3000);
        }
    });
</script>

@endsection