<head>
    <link rel="stylesheet" href="{{ URL::asset('style/users-tab-style.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('style/user-edit.css') }}">
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

    <form action="{{ route('users.update', $user) }}" method="post">
        @csrf
        @method('PUT')

        <div class="edit-header">
            <input type="submit" value="Enregistrer">
        </div>

        <label>Prénom:</label><br>
        <input type="text" name="fname" value="{{ old('fname', $user->fname) }}"><br><br>

        <label>Nom:</label><br>
        <input type="text" name="lname" value="{{ old('lname', $user->lname) }}"><br><br>

        <label>Entreprise:</label><br>
        <input type="text" name="company" value="{{ old('company', $user->company) }}"><br><br>

        <label>Pays:</label><br>
        <input type="text" name="country" value="{{ old('country', $user->country) }}"><br><br>

        <label>Ville:</label><br>
        <input type="text" name="city" value="{{ old('city', $user->city) }}"><br><br>

        <label>Code Postal:</label><br>
        <input type="number" name="zip" min="0" value="{{ old('zip', $user->zip) }}"><br><br>

        <label>Adresse:</label><br>
        <input type="text" name="adress" value="{{ old('adress', $user->adress) }}"><br><br>

        <label>Téléphone:</label><br>
        <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email', $user->email) }}"><br><br>

    </form>
</div>

@endsection
