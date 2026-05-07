@extends('layouts.website-main')
<head>
  <link rel="stylesheet" href="{{ URL::asset('css/ventelogiciel.css')}}" >
</head>
@section('title')
Logiciels
@endsection
@section('content')
    
    <div class="container">
      <br><br>
      <div><p class="lien"><a href="{{route('main')}}">Acceuil </a>/ Logiciels</p></div>
        <div class="logiciel-section">
        
            @foreach ($softwares as $item)
                @php
                    $content = $item->prod_images()->get();
                    $imgPath = '';
                    if(count($content) > 0){
                        $imgPath = $content[0]->path;
                    }else{
                        $imgPath = 'pre_assets/img/empty-img.png';
                    }
                @endphp
            <a href="{{route('swSiteShow', $item)}}">
               <div class="logiciel-card">
                    <img src="{{asset('images/products/' . $imgPath)}}" class="logiciel-img">
                    <p class="nom nomp">{{$item->name}}</p>
                    <p class="nom">{{$item->header}}</p>
                    <p class="prix">{{$item->price}} DH
                    @if ($item->payment == 'subscription')
                    /Mois
                    @endif
                    </p>
               </div>
            </a>
            @endforeach
        </div>

        {{-- Pagination --}}
        <div class="pagination-container">
            {{ $softwares->links() }}
        </div>

    </div>
@endsection