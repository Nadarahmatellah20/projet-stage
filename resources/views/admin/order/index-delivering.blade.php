@extends('admin.layouts.main')

@section('main-content')

<head>
    <link rel="stylesheet" href="{{URL::asset('style/users-tab-style.css')}}">
    <style>
        .prod-tags { display:flex; flex-wrap:wrap; gap:5px; padding:6px 12px 8px 12px; background:#f4f6fb; }
        .prod-tag  { background:#e0e7f3; color:#04132e; border-radius:20px; padding:3px 10px; font-size:12px; }
        .prod-tag span { color:#555; font-size:11px; }
    </style>
</head>

<div class="items-container">

    <div class="index-header">
        <div class="search-bar">
            <form action="{{route('indexDeliveringOrders')}}" method="get">
                <input type="search" name="search" id="search-bar"
                       value="{{old('search')}}" placeholder="Rechercher une commande">
                <button type="submit">Rechercher</button>
                <a href="{{route('indexDeliveringOrders')}}">Omettre</a>
            </form>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Client</th>
                <th>Titre</th>
                <th>Produits</th>
                <th>Date Création</th>
                <th>Status</th>
                <th>Options</th>
            </tr>
        </thead>
        <tbody>

        @if (($searching && $isFound) || (!$searching))

            @foreach ($orders as $item)
                <tr>
                    <td class="col_id">#{{ $item->id }}</td>

                    <td class="col_name">
                        {{ $item->Client ? $item->Client->fname.' '.$item->Client->lname : '#'.$item->client_id }}
                    </td>

                    <td class="col_name">{{ $item->title }}</td>

                    <td>
                        <div class="prod-tags">
                        @forelse ($item->OrderList as $ol)
                            @php $prod = $ol->Product($ol->prod_category)?->first(); @endphp
                            @if ($prod)
                                <span class="prod-tag">
                                    {{ $prod->name }}
                                    <span>({{ $ol->prod_category }}) &times;{{ $ol->volume }}</span>
                                </span>
                            @endif
                        @empty
                            <span style="color:#aaa;font-size:12px;">—</span>
                        @endforelse
                        </div>
                    </td>

                    <td class="col_created_at">{{ $item->created_at->format('d/m/Y') }}</td>

                    <td class="col_role">
                        <span class="status">{{ $item->order_status }}</span>
                    </td>

                    <td class="col_options">
                        <a href="{{route('showOrder', $item)}}" class="action view">Afficher</a>
                        <a href="{{route('changeOrderStatus', $item)}}" class="action complete">Compléter</a>
                        <a href="{{route('archiveOrder', $item)}}" class="action archive">Archive</a>
                    </td>
                </tr>
            @endforeach

        @endif

        </tbody>
    </table>

    @if (!($searching && !$isFound))
    @else
        <br><h1>Not found</h1>
    @endif

    @if (($searching && $isFound) || (!$searching))
        <div class="pagination">
            {{ $orders->links('vendor.pagination.default') }}
        </div>
    @endif

</div>

@endsection
