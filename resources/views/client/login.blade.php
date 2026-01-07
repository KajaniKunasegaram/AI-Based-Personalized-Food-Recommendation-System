
@extends('client.layout')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<link rel="stylesheet" href="{{asset('css/client/register-login.css')}}">        


@if(session('success'))
<div id="successMessage" class="success-msg">
    <i class="fa-solid fa-circle-check"></i>
    <span> {{ session('success') }}</span>
</div>
@endif

@if($errors->any())
<div class="error-msg">
    {{ $errors->first() }}
</div>
@endif


<div class="card">
  <a href="{{ route('checkout') }}" class="back">
    <i class="fa fa-arrow-left"></i>
</a>

    <div class="logoo">
        <img src="/images/logo.png" alt="logo">
        <h2>WELCOME BACK</h2>
    </div>

    <form action="{{ route('customer.login') }}" method="POST">
        @csrf

        <input type="hidden" name="redirect" value="{{ request('redirect') }}">
        
       <div class="input-group">
            <i class="fa fa-envelope"></i>
            <input type="email" name="email" placeholder="Email address" required>
        </div>

        <div class="input-group">
            <i class="fa fa-lock"></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <button type="submit" class="btn">LOGIN</button>
    </form>
    <div class="footer">
        Don’t have an account? <a href="{{ route('register') }}">Register</a>
    </div>
</div>


<script>
    // Select the error message
    const errorBox = document.querySelector('.success-msg');
    if(errorBox) {
        // Wait 3 seconds, then fade out
        setTimeout(() => {
            errorBox.style.transition = 'opacity 0.5s ease';
            errorBox.style.opacity = '0';
            // Optional: remove from DOM after fading out
            setTimeout(() => {
                errorBox.remove();
            }, 500);
        }, 3000); // 3000ms = 3 seconds
    }

    // Select the error message
    const errorBox = document.querySelector('.error-msg');
    if(errorBox) {
        // Wait 3 seconds, then fade out
        setTimeout(() => {
            errorBox.style.transition = 'opacity 0.5s ease';
            errorBox.style.opacity = '0';
            // Optional: remove from DOM after fading out
            setTimeout(() => {
                errorBox.remove();
            }, 500);
        }, 3000); // 3000ms = 3 seconds
    }
    
</script>

@endsection