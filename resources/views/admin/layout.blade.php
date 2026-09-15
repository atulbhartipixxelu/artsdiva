<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('partials.developer-signature')
    <title>@yield('title', 'Admin') — ArtsDiva</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin-body">
<aside class="admin-sidebar" data-admin-sidebar>
    <a class="admin-brand" href="{{ route('admin.dashboard') }}">
        <span class="admin-brand__mark">A</span>
        <span class="admin-brand__text">ArtsDiva</span>
    </a>

    <nav class="admin-nav" aria-label="Admin">
        <p class="admin-nav__label">Overview</p>
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <span class="admin-nav__icon" aria-hidden="true">▦</span> Dashboard
        </a>

        <p class="admin-nav__label">Catalogue</p>
        <a href="{{ route('admin.artworks.index') }}" class="{{ request()->routeIs('admin.artworks.*') ? 'active' : '' }}">
            <span class="admin-nav__icon" aria-hidden="true">▣</span> Artworks
        </a>
        <a href="{{ route('admin.artists.index') }}" class="{{ request()->routeIs('admin.artists.*') ? 'active' : '' }}">
            <span class="admin-nav__icon" aria-hidden="true">◎</span> Artists
        </a>
        <a href="{{ route('admin.hero.index') }}" class="{{ request()->routeIs('admin.hero.*') ? 'active' : '' }}">
            <span class="admin-nav__icon" aria-hidden="true">▭</span> Hero Slides
        </a>

        <p class="admin-nav__label">Content</p>
        <a href="{{ route('admin.exhibitions.index') }}" class="{{ request()->routeIs('admin.exhibitions.*') ? 'active' : '' }}">
            <span class="admin-nav__icon" aria-hidden="true">▢</span> Exhibitions
        </a>
        <a href="{{ route('admin.events.index') }}" class="{{ request()->routeIs('admin.events.*') ? 'active' : '' }}">
            <span class="admin-nav__icon" aria-hidden="true">◷</span> Events
        </a>
        <a href="{{ route('admin.news.index') }}" class="{{ request()->routeIs('admin.news.*') ? 'active' : '' }}">
            <span class="admin-nav__icon" aria-hidden="true">☰</span> News
        </a>
        <a href="{{ route('admin.publications.index') }}" class="{{ request()->routeIs('admin.publications.*') ? 'active' : '' }}">
            <span class="admin-nav__icon" aria-hidden="true">▤</span> Publications
        </a>
        <a href="{{ route('admin.pages.index') }}" class="{{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
            <span class="admin-nav__icon" aria-hidden="true">◇</span> Pages
        </a>

        <p class="admin-nav__label">Operations</p>
        <a href="{{ route('admin.inquiries.index') }}" class="{{ request()->routeIs('admin.inquiries.*') ? 'active' : '' }}">
            <span class="admin-nav__icon" aria-hidden="true">✉</span> Inquiries
        </a>
        @if(auth()->user()?->isSuperAdmin())
            <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <span class="admin-nav__icon" aria-hidden="true">👤</span> Admins
            </a>
        @endif
        <a href="{{ route('home') }}" target="_blank" rel="noopener">
            <span class="admin-nav__icon" aria-hidden="true">↗</span> View Website
        </a>
    </nav>

    <form method="POST" action="{{ route('logout') }}" class="admin-logout">
        @csrf
        <button type="submit">
            <span class="admin-logout__name">{{ auth()->user()->name }}</span>
            <span class="admin-logout__action">Log out</span>
        </button>
    </form>
</aside>

<main class="admin-main">
    <header class="admin-topbar">
        <div class="admin-topbar__left">
            <button type="button" class="admin-menu-btn" data-admin-menu aria-label="Open menu">☰</button>
            <div>
                <h1>@yield('heading', 'Dashboard')</h1>
                <p class="admin-topbar__sub">Manage ArtsDiva content and inventory</p>
            </div>
        </div>
        <div class="admin-topbar__right">
            <form class="admin-search" method="GET" action="{{ route('admin.artworks.index') }}" role="search">
                <span class="admin-search__icon" aria-hidden="true">⌕</span>
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Search artworks, serial, artist…">
            </form>
            <span class="role-badge">{{ strtoupper(auth()->user()->role) }}</span>
            <a class="btn" href="{{ route('admin.artworks.create') }}">+ Add artwork</a>
        </div>
    </header>

    @if(session('success'))
        <div class="flash ok">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="flash err">
            <ul>@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
        </div>
    @endif

    @yield('content')
</main>

<script>
    (function () {
        const btn = document.querySelector('[data-admin-menu]');
        const body = document.body;
        if (!btn) return;
        btn.addEventListener('click', function () {
            body.classList.toggle('admin-nav-open');
        });
    })();
</script>
@include('partials.developer-signature-foot')
</body>
</html>
