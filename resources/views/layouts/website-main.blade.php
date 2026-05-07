<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ URL::asset('css/main.css')}}">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/smooth-scroll@16.1.3/dist/smooth-scroll.polyfills.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script type="text/javascript" src="slick.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @yield('styles')
    <script>
      var scroll = new SmoothScroll('a[href*="#"]');
    </script>
    <title>@yield('title')</title>
</head>
<body>
    <div id="wrapper">
        <!--Header-->
        <header>
            <div class="container">
              
               
               <a href="{{route('main')}}"><img class="logo" src="{{ URL::asset('images/logo.png')}}"></a>
               
               
               <nav class="navigation">
                   <ul>
                       <li><a href="{{route('main')}}" class="home"> Acceuil</a></li>
                       <li class="menu"><a href="{{route('main')}}#services" class="services"> Services</a> <i class="fa-sharp fa-solid fa-caret-down fa-xs dropicon" onclick="toggleDropdown()"></i>
                        <ul class="dropdown" id="dropdown">
                          <li><a href="{{route('hwSiteIndex')}}">Vente Matériel</a></li>
                          <li><a href="{{route('swSiteIndex')}}">Vente Logiciel</a></li>
                           @foreach ($servicesList as $service)
                           <li><a href="{{route('svSiteShow', $service)}}">{{$service->name}}</a></li>
                           @endforeach
                           <li><a href="{{route('crSiteIndex')}}">Formation</a></li>
                       </ul>
                       </li>    
                       <li><a href="{{route('newTicketForm')}}">Contact</a></li>
                       <li><a href="{{route('main')}}#about"> À propos</a></li>
                   </ul>
               </nav>
       
               <div class="icons">
                 <ul>
                   <li>
                     <!--<a href="#" ><i class="fa-solid fa-magnifying-glass"></i></a>-->
                     <div class="content">
                       
                       <form action="{{url('search')}}"  method="get">
                        @csrf
                        <div class="search">
                            <input type="text" name="search" value="" class="search__input" aria-label="search" placeholder="enter your search">
                            <button class="search__submit" aria-label="submit search"><i class="fa-solid fa-magnifying-glass"></i></button>
                          </div>
                        </form>
                     </div>
                   </li>
                   <li><a href="{{route('newOrderForm')}}"><i class="fas fa-shopping-bag"></i></a></li>
                   <li><a href="{{route('userAccountSettings')}}"><i class="fa-solid fa-user"></i></a></li>
                   @if (Auth::check())
                       
                   <li><a href="{{route('userSignOut')}}"><i class="fa-solid fa-right-from-bracket"></i></a></li>
                   @endif
               
                 </ul>
                </div>
           </div>
         
           </header>
        
        <!--Main Content-->
     <main>

@if(session('success'))
<div class="success-msg">
    {{ session('success') }}
</div>
@endif

@yield('content')

</main>
        <!--Footer-->
        <hr>
        <footer>
            <div class="container">
                <div class="flex-box">
                      <div class="img">
                          <img src="{{ URL::asset('images/logo.png')}}" >
                      </div>
     
                      <div class="contact-foot">
                         <h2>Contact</h2>
                         <p>Bonjour, nous sommes toujours
                            ouverts à la coopération et aux suggestions
                            . Contactez-nous de l'une des manières suivantes :
                         </p>
                         <span>Adresse</span>
                         <p>HAY EL OULFA GP O RUE76</p>
                         <span>phone</span>
                         <p>212661107533</p>
                         <span>Email</span>
                         <p>nada@gmail.com</p>
                         <span>equipe technique</span>
                         <p><a href="{{route('newTicketForm')}}" class="footer-contact">contactez-nous</a> </p>
                      </div>
                      <div class="pages">
                         <h2> Nos pages</h2>
                         <p><a href="{{route('main')}}#about">à propos</a></p>
                         <p><a href="{{route('swSiteIndex')}}">Vente Logiciels </a></p>
                         <p><a href="{{route('hwSiteIndex')}}">Vente Matériels </a></p>
                         <p><a href="{{route('crSiteIndex')}}">Fomations</a></p>
                         @foreach ($servicesList as $service)
                           <p><a href="{{route('svSiteShow', $service)}}">{{$service->name}}</a></p>
                           @endforeach
                      </div>
                </div>
     
            </div>
            <script>
setTimeout(function(){
let msg = document.querySelector('.success-msg');
if(msg){
msg.style.display='none';
}
},3000);
</script>
            <div class="bottom">
             <p>Powered by <span>Tech</span> - Designed by <span>Nada OFPPT</span></p>
          </div>
        </footer>
        <!--end footer-->
        <script src="{{ URL::asset('js/homepage.js')}}"></script>
    </div>
</body>
</html>