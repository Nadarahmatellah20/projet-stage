@extends('layouts.website-main')

<head>
    <link rel="stylesheet" href="{{ asset('css/pc.css') }}">
</head>

@section('title')
    {{$hardware->name}}
@endsection

@section('content')

<br><br>

<div class="container product">

    <div>
        <p class="lien">
            <a href="{{route('main')}}">Acceuil</a> /
            <a href="#">Matériels</a> /
            {{$hardware->name}}
        </p>
    </div>

    <div class="box">

        <div class="images" id="imageGallery">

            @php $content = $hardware->prod_images; @endphp

            @if($content->count())
                @foreach($content as $key => $img)
                @php $cleanPath = preg_replace('#^images/products/#', '', $img->path); @endphp
                <div class="img-holder {{ $key == 0 ? 'active' : '' }}">
                    <img src="{{ asset('images/products/' . $cleanPath) }}" onclick="addActiveClass(this)">
                </div>
                @endforeach
            @else
                <div class="img-holder active">
                    <img src="{{ asset('images/no-image.png') }}">
                </div>
            @endif

        </div>

        <div class="basic-info">

            <h1>{{$hardware->name}}</h1>
            <p class="entete">{{$hardware->header}}</p>
            <div class="description">{!! $hardware->desc !!}</div>
            <span class="price">{{$hardware->price}} DH</span>

            <form action="{{ route('addProductToList', ['category' => 'hardwares', 'id' => $hardware->id]) }}" method="get">
                <label>Qté</label>
                <input type="number" name="volume" value="1" style="width:60px;height:30px">
                <button type="submit" class="panier-btn">Ajouter au Panier</button>
            </form>

        </div>

    </div>

    @if($hardware->datasheet)
        <p class="fiche">Fiche Technique</p>
        <div id="fiche-technique">{!! $hardware->datasheet !!}</div>
    @endif

</div>

<script src="{{ asset('js/pc.js') }}"></script>

@endsection
