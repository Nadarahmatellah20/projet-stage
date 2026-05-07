<head>
<link rel="stylesheet" href="{{ URL::asset('style/search.css')}}">
</head>

@extends('layouts.website-main')

@section('title')
Recherche
@endsection

@section('content')

<br><br><br>

<div class="search-wrapper">

@if ($isFound)

{{-- Hardware --}}
@if ($hwProductsList->isNotEmpty())

<h1>Materiels</h1>

@foreach ($hwProductsList as $item)

<div class="search-card">

<h3>{{$item->name}}</h3>
<p>{{$item->header}}</p>

<a href="{{route('hwSiteShow', $item)}}" class="search-btn">
Voir produit
</a>

</div>

@endforeach

@endif


{{-- Software --}}
@if ($swProductsList->isNotEmpty())

<h1>Logiciels</h1>

@foreach ($swProductsList as $item)

<div class="search-card">

<h3>{{$item->name}}</h3>
<p>{{$item->header}}</p>

<a href="{{route('swSiteShow', $item)}}" class="search-btn">
Voir produit
</a>

</div>

@endforeach

@endif


{{-- Courses --}}
@if ($crProductsList->isNotEmpty())

<h1>Formations</h1>

@foreach ($crProductsList as $item)

<div class="search-card">

<h3>{{$item->name}}</h3>
<p>{{$item->header}}</p>

<a href="{{route('crSiteShow', $item)}}" class="search-btn">
Voir produit
</a>

</div>

@endforeach

@endif


{{-- Services --}}
@if ($svProductsList->isNotEmpty())

<h1>Services</h1>

@foreach ($svProductsList as $item)

<div class="search-card">

<h3>{{$item->name}}</h3>
<p>{{$item->header}}</p>

<a href="{{route('svSiteShow', $item)}}" class="search-btn">
Voir produit
</a>

</div>

@endforeach

@endif

@else

<h1>
<i class="fa-solid fa-triangle-exclamation"></i>
Rien n'a été trouvé
</h1>

@endif

</div>

@endsection