<head>
    <link rel="stylesheet" href="{{URL::asset('style/users-tab-style.css')}}">
</head>

@extends('admin.layouts.main')
@section('main-content')
    <div class="items-container">
        <div class="index-header">
            <div class="search-bar">
                <form action="{{route('admins.index')}}" method="get">
                    <input type="search" name="search" id="search-bar" value="{{old('search')}}">
                    <button type="submit">Rechercher</button>
                    <a href="{{route('admins.index')}}">Omettre</a>
                </form>
            </div>
            <a href="{{ route('admins.create') }}" class="btn" style="background:#04132e;color:white;padding:8px 16px;border-radius:5px;text-decoration:none;">
                + Ajouter Admin
            </a>
        </div>

        <table border="1">
            <tr>
                <th>ID</th>
                <th>Nom et Prenom</th>
                <th>Nom d'Authentification</th>
                <th>Date Création</th>
                <th>Role</th>
                <th>Options</th>
            </tr>
        @if (($searching && $isFound) || (!$searching))
            @foreach ($admins as $item)
            <tr>
                <td class="col_id">{{$item->id}}</td>
                <td class="col_name">{{$item->fname . ' ' . $item->lname}}</td>
                <td class="col_authname">{{$item->authname}}</td>
                <td class="col_created_at">{{$item->created_at}}</td>
                <td class="col_role">{{$item->role}}</td>
                <td class="col_options">
                    <a href="{{ route('admins.edit' , $item) }}">Modifier</a>
                    <form action="{{ route('admins.destroy', $item) }}" method="POST">
                        @csrf
                        @method('delete')
                        <input type="submit" value="Suprimer">
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
        @else
        </table>
        <br>
        <h1>Not found</h1>
        @endif
        @if (($searching && $isFound) || (!$searching))
            {{$admins->links('vendor.pagination.default')}}
        @endif
    </div>
@endsection
