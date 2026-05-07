@extends('layouts.website-main')

@section('title')
{{$service->name}}
@endsection

@section('styles')
<link rel="stylesheet" href="{{ asset('css/serviceconseil.css') }}">
<link rel="stylesheet" href="{{ asset('style/reviewstyle.css') }}">
@endsection

@section('content')

<div class="main">
    <div class="container conseil animate-on-visit animate__delay-0.5s" data-aos="fadeInLeft" data-aos-once="true">
        
        <h1>{{ $service->name }}</h1>

        {{-- ✅ IMAGE FIX --}}
        @php
            $img = $service->prod_images->first() ?? null;

            // حل ذكي كيتعامل مع جميع الحالات
            if($img){
                if(str_contains($img->path, 'products/')){
                    $imagePath = asset('images/'.$img->path);
                } else {
                    $imagePath = asset('images/products/'.$img->path);
                }
            } else {
                $imagePath = asset('images/empty-img.png');
            }
        @endphp

        <img src="{{ $imagePath }}" alt="{{ $service->name }}">

        <p>{{ $service->header }}</p>

        <a class="conseil-btn" href="#conseil">Demander Conseil</a>
    </div>
</div>

<div class="page">
{!! $service->page !!}
</div>

<!-- CLIENT REVIEWS -->

<div class="client-section">

<div class="title-section">
<h1>Avis Clients</h1>
</div>

<div class="container clients">

@if($reviews->count() > 0)

@foreach ($reviews as $item)

<div class="client-card">

<div class="client-para">

<div class="client-photo">
<img src="{{ asset('assets/img/user.png')}}" class="beko">
</div>

<p class="avis">{{$item->review}}</p>

<div class="cname">

<h3>
{{ $item->Client->fname ?? 'User' }}
{{ $item->Client->lname ?? '' }}
</h3>

<div class="stars">
@for ($i = 0; $i < $item->stars; $i++)
<i class="fa fa-star"></i>
@endfor
</div>

</div>

</div>

</div>

@endforeach

@else

<p style="text-align:center;">Aucun avis pour ce service</p>

@endif

</div>

<div id="modalAddBtn" class="opinion">
<p class="opinion-btn">Donner votre avis</p>
</div>

</div>

<!-- CONSEIL SECTION -->

<div class="conseil-section" id="conseil">
<div class="container">

<form action="{{ route('addProductToList',['category'=>'service','id'=>$service->id]) }}" method="GET">
<input type="number" name="volume" value="1" hidden>
<input type="submit" class="send-btn" value="DEMANDEZ CONSEIL">
</form>

</div>
</div>

<!-- REVIEW MODAL -->

<div id="myModal" class="modal">
<div class="modal-content">

<div class="modal-header">
<span class="close">&times;</span>
<h2>Ajouter votre avis</h2>
</div>

<div class="modal-body">

<form action="{{ route('addNewReview',['prod_category'=>'service','prod_id'=>$service->id])}}" method="POST">
@csrf

<label>Rate:</label>

<div class="stars-widget">
<label><input type="radio" name="stars" value="5" required> 5</label>
<label><input type="radio" name="stars" value="4"> 4</label>
<label><input type="radio" name="stars" value="3"> 3</label>
<label><input type="radio" name="stars" value="2"> 2</label>
<label><input type="radio" name="stars" value="1"> 1</label>
</div>

<label>Votre avis:</label>
<textarea name="review" cols="80" rows="10" placeholder="Write your review..."></textarea>

<br><br>
<input type="submit" value="Post Review">

</form>

</div>
</div>
</div>

<!-- MODAL SCRIPT -->

<script>
var modal = document.getElementById("myModal");
var btn = document.getElementById("modalAddBtn");
var span = document.getElementsByClassName("close")[0];

btn.onclick = () => modal.style.display = "block";
span.onclick = () => modal.style.display = "none";
window.onclick = (event) => { if (event.target == modal) modal.style.display = "none"; }
</script>

<!-- SLIDER -->

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"></script>

<script>
$('.container.clients').slick({
    prevArrow:'<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
    nextArrow:'<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
    slidesToShow:3,
    slidesToScroll:1
});
</script>

@endsection