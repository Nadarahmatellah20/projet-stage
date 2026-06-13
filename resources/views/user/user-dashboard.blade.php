@extends('layouts.website-main')

@section('title', 'Tableau de bord')

@section('content')

<link rel="stylesheet" href="{{ asset('style/orders-style.css') }}">
<link rel="stylesheet" href="{{ asset('style/dashboard.css') }}">
<div class="db-main">

<div class="dashboard-hero">
    <div>
        <span class="dashboard-label">Espace client</span>
        <h1 class="title">Tableau de bord utilisateur</h1>
        <p>Gerez votre compte, vos commandes, vos tickets et vos avis depuis un seul espace.</p>
    </div>
    <a href="{{route('newOrderForm')}}" class="dashboard-cta">
        <i class="fa-solid fa-plus"></i>
        Nouvelle commande
    </a>
</div>

<div class="db-wrapper">

<div class="left-panel">

<div class="profile-mini">
    <div class="avatar">
        {{ strtoupper(substr(Auth::user()->fname ?? Auth::user()->email ?? 'U', 0, 1)) }}
    </div>
    <div>
        <strong>{{ Auth::user()->fname ?? 'Utilisateur' }}</strong>
        <span>{{ Auth::user()->email ?? '' }}</span>
    </div>
</div>

<h3 class="db-h3">Compte</h3>
<ul class="sidebar-menu">
<li><a href="{{route('userAccountSettings')}}" class="{{ request()->routeIs('userAccountSettings') ? 'active' : '' }}"><i class="fa-solid fa-user-gear"></i><span>Paramètres du compte</span></a></li>
</ul>

<h3 class="db-h3">Commandes</h3>
<ul class="sidebar-menu">
<li><a href="{{route('newOrderForm')}}" class="{{ request()->routeIs('newOrderForm') ? 'active' : '' }}"><i class="fa-solid fa-cart-plus"></i><span>Nouvelle commande</span></a></li>
<li><a href="{{route('displayAllOrders')}}" class="{{ request()->routeIs('displayAllOrders', 'displayOrder', 'displayInvoice') ? 'active' : '' }}"><i class="fa-solid fa-truck-fast"></i><span>Suivi des commandes</span></a></li>
</ul>

<h3 class="db-h3">Assistance</h3>
<ul class="sidebar-menu">
<li><a href="{{route('newTicketForm')}}" class="{{ request()->routeIs('newTicketForm') ? 'active' : '' }}"><i class="fa-solid fa-ticket"></i><span>Nouveau ticket</span></a></li>
<li><a href="{{route('userIndexOngoingTickets')}}" class="{{ request()->routeIs('userIndexOngoingTickets', 'userShowTicket') ? 'active' : '' }}"><i class="fa-solid fa-spinner"></i><span>En cours</span></a></li>
<li><a href="{{route('userIndexClosedTickets')}}" class="{{ request()->routeIs('userIndexClosedTickets') ? 'active' : '' }}"><i class="fa-solid fa-circle-check"></i><span>Tickets résolus</span></a></li>
</ul>

<h3 class="db-h3">Avis</h3>
<ul class="sidebar-menu">
<li><a href="{{route('indexForUser')}}" class="{{ request()->routeIs('indexForUser') ? 'active' : '' }}"><i class="fa-solid fa-star"></i><span>Vos avis</span></a></li>
</ul>

</div>
<div class="right-panel">
    @hasSection('section-content')
        @yield('section-content')
    @else
        <div class="dashboard-overview">
            <div class="welcome-card">
                <span>Bienvenue</span>
                <h2>{{ Auth::user()->fname ?? 'Utilisateur' }}</h2>
                <p>Choisissez une action rapide ou utilisez le menu a gauche pour continuer.</p>
            </div>

            <div class="quick-grid">
                <a href="{{route('userAccountSettings')}}" class="quick-card">
                    <i class="fa-solid fa-user-gear"></i>
                    <strong>Compte</strong>
                    <span>Modifier vos informations</span>
                </a>
                <a href="{{route('newOrderForm')}}" class="quick-card">
                    <i class="fa-solid fa-cart-plus"></i>
                    <strong>Commande</strong>
                    <span>Envoyer une nouvelle demande</span>
                </a>
                <a href="{{route('userIndexOngoingTickets')}}" class="quick-card">
                    <i class="fa-solid fa-headset"></i>
                    <strong>Assistance</strong>
                    <span>Suivre vos tickets</span>
                </a>
                <a href="{{route('indexForUser')}}" class="quick-card">
                    <i class="fa-solid fa-star"></i>
                    <strong>Avis</strong>
                    <span>Consulter vos reviews</span>
                </a>
            </div>
        </div>
    @endif
</div>
</div>
</div>
@endsection
