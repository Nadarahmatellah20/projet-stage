<head>
    <link rel="stylesheet" href="{{ URL::asset('style/ticket-style.css')}}">
</head>

@extends('user.user-dashboard')
@section('section-content')
<style>
    th, td{
        text-align: left;
        padding: 10px;
        vertical-align:bottom;
    }
</style>
<div class="index-wrapper">
    <table>
        <tr>
            <th>Date</th>
            <th>Titre</th>
            <th>Type</th>
            <th>Statut</th>
            <th>Option</th>
        </tr>
        
    @foreach ($tickets as $ticket)
        <tr class="item-container">
            <div class="item">
                <td style="width: 15%; font-size: 15px; color:rgb(126, 126, 126);"><p>{{$ticket->created_at}}</p></td> 
                <td><p>{{$ticket->title}}</p></td>
                <td>{{$ticket->type}}</td>
                <td><p>{{$ticket->status}}</p></td>
                <td><a href="{{route('userShowTicket', $ticket)}}">Afficher</a></td>
            </div>
        </tr>
    @endforeach
    </table>
</div>
@endsection