@extends('admin.layouts.main')

@section('main-content')

<h2>Bienvenue, {{ $admin->fname }} {{ $admin->lname }}</h2>

{{-- Stats cards --}}
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

{{-- ✅ Carte Factures --}}
<div style="margin: 20px 0; display:flex; gap:16px; flex-wrap:wrap;">

    <div style="flex:1; min-width:180px; background:#e8f5e9; border-left:5px solid #2e7d32;
                padding:18px 22px; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.07);">
        <div style="font-size:0.85em; color:#555; margin-bottom:6px;">
            <i class="fa-solid fa-circle-check" style="color:#2e7d32;"></i> Montant Encaissé
        </div>
        <div style="font-size:1.6em; font-weight:bold; color:#2e7d32;">
            {{ number_format($invoicePaidTotal, 2) }} MAD
        </div>
    </div>

    <div style="flex:1; min-width:180px; background:#fff8e1; border-left:5px solid #f57f17;
                padding:18px 22px; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.07);">
        <div style="font-size:0.85em; color:#555; margin-bottom:6px;">
            <i class="fa-solid fa-clock" style="color:#f57f17;"></i> En Attente de Paiement
        </div>
        <div style="font-size:1.6em; font-weight:bold; color:#f57f17;">
            {{ number_format($invoiceUnpaidTotal, 2) }} MAD
        </div>
        <div style="font-size:0.8em; color:#888; margin-top:4px;">
            {{ $invoiceUnpaidCount }} facture(s) non payée(s)
        </div>
    </div>

    <div style="flex:1; min-width:180px; display:flex; align-items:center; justify-content:center;">
        <a href="{{ route('indexInvoices') }}"
           style="background:#1a237e; color:white; padding:12px 24px; border-radius:8px;
                  text-decoration:none; font-size:0.9em; display:flex; align-items:center; gap:8px;">
            <i class="fa-solid fa-file-invoice-dollar"></i> Voir toutes les factures
        </a>
    </div>

</div>

{{-- Dernières commandes --}}
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
                       style="background:#085f65; color:white; padding:5px 12px;
                              border-radius:8px; font-size:12px;">
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