<!DOCTYPE html>
<html>
<head>
    <title>Driver Login</title>
    <style>
        body { font-family: Arial; background: #f5f5f5; display: flex; justify-content: center; align-items: center; height: 100vh; }
        .login-box { background: white; padding: 30px; border-radius: 8px; box-shadow: 0 0 10px #ccc; width: 300px; }
        input { width: 100%; padding: 10px; margin: 10px 0; border-radius: 4px; border: 1px solid #ccc; }
        button { width: 100%; padding: 10px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer; }
        .error { color: red; font-size: 14px; }
    </style>
</head>
<body>
    <div class="login-box">
        <h2>Driver Login</h2>
        <form method="POST" action="{{ url('/driver/login') }}">
            @csrf
            <input type="text" name="phone" placeholder="Phone" required>
            <input type="password" name="password" placeholder="Password" required>
            @if($errors->any())
                <div class="error">{{ $errors->first() }}</div>
            @endif
            <button type="submit">Login</button>
        </form>
    </div>
</body>
</html>
