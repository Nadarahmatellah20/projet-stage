@extends('layouts.website-main')
<head>
    <link rel="stylesheet" href="{{ URL::asset('css/formation.css')}}" >
</head>
@section('title')
Formation
@endsection
@section('content')

    <div class="main">
        
           <div class="container conseil animate-on-visit animate__delay-0.5s" data-aos="fadeInLeft" data-aos-once="true">
            <h1>Service <br>
             formation
            </h1>
            <p><i class="fa-solid fa-check"></i> des formateurs qualifié</p>
            <p><i class="fa-solid fa-check"></i>des formations dans plusieurs domaines</p>
            <p><i class="fa-solid fa-check"></i>programmes de formation sur mesuree</p>
            <a class="conseil-btn" href="#formation">savoir plus</a>
    
            </div>
        
        </div>

        <div class="container conseilpara">
            <div >
             <p>on offre une large gamme des formations pratique 
                et interactive et dans plusieurs domaines, 
                nos formateurs sont hautement qualifiés
                 pour vous aider à maîtriser les compétences nécessaires pour réussir
              </p>
           </div>
        </div>

       <!--formations section-->
       <div class="formation-section " id="formation">
        <div class="formation">
          <h1>Nos Formations</h1>
          <div class="formations container">   
          @foreach ($courses as $item)

<a href="{{route('crSiteShow', $item)}}"> 

<div class="formation-card">

{{-- CORRECTION: lecture du path depuis la base de données --}}
<img src="{{asset('images/' . $item->image)}}" class="formation-photo">

<div>
<h2>{{$item->name}}</h2>
<p>{{$item->header}}</p>
<span>{{$item->price}} DH - {{$item->period}}</span><br>
<span class="prof">présenté par: {{$item->prof}}</span>
</div>

</div>

</a>

@endforeach
         </div>    

         
        </div>
    </div>
       <!--end formation -->

@endsection