<head>
    <link rel="stylesheet" href="{{ URL::asset('style/orders-style.css')}}">
</head>

@extends('user.user-dashboard')

@section('section-content')
    <div class="index-wrapper">
        <table>
            <tr>
                <th>Titre</th>
                <th>Etat</th>
                <th>Statut</th>
                <th>Option</th>
            </tr>
            
        @foreach ($orders as $order)    
            <tr class="item-container">
                <div class="item">
                    <td><a href="{{route('displayOrder', $order)}}">{{$order->title}}</a></td>
                    <td><p>{{$order->status}}%</p></td>
                    <td><p>{{$order->order_status}}</p></td>
                    @if ($order->order_status == 'pending')
                    <td><a href="{{route('cancelOrder', $order)}}">Annuler</a></td>
                    @else
                    <td><p>Annuler</p></td>
                    @endif
                </div>
            </tr>
        @endforeach
        </table>
    </div>
@endsection