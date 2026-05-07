<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="{{ URL::asset('style/adm-login.css')}}">
<title>Control Panel: Login</title>
</head>

<body>

<h1>U-Tech Control Panel</h1>

@if ($errors->any())
<div class="error-box">
    {{ $errors->first() }}
</div>
@endif

<div class="container">

<form method="POST" action="{{ route('login-c') }}">
@csrf

<div class="input-group">
<label>Email</label>
<input type="email" name="email" placeholder="Enter your email" required>
</div>

<div class="input-group">
<label>Password</label>
<input type="password" name="password" placeholder="Enter your password" required>
</div>

<div class="submit">
<button type="submit">Login</button>
</div>

</form>

</div>

</body>
</html>