@extends('layouts.website-main')

<head>
    <link rel="stylesheet" href="{{ URL::asset('css/laptops.css')}}">
</head>

@section('title')
Matériels
@endsection

@section('content')

<br><br>

<div class="container">

<div>
<p class="lien">
<a href="{{route('main')}}">Acceuil</a> / Matériel informatiques
</p>
</div>

<div class="laptop-section">

@foreach ($hardwares as $item)

@php
$image = DB::table('prod_images')
    ->where('prod_id', $item->id)
    ->where('prod_category','hardware')
    ->first();

$rawPath  = $image ? $image->path : null;
$imgPath  = $rawPath
    ? preg_replace('#^images/products/#', '', $rawPath)
    : 'empty-img.png';
@endphp

<a href="{{route('hwSiteShow', $item)}}">
<div class="laptop-card">
<img src="{{ asset('images/products/'.$imgPath) }}" class="laptop-img">
<p class="nom">{{$item->name}}</p>
<p class="prix">{{$item->price}} DH</p>
</div>
</a>

@endforeach

</div>

<div class="pagination-container">
    {{ $hardwares->links() }}
</div>

</div>

<script src="{{ URL::asset('js/homepage.js')}}"></script>

@endsection
