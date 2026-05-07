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
                <th>Produit</th>
                <th>Rate</th>
                <th>Review</th>
                <th>Option</th>
            </tr>
            
     @foreach ($reviews as $rev)

@php
$prod = $rev->Service ?? $rev->Course;
@endphp

<tr class="item-container">
<td style="width: 15%; font-size: 15px; color:rgb(126, 126, 126);">
<p>{{$rev->created_at}}</p>
</td>

@if ($prod && $prod->prod_category == 'service')
<td><a href="{{route('svSiteShow',$prod)}}">{{$prod->name}}</a></td>
@elseif($prod)
<td><a href="{{route('crSiteShow',$prod)}}">{{$prod->name}}</a></td>
@endif

<td><p>{{$rev->stars}}</p></td>
<td><p>{{$rev->review}}</p></td>
<td><a href="{{route('removeReview',$rev)}}">Delete</a></td>

</tr>

@endforeach
        </table>
    </div>
@endsection