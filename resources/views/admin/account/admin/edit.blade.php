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

    <form action="{{ route('admins.update', $admin) }}" method="post">
        @csrf
        @method('PUT')

        <div class="edit-header">
            <input type="submit" value="Enregistrer">
        </div>

        <label>Prénom:</label><br>
        <input type="text" name="fname" value="{{ old('fname', $admin->fname) }}"><br><br>

        <label>Nom:</label><br>
        <input type="text" name="lname" value="{{ old('lname', $admin->lname) }}"><br><br>

        {{-- FIX: authname كان ناقص من edit form --}}
        <label>Nom d'authentification:</label><br>
        <input type="text" name="authname" value="{{ old('authname', $admin->authname) }}"><br><br>

        <label>Rôle:</label><br>
        <input type="text" name="role" value="{{ old('role', $admin->role) }}"><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" value="{{ old('email', $admin->email) }}"><br><br>

    </form>
</div>

@endsection
