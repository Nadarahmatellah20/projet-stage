<head>
    <link rel="stylesheet" href="{{ URL::asset('style/profile.css') }}">
</head>

@extends('admin.layouts.main')
@section('main-content')

<div class="profile-wrapper">
    <div class="profile_pic">
        <img src="{{ URL::asset('assets/img/user.png') }}" alt="Profile">
    </div>
    <div class="info">
        @if($admin)
            <h1>{{ $admin->fname }} {{ $admin->lname }}</h1>
            <h2>Rôle: {{ $admin->role }}</h2>
            <h3>Email: {{ $admin->email }}</h3>
            {{-- FIX: null check avant format() --}}
            @if($admin->created_at)
                <h3>Créé le: {{ $admin->created_at->format('d/m/Y') }}</h3>
            @endif
        @else
            <h1>Admin</h1>
        @endif
    </div>
</div>

@endsection
