@extends('admin.layouts.main')

@section('main-content')

<head>
    <link rel="stylesheet" href="{{URL::asset('style/users-tab-style.css')}}">
</head>

<div class="items-container">

    {{-- SEARCH HEADER --}}
    <div class="index-header">

        <div class="search-bar">

            <form action="{{route('users.index')}}" method="get">

                <input type="search"
                       name="search"
                       id="search-bar"
                       value="{{old('search')}}"
                       placeholder="Rechercher un utilisateur">

                <button type="submit">Rechercher</button>
                <a href="{{route('users.index')}}">Reset</a>

            </form>

        </div>

    </div>

    {{-- TABLE --}}
    <table>

        <thead>
            <tr>
                <th>ID</th>
                <th>Nom et Prénom</th>
                <th>Entreprise</th>
                <th>Date Création</th>
                <th>Options</th>
            </tr>
        </thead>

        <tbody>

        @if (($searching && $isFound) || (!$searching))

            @forelse ($users as $item)

                <tr>

                    {{-- ID --}}
                    <td class="col_id">
                        #{{ $item->id }}
                    </td>

                    {{-- NAME --}}
                    <td class="col_name">
                        {{ $item->fname . ' ' . $item->lname }}
                    </td>

                    {{-- COMPANY --}}
                    <td class="col_company">
                        {{ $item->company ?? '-' }}
                    </td>

                    {{-- DATE --}}
                    <td class="col_created_at">
                        {{ $item->created_at }}
                    </td>

                    {{-- ACTIONS --}}
                    <td class="col_options">

                        <a href="{{ route('users.edit', $item) }}"
                           class="action edit">
                            Modifier
                        </a>

                        <form action="{{ route('users.destroy', $item) }}"
                              method="POST"
                              class="inline-form">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="action delete"
                                    onclick="return confirm('Supprimer cet utilisateur ?')">
                                Supprimer
                            </button>

                        </form>

                    </td>

                </tr>

            @empty

                <tr>
                    <td colspan="5" class="empty">
                        Aucun utilisateur trouvé
                    </td>
                </tr>

            @endforelse

        @endif

        </tbody>

    </table>

    {{-- PAGINATION --}}
    @if (($searching && $isFound) || (!$searching))
        <div class="pagination">
            {{ $users->links('vendor.pagination.default') }}
        </div>
    @endif

</div>

@endsection