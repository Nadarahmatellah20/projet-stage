<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ URL::asset('css/login.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    
    <title>Se connecter</title>
</head>
<body>

<form action="{{ route('userLogin') }}" method="POST">
    @csrf

    <div class="wrapper">
        <h1>Se connecter</h1>

        <!-- Email -->
        <div class="input-data">
            <input type="email" name="email" required id="email" value="{{ old('email') }}">
            <div class="underline"></div>
            <label><i class="fa-solid fa-envelope iconemail"></i> Email</label>
            <span id="email-error"></span>

            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="input-data">
            <input type="password" name="password" required id="pwd">
            <div class="underline"></div>
            <label><i class="fa-solid fa-lock icon"></i> Mot de passe</label>
            <span id="pwd-error"></span>

            @error('password')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <!-- Forgot password -->
        <div class="pass">
            <a href="#">Mot de passe oublié?</a>
        </div>

        <!-- Submit -->
        <input type="submit" value="Se connecter">

        <!-- Login error -->
        @if ($errors->has('login'))
            <span id="submit-error">{{ $errors->first('login') }}</span>
        @endif

        <!-- Register link -->
        <div class="signin_lnk">
            Pas de compte? <a href="{{ route('registerForm') }}">S'inscrire</a>
        </div>

    </div>
</form>

<!-- JS -->
<script src="{{ URL::asset('js/login.js') }}"></script>

</body>
</html>