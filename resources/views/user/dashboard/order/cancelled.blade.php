<head>
    <link rel="stylesheet" href="{{ URL::asset('style/orders-style.css')}}">
</head>

@extends('user.user-dashboard')

@section('section-content')
    <div class="index-wrapper">
        <h2 style="margin-bottom:16px;">Commandes Annulées</h2>

        @if($orders->isEmpty())
            <p>Aucune commande annulée.</p>
        @else
        <table>
            <tr>
                <th>Titre</th>
                <th>Statut</th>
                <th>Date</th>
            </tr>

            @foreach ($orders as $order)
            <tr class="item-container">
                <div class="item">
                    <td><a href="{{ route('displayOrder', $order) }}">{{ $order->title }}</a></td>
                    <td><p style="color:red;">Annulée</p></td>
                    <td><p>{{ $order->updated_at->format('d/m/Y') }}</p></td>
                </div>
            </tr>
            @endforeach
        </table>
        @endif
    </div>
@endsection
