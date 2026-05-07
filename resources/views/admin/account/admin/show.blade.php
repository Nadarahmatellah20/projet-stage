<head>
    <link rel="stylesheet" href="{{ URL::asset('style/users-tab-style.css') }}">
</head>

@extends('admin.layouts.main')
@section('main-content')

<div class="items-container">
    <h2>{{ $admin->fname }} {{ $admin->lname }}</h2>
    <p><strong>Authentification:</strong> {{ $admin->authname }}</p>
    <p><strong>Rôle:</strong> {{ $admin->role }}</p>
    <p><strong>Email:</strong> {{ $admin->email }}</p>
    <p><strong>Créé le:</strong> {{ $admin->created_at->format('d/m/Y') }}</p>
    <a href="{{ route('admins.edit', $admin) }}">Modifier</a>
</div>

@endsection
