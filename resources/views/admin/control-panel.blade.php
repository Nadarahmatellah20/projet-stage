@extends('admin.layouts.main')

@section('main-content')

<h2>Bienvenue, {{ $admin->fname }} {{ $admin->lname }}</h2>

<div class="cards">
    <div class="card">
        <h3>Total Commandes</h3>
        <p>{{ $ordersCount }}</p>
    </div>
    <div class="card">
        <h3>Utilisateurs</h3>
        <p>{{ $usersCount }}</p>
    </div>
    <div class="card">
        <h3>Tickets Ouverts</h3>
        <p>{{ $ticketsCount }}</p>
    </div>
</div>

<div class="table-box">
    <h3>Dernières Commandes</h3>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Client</th>
                <th>Titre</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($latestOrders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>
                    @if($order->Client)
                        {{ $order->Client->fname }} {{ $order->Client->lname }}
                    @else
                        —
                    @endif
                </td>
                <td>{{ $order->title }}</td>
                <td>
                    @if($order->order_status === 'pending')
                        <span style="color:#e65100; font-weight:600;">En attente</span>
                    @elseif($order->order_status === 'delivering')
                        <span style="color:#1565c0; font-weight:600;">En livraison</span>
                    @elseif($order->order_status === 'completed')
                        <span style="color:#2e7d32; font-weight:600;">Terminé</span>
                    @else
                        {{ $order->order_status }}
                    @endif
                </td>
                <td>{{ $order->created_at->format('d/m/Y') }}</td>
                <td>
                    <a href="{{ route('showOrder', $order) }}"
                       style="background:#085f65; color:white; padding:5px 12px; border-radius:8px; font-size:12px;">
                        Afficher
                    </a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">Aucune commande</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection
