@extends('layouts.app')

@section('title', $title ?? 'My Account — ArtsDiva')

@section('content')
<section class="account">
    <div class="account__shell container">
        <aside class="account-rail" aria-label="Account">
            <div class="account-rail__brand">
                <p class="account-rail__kicker">Collector space</p>
                <p class="account-rail__name">{{ auth()->user()->name }}</p>
            </div>
            <nav class="account-nav">
                <a href="{{ route('account.dashboard') }}" class="{{ request()->routeIs('account.dashboard') ? 'is-active' : '' }}">
                    <span class="account-nav__idx">01</span>
                    <span>Overview</span>
                </a>
                <a href="{{ route('account.purchases') }}" class="{{ request()->routeIs('account.purchases') ? 'is-active' : '' }}">
                    <span class="account-nav__idx">02</span>
                    <span>Purchases</span>
                </a>
                <a href="{{ route('account.wishlist') }}" class="{{ request()->routeIs('account.wishlist') ? 'is-active' : '' }}">
                    <span class="account-nav__idx">03</span>
                    <span>Wishlist</span>
                </a>
                <a href="{{ route('account.profile') }}" class="{{ request()->routeIs('account.profile') ? 'is-active' : '' }}">
                    <span class="account-nav__idx">04</span>
                    <span>Profile</span>
                </a>
                <a href="{{ route('catalogue.index') }}" class="account-nav__ghost">
                    <span class="account-nav__idx">→</span>
                    <span>Catalogue</span>
                </a>
            </nav>
            <form method="POST" action="{{ route('account.logout') }}" class="account-rail__foot">
                @csrf
                <button type="submit" class="account__logout">Sign out</button>
            </form>
        </aside>

        <div class="account__canvas">
            <header class="account__hero">
                <div>
                    <p class="account__eyebrow">My account</p>
                    <h1 class="account__title">{{ $heading ?? 'Dashboard' }}</h1>
                </div>
            </header>

            @if(session('success'))
                <div class="account-flash account-flash--ok">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="account-flash account-flash--err">{{ session('error') }}</div>
            @endif

            <div class="account__main">
                @yield('account')
            </div>
        </div>
    </div>
</section>
@endsection
