<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{URL::asset('style/cp-main.css')}}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>@yield('title')</title>
</head>

<body>
<div class="wrapper">

    <!-- SIDEBAR -->
    <div class="right-panel">

        <div class="logo">
            <h1>U-Tech</h1>
        </div>

        <ul class="nav">

            <!-- HOME -->
            <li class="section">
                <a href="{{route('cp')}}">
                    <div class="section-header">
                        <h1><i class="fa-solid fa-house"></i> Accueil</h1>
                    </div>
                </a>
            </li>

            <!-- PRODUCTS -->
            <li class="section">
                <div class="section-header">
                    <h1><i class="fa-solid fa-server"></i> Gestion des Produits</h1>
                </div>

                <ul class="subsection">
                    <a href="{{route('hardwares.index')}}"><li>Matériel</li></a>
                    <a href="{{route('softwares.index')}}"><li>Logiciel</li></a>
                    <a href="{{route('services.index')}}"><li>Services</li></a>
                    <a href="{{route('courses.index')}}"><li>Formations</li></a>
                </ul>
            </li>

            <!-- ORDERS -->
            <li class="section">
                <div class="section-header">
                    <h1><i class="fa-solid fa-folder-closed"></i> Gestion des Commandes</h1>
                </div>

                <ul class="subsection">
                    <a href="{{route('indexPendingOrders')}}"><li>En Attente</li></a>
                    <a href="{{route('indexDeliveringOrders')}}"><li>En Livraison</li></a>
                    <a href="{{route('indexCompletedOrders')}}"><li>Complété</li></a>
                    <a href="{{route('indexArchivedOrders')}}"><li>Archivé</li></a>
                </ul>
            </li>

            <!-- SUPPORT -->
            <li class="section">
                <div class="section-header">
                    <h1><i class="fa-solid fa-ticket"></i> Support Client</h1>
                </div>

                <ul class="subsection">
                    <a href="{{route('adminIndexOngoingTickets')}}"><li>En Cours</li></a>
                    <a href="{{route('adminIndexClosedTickets')}}"><li>Fermé</li></a>
                    <a href="{{route('adminIndexArchivedTickets')}}"><li>Archivé</li></a>
                </ul>
            </li>

            <!-- ACCOUNTS -->
            <li class="section">
                <div class="section-header">
                    <h1><i class="fa-solid fa-user-plus"></i> Accounts</h1>
                </div>

                <ul class="subsection">
                    <a href="{{route('users.index')}}"><li>Utilisateurs</li></a>
                    <a href="{{route('admins.index')}}"><li>Administrateurs</li></a>
                </ul>
            </li>

        </ul>

        <div class="footer">
            <p>Nada 2026</p>
        </div>

    </div>


    <!-- MAIN PAGE -->
    <section class="main">

        <div class="header">

            <a href="{{route('adminProfile')}}" style="font-size:17px;color:white;padding:5px;">
                <i class="fa-solid fa-user"></i>
            </a>

            <a href="{{route('signout')}}" style="font-size:20px;color:white;padding:5px;">
                <i class="fa-solid fa-right-from-bracket"></i>
            </a>

        </div>

        <section class="sub">
            <div class="content">
                @yield('main-content')
            </div>
        </section>

    </section>

</div>
</body>
</html>