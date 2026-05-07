{{-- comment 
@extends('layouts.website-main')
@section('content')
    <form action="{{route('userRegister')}}" method="post">
        @csrf






        <label for="city">city</label><br>
        <input type="text" name="city" id="city"><br><br>



    </form>
@endsection
--}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ URL::asset('css/signin.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    <title>S'inscrire</title>
</head>
<body>
    <form action="{{route('userRegister')}}" method="post" name="formfill"  id="my-form">
        @csrf
        <div class="wrapper">
          <h1>s'inscrire</h1>
          
          <div class="input-data">
             <input type="text" name="fname" id="fname-name"  autocomplete="off"  onkeyup="validatefname()" onsubmit="validatefname()"> 
             <div class="underline"></div> 
             <label id="fname-label" > <i class="fa-solid fa-user icon"></i> Nom </label>
             <span id="fname-error"></span>
          </div>

          <div class="input-data">
            <input type="text" name="lname" id="lname-name"  autocomplete="off"  onkeyup="validatelname()" onsubmit="validatelname()"> 
            <div class="underline"></div> 
            <label id="lname-label" > <i class="fa-solid fa-user icon"></i> Prénom </label>
            <span id="lname-error"></span>
         </div>

         <div class="input-data">
            <input type="text" name="company" id="comp-name" autocomplete="off" onkeyup="validatecomp()" >
            <div class="underline"></div>
            <label id="comp-label"><i class="fa-solid fa-user-tie"></i> Entreprise</label>
            <span id="comp-error"></span>
         </div>


            <input type="text" name="country" value="Algérie" hidden>

            <div class="input-data">
                <input type="text" name="city" id="city-name" autocomplete="off" onkeyup="validatecity()" >
                <div class="underline"></div>
                <label id="city-label"><i class="fa-solid fa-map"></i> Ville</label>
                <span id="city-error"></span>
             </div>

            <div class="input-data">
                <input type="text" name="adress" id="adress-name" autocomplete="off" onkeyup="validateadress()" >
                <div class="underline"></div>
                <label id="adress-label"><i class="fa-solid fa-location-dot"></i> Adress</label>
                <span id="adress-error"></span>
             </div>
          
           
            <div class="input-data">
                <input type="number" name="zip" id="zip" autocomplete="off" onkeyup="validatezip()" >
                <div class="underline"></div>
                <label id="zip-label"><i class="fa-solid fa-hashtag"></i> Code ZIP</label>
                <span id="zip-error"></span>
             </div>
          
             <div class="input-data">
                <input type="email" name="email" id="email" autocomplete="off" onkeyup="validateemail()" >
                <div class="underline"></div>
                <label id="email-label"><i class="fa-solid fa-envelope iconemail"></i> Email</label>
                <span id="email-error"></span>
             </div>

             <div class="input-data">
                <input type="tel" name="phone" id="phone" autocomplete="off" onkeyup="validatephone()" >
                <div class="underline"></div>
                <label id="phone-label"><i class="fa-solid fa-phone"></i> Téléphone</label>
                <span id="phone-error"></span>
             </div>
            
          <div class="input-data">
            <input type="password" name="password" id="pwd" autocomplete="off" onkeyup="validatepwd()" >
            <div class="underline"></div>
            <label id="pwd-label"><i class="fa-solid fa-lock icon"></i> Mot de Passe</label>
            <span id="pwd-error"></span>
         </div>
         <div class="input-data">
            <input type="password" name="cpwd" id="cpwd" onkeyup="validatecpwd()">
            <div class="underline"></div>
            <label id="cpwd-label"><i class="fa-solid fa-lock icon"></i> Confirmer Mot de Passe</label>
            <span id="cpwd-error"></span>
         </div>
        
        
         <input type="submit" name="" value="s'inscrire" onclick="return validateform()">
         <span id="submit-error"></span>
        
        </div>
        </form>
      <script src="{{ URL::asset('js/signin.js')}}"></script>
</body>
</html>