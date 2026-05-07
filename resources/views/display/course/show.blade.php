@extends('layouts.website-main')

<head>
<link rel="stylesheet" href="{{ asset('css/f-vmware.css')}}">
</head>

@section('title')
{{$course->name}}
@endsection

@section('content')

<br><br>

<div class="container vmware-info">

{{-- CORRECTION: lecture du path depuis la base de données --}}
<img src="{{ asset('images/' . $course->image) }}" class="vmware-photo">

<h1>{{$course->name}}</h1>
<h2>{{$course->header}}</h2>

<p>{{$course->desc}}</p>

@php
$category = $course->prod_category;
$id = $course->id;
@endphp

<br>

<form action="{{route('addProductToList', compact('category','id'))}}" method="get">

<label>Nombre de licences</label>

<input type="number" name="volume" value="1" style="width:60px">

<input type="submit" value="Ajouter au panier">

</form>

</div>

@endsection