@extends('admin.layouts.main')

@section('main-content')

<style>
    .inv-table { width:100%; border-collapse:collapse; font-size:0.95em; }
    .inv-table th { background:#1a237e; color:white; padding:12px 10px; text-align:left; }
    .inv-table td { padding:11px 10px; border-bottom:1px solid #eee; vertical-align:middle; }
    .inv-table tr:hover { background:#f5f7ff; }
    .badge-paid { background:#e8f5e9; color:#2e7d32; padding:4px 12px; border-radius:20px; font-weight:bold; font-size:0.85em; }
    .badge-unpaid { background:#fff8e1; color:#f57f17; padding:4px 12px; border-radius:20px; font-weight:bold; font-size:0.85em; }
    .stats-row { display:flex; gap:16px; margin-bottom:24px; flex-wrap:wrap; }
    .stat-card { flex:1; min-width:160px; padding:18px 22px; border-radius:10px; box-shadow:0 2px 6px rgba(0,0,0,0.08); }
    .stat-card.total { background:#e8eaf6; }
    .stat-card.paid { background:#e8f5e9; }
    .stat-card.unpaid { background:#fff8e1; }
    .stat-card .num { font-size:1.6em; font-weight:bold; margin-top:5px; }
    .stat-card.paid .num { color:#2e7d32; }
    .stat-card.unpaid .num { color:#f57f17; }
    .stat-card.total .num { color:#1a237e; }
    .btn-show { background:#1a237e; color:white; padding:6px 14px; border-radius:4px; text-decoration:none; font-size:0.85em; }
</style>

<h1>Gestion des Factures</h1>
<hr>

@if(session('success'))
    <div style="background:#e8f5e9; border:1px solid #a5d6a7; padding:12px; border-radius:6px; margin-bottom:15px; color:#2e7d32;">
        ✅ {{ session('success') }}
    </div>
@endif

{{-- Stats --}}
<div class="stats-row">
    <div class="stat-card total">
        <div>Total factures</div>
        <div class="num">{{ $invoices->count() }}</div>
    </div>
    <div class="stat-card paid">
        <div>Montant encaissé</div>
        <div class="num">{{ number_format($totalPaid, 2) }} MAD</div>
    </div>
    <div class="stat-card unpaid">
        <div>Montant en attente</div>
        <div class="num">{{ number_format($totalUnpaid, 2) }} MAD</div>
    </div>
</div>

{{-- Table --}}
<table class="inv-table">
    <thead>
        <tr>
            <th>#</th>
            <th>Client</th>
            <th>Commande</th>
            <th>Date</th>
            <th>Remise</th>
            <th>Total</th>
            <th>Statut</th>
            <th>Payé le</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @forelse($invoices as $invoice)
            @php
                $order  = $invoice->Order;
                $client = $order?->Client;
            @endphp
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>
                    @if($client)
                        {{ $client->fname }} {{ $client->lname }}
                    @else
                        <span style="color:gray;">—</span>
                    @endif
                </td>
                <td>
                    @if($order)
                        <a href="{{ route('showOrder', $order) }}" style="color:#1a237e;">
                            CMD-{{ $order->id }}: {{ Str::limit($order->title, 25) }}
                        </a>
                    @else
                        <span style="color:gray;">—</span>
                    @endif
                </td>
                <td>{{ $invoice->created_at->format('d/m/Y') }}</td>
                <td>{{ $invoice->discount_percentage }}%</td>
                <td><strong>{{ number_format($invoice->total_price, 2) }} MAD</strong></td>
                <td>
                    @if($invoice->payment_status === 'paid')
                        <span class="badge-paid">✅ Payée</span>
                    @else
                        <span class="badge-unpaid">⏳ En attente</span>
                    @endif
                </td>
                <td>
                    @if($invoice->payment_date)
                        {{ \Carbon\Carbon::parse($invoice->payment_date)->format('d/m/Y') }}
                    @else
                        <span style="color:#ccc;">—</span>
                    @endif
                </td>
                <td>
                    @if($order)
                        <a class="btn-show" href="{{ route('showOrder', $order) }}">Voir</a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="9" style="text-align:center; padding:30px; color:gray;">
                    Aucune facture disponible
                </td>
            </tr>
        @endforelse
    </tbody>
</table>

@endsection