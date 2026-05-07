@extends('layouts.website-main')

@section('title')
    {{$software->name}}
@endsection

@section('content')

    <head>
        <link rel="stylesheet" href="{{ asset('css/logiciel.css') }}">
    </head>

    <br><br>

    <div class="container product">

        <div>
            <p class="lien">
                <a href="{{ route('main') }}">Acceuil</a> /
                <a href="{{ route('swSiteIndex') }}">Logiciels</a> /
                {{$software->name}}
            </p>
        </div>

        <div class="box">

            @php
                $imgPath = $software->prod_images->first()->path ?? 'empty-img.png';
            @endphp

            <div class="images" id="imageGallery">

                <div class="img-holder active">
                    <img src="{{ asset('images/products/' . $imgPath) }}" onclick="addActiveClass(this)">
                </div>

            </div>

            <div class="basic-info">

                <h1>{{$software->name}}</h1>

                <p class="entete">{{$software->header}}</p>

                <div class="description">
                    {!! $software->desc !!}
                </div>

                <span class="price">
                    {{$software->price}} DH
                    @if ($software->payment == 'subscription')
                        /Mois
                    @endif
                </span>

                @php
                    $category = 'softwares';
                    $id = $software->id;
                @endphp

                <form action="{{ route('addProductToList', ['category' => $category, 'id' => $id]) }}" method="GET">

                    <label>Qté</label>

                    <input type="number" name="volume" value="1" style="width:60px;height:30px">

                    <button type="submit" class="panier-btn">
                        Ajouter au Panier
                    </button>

                </form>

            </div>

        </div>

    </div>

    <script src="{{ asset('js/pc.js') }}"></script>

@endsection