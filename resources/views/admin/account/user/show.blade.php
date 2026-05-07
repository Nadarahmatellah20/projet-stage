<head>
    <link rel="stylesheet" href="{{ URL::asset('style/users-tab-style.css') }}">
</head>

@extends('admin.layouts.main')
@section('main-content')

<div class="items-container">
    <h2>{{ $user->fname }} {{ $user->lname }}</h2>
    <p><strong>Email:</strong> {{ $user->email }}</p>
    <p><strong>Entreprise:</strong> {{ $user->company ?? '—' }}</p>
    <p><strong>Pays:</strong> {{ $user->country ?? '—' }}</p>
    <p><strong>Ville:</strong> {{ $user->city ?? '—' }}</p>
    <p><strong>Code Postal:</strong> {{ $user->zip ?? '—' }}</p>
    <p><strong>Adresse:</strong> {{ $user->adress ?? '—' }}</p>
    <p><strong>Téléphone:</strong> {{ $user->phone ?? '—' }}</p>
    <p><strong>Email vérifié:</strong>
        {{ $user->email_verified_at ? $user->email_verified_at->format('d/m/Y') : 'Non vérifié' }}
    </p>
    <p><strong>Créé le:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
    <a href="{{ route('users.edit', $user) }}">Modifier</a>
</div>

@endsection
