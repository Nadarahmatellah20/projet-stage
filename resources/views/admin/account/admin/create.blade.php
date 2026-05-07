<head>
    <link rel="stylesheet" href="{{ URL::asset('style/users-tab-style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('style/admin-edit.css') }}">
</head>

@extends('admin.layouts.main')
@section('main-content')

<div class="items-container">

    @if ($errors->any())
        <div style="color:red; margin-bottom:10px;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('admins.store') }}" method="post">
        @csrf

        <div class="edit-header">
            <a href="{{ route('admins.index') }}" style="margin-right:10px;">Annuler</a>
            <input type="submit" value="Créer Admin">
        </div>

        <label>Prénom:</label><br>
        <input type="text" name="fname" value="{{ old('fname') }}" required><br><br>

        <label>Nom:</label><br>
        <input type="text" name="lname" value="{{ old('lname') }}" required><br><br>

        <label>Nom d'authentification:</label><br>
        <input type="text" name="authname" value="{{ old('authname') }}" required><br><br>

        <label>Rôle:</label><br>
        <input type="text" name="role" value="{{ old('role', 'admin') }}" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email') }}" required><br><br>

        <label>Mot de passe:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Confirmer le mot de passe:</label><br>
        <input type="password" name="password_confirmation" required><br><br>

    </form>
</div>

@endsection
