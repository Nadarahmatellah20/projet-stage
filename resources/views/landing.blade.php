<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/smooth-scroll@16.1.3/dist/smooth-scroll.polyfills.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <script type="text/javascript" src="slick.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick-theme.min.css" integrity="sha512-17EgCFERpgZKcm0j0fEq1YCJuyAWdz9KUtv1EjVuaOz8pDnh/0nZxmU6BBXwaaxqoi9PQXnRWqlcDB027hgv9A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.css" integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="css/style.css" >
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Acceuil</title>
    <script>
      var scroll = new SmoothScroll('a[href*="#"]');
    </script>
    
    
</head>
<body>
    <!-- start header-->
    <div class="main">
    <header>
     <div class="container">
       
        
        <a href="{{route('main')}}"><img class="logo" src="images/logo.png"></a>
        
        
        <nav class="navigation">
            <ul>
                <li><a href="{{route('main')}}" class="home"> Acceuil</a></li>
             <li class="menu">
    <a href="{{route('main')}}#services" class="services"> Services</a> 
    <i class="fa-sharp fa-solid fa-caret-down fa-xs dropicon" onclick="toggleDropdown()"></i>

    <ul class="dropdown" id="dropdown">
        <li><a href="{{route('hwSiteIndex')}}">Vente Matériel</a></li>
        <li><a href="{{route('swSiteIndex')}}">Vente Logiciel</a></li>

        @foreach ($servicesList as $service)
            <li>
                <a href="{{route('svSiteShow', $service)}}">
                    {{ $service->name }}
                </a>
            </li>
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
    <div class="container">
      <div class="col-2">
        <h1><span>Améliorez</span> votre technologie <br>avec les meilleurs matériels <br>et logiciels informatiques</h1>
        <p>Des innovations technologiques pour stimuler<br> votre croissance et votre efficacité</p>
        
        @if (!Auth::check())
        <a href="{{route('registerForm')}}" class="signin_btn">S'inscrire</a>
        <a href="{{route('loginForm')}}" class="login_btn">Se connecter</a>
        @endif
      </div>
       
    </div>
  </div>
    <!-- end header-->

    <!-- start hero section-->
    
    <!-- end hero section-->

    <!-- start about section-->
    
    <div class="container about animate-on-visit" data-aos="fadeInLeft" data-aos-once="true"  id="about">
      <div class="about-sec">
        
      <h3>
        U-Tech a à cœur de <br> 
         de contribuer au développement <br>numérique de Maroc et de l’Afrique
      </h3>
      <p>nous sommes passionnés par la technologie 
        et nous sommes déterminés à offrir des solutions innovantes
         pour répondre aux besoins de nos clients. 
        Nous sommes fiers de notre engagement envers la qualité
        , l'innovation et le service à la clientèle</p>
      </div>
      <div class="about-sec">
        <img src="images/about.jpg" class="about-img">
      </div>
    </div>
  
    <!--end about section-->
    <div class="services-sec" id="services">
        <div class=" services-section">
              <h1>Nos Services</h1>
              
              <div class="cards-section container">
                  <a href="{{route('hwSiteIndex')}}">
                     <div>
                        <i class="fa-solid fa-cart-arrow-down"></i>
                         <h2>Vente matériel</h2>
                         <p>le bon produit pour la bonne solution </p>
                      </div>
                  </a>

                  <a href="{{route('swSiteIndex')}}">
                     <div>
                      <i class="fa-solid fa-sliders"></i>
                         <h2>Vente logiciel</h2>
                         <p>Les meilleures solutions logiciels sur le marché  </p>
                      </div>
                  </a>


                  <a href="{{route('crSiteIndex')}}">
                    <div>
                      <i class="fa-solid fa-user-graduate"></i>
                        <h2>Formations</h2>
                        <p>développer vos compétences informatiques rapidement </p>
                     </div>
                 </a>
                 
                 @foreach ($servicesList as $service)
                    <a href="{{route('svSiteShow', $service)}}" class="grid-card" >
                     <div>
                       <i class="fa-solid fa-gears"></i>
                         <h2>{{$service->name}}</h2>
                         <p>{{$service->header}}</p>
                      </div>
                   </a>
                    @endforeach
              
             </div>
               
                   
        </div>
      </div>
      <!-- end services section-->


      <!--start clients review-->
   <div class="client-section"><!--container-->

                     
                 <div class="title-section">
                     <h1>Nos Clients</h1>
                     
                 </div>
   

            <div class=" container clients">
                <div class="client-card">
                   <!--<img src="images/about.jpg" class="client-photo">-->
                   <div class="client-para">
                    <div class="client-photo">
                      <img src="images/beko.png" class="beko">
                    </div>
                    <p class="avis">Je suis extrêmement satisfait de la sélection 
                      de produits proposés par U-tech. Ils ont une gamme
                        vaste et diversifiée qui répond à tous mes besoins. Que ce soit pour des 
                        logiciels de conception,ou
                       des périphériques , je peux trouver tout ce dont j'ai besoin en un seul endroit.
                    </p>
                  <div class="cname">
                    <h3>Beko</h3>
                    <div class="stars">
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star-half"></i>
                    </div>
                  </div>
                  </div>
                  
                   
              </div>


               <div class="client-card">
                  <!-- <img src="images/about.jpg" class="client-photo">--> 
                  <div class="client-para">
                    <div class="client-photo">
                      <img src="images/sim.jpg" class="beko">
                    </div>
                    <p class="avis">Je tiens à souligner l'incroyable expertise en matière
                       de conseil et de formation de ce site. L'équipe m'a fourni 
                       des conseils précieux pour
                       choisir les bons logiciels et matériels informatiques 
                       en fonction de mes besoins spécifiques
                    </p>
                  <div class="cname">
                    <h3>Sim</h3>
                    <div class="stars">
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star-half"></i>
                    </div>
                  </div>
                  </div>
                 
                
               </div>


               <div class="client-card">
              <!--<img src="images/about.jpg" class="client-photo">-->
                  <div class="client-para">
                    <div class="client-photo">
                      <img src="images/carrefour.jpg" class="beko">
                    </div>
                    <p class="avis">Je suis extrêmement satisfait du service après-vente de ce site. L'équipe a vraiment su aller 
                      au-delà de mes attentes pour résoudre mes problèmes et répondre à mes préoccupations
                    </p>
                  <div class="cname">
                    <h3>Carrefour</h3>
                    <div class="stars">
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star"></i>
                      <i class="fa fa-star-half"></i>
                    </div>
                  </div>
                  </div>
                 
               </div>

               <div class="client-card">
                <!--<img src="images/about.jpg" class="client-photo">-->
                    <div class="client-para">
                      <div class="client-photo">
                        <img src="images/sonelgaz.jpg" class="beko">
                      </div>
                      <p class="avis">l'équipe de formation a été très réactive et flexible pour répondre
                         à mes besoins spécifiques. Ils ont pu adapter les programmes pour tenir 
                         compte de mes connaissances préalables et de mon 
                        rythme d'apprentissage. Cela a rendu l'expérience de formation
                         vraiment personnalisée et efficace.
                      </p>
                    <div class="cname">
                      <h3>Sonelgaz</h3>
                      <div class="stars">
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star"></i>
                        <i class="fa fa-star-half"></i>
                      </div>
                    </div>
                    </div>
                    
                 </div>

                 <div class="client-card">
                  <!--<img src="images/about.jpg" class="client-photo">-->
                      <div class="client-para">
                        <div class="client-photo">
                          <img src="images/jgc.png">
                        </div>
                        <p class="avis"> j'apprécie également le suivi après la résolution du problème.
                           L'équipe du service après-vente a pris
                           la peine de vérifier que tout était en ordre et que je 
                           suis satisfait de la solution apportée
                        </p>
                      <div class="cname">
                        <h3>JGC</h3>
                        <div class="stars">
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star"></i>
                          <i class="fa fa-star-half"></i>
                        </div>
                      </div>
                      
                      </div>
                   </div>
                   
              </div>
   </div>
   <!--FAQ section-->
             <div class="faq-section" >
                    <div class="faq-title animate-on-visit animate__delay-0.5s" data-aos="fadeInLeft" data-aos-once="true">
                          <h1>Foire Aux Questions </h1>
                    </div>
                    <div class="container faq animate-on-visit animate__delay-0.5s" data-aos="fadeInRight" data-aos-once="true">
                        <div class="faq-img">
                          <img src="images/faq.svg" class="faq-image">
                        </div>
                      <div class="question-section">
                        <div class="question-answer">
                          <div class="question">
                              <h3 class="title-question">
                                Quel type de matériel informatique vendez-vous?
                              </h3>
                              <button class="question-btn">
                                  <span class="up-icon">
                                    <i class="fas fa-chevron-up"></i>
                                  </span>

                                  <span class="down-icon">
                                    <i class="fas fa-chevron-down"></i>
                                  </span>
                              </button>
                          </div>
                              <div class="answer">
                                   <p>vend du matériel informatique commercial qui est conçu pour durer plus longtemps</p>
                              </div>
                        </div>


                        <div class="question-answer">
                          <div class="question">
                              <h3 class="title-question">
                                À qui s'adressent nos services de vente de produits ?
                              </h3>
                              <button class="question-btn">
                                  <span class="up-icon">
                                    <i class="fas fa-chevron-up"></i>
                                  </span>

                                  <span class="down-icon">
                                    <i class="fas fa-chevron-down"></i>
                                  </span>
                              </button>
                          </div>
                              <div class="answer">
                                   <p>Nos services de ventes de produits s’adressent aux entreprises de toute taille !</p>
                              </div>
                        </div>


                        <div class="question-answer">
                          <div class="question">
                              <h3 class="title-question">
                                Est-ce que on offre de service aprés vente?
                              </h3>
                              <button class="question-btn">
                                  <span class="up-icon">
                                    <i class="fas fa-chevron-up"></i>
                                  </span>

                                  <span class="down-icon">
                                    <i class="fas fa-chevron-down"></i>
                                  </span>
                              </button>
                          </div>
                              <div class="answer">
                                   <p>le service apre vente est disponible pour toute nos produit </p>
                              </div>
                        </div>



                        <div class="question-answer">
                          <div class="question">
                              <h3 class="title-question">
                                À qui s'adressent nos services-conseils ?
                              </h3>
                              <button class="question-btn">
                                  <span class="up-icon">
                                    <i class="fas fa-chevron-up"></i>
                                  </span>

                                  <span class="down-icon">
                                    <i class="fas fa-chevron-down"></i>
                                  </span>
                              </button>
                          </div>
                              <div class="answer">
                                   <p>Nos services-conseils s’adressent aux petites, moyennes et grandes entreprises désireuses de démarrer un projet de virtualisation, de virtualisation de postes de travail, Cloud, architecture et stratégies TI,
                                     d’intégration et déploiement de solutions, de reprise après sinistre et de mobilité.</p>
                              </div>
                        </div>
                      </div>
                    </div>
             </div>



   <!--End FAQ section-->

   <!--footer-->
   <hr>
   <footer>
       <div class="container">
           <div class="flex-box">
                 <div class="img">
                     <img src="images/logo.png" >
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
       
       <div class="bottom">
        <p>Powered by <span>Tech</span> - Designed by <span>Nada.OFPPT</span></p>
     </div>
   </footer>
   <!--end footer-->

          <script src="js/homepage.js"></script>
          <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
          <script  type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js" ></script>
          
          <script type="text/javascript">
            $('.container.clients').slick({
              prevArrow:'<button type="button" class="slick-prev"><i class="fa fa-chevron-left"></i></button>',
              nextArrow:'<button type="button" class="slick-next"><i class="fa fa-chevron-right"></i></button>',
                 slidesToShow: 3,
                   slidesToScroll: 1
              });
          </script>
      
</body>
</html>