@php
    $currencyCode = session('currency', config('artsdiva.default_currency'));
    $currencyMeta = config('artsdiva.currencies.'.$currencyCode);
    $mega = $megaMenu ?? [];
@endphp

<header class="site-header">
    <div class="nav-backdrop" data-nav-backdrop hidden aria-hidden="true"></div>

    <div class="container header-shell">
        <button
            type="button"
            class="nav-toggle"
            data-nav-toggle
            aria-expanded="false"
            aria-controls="main-nav"
            aria-label="Toggle menu"
        >
            <span class="nav-toggle__box" aria-hidden="true">
                <span class="nav-toggle__line"></span>
                <span class="nav-toggle__line"></span>
                <span class="nav-toggle__line"></span>
            </span>
        </button>

        <a class="logo" href="{{ route('home') }}">
            <img src="{{ asset('images/artsdiva-logo.png') }}" alt="ArtsDiva" width="180" height="34">
        </a>

        <nav id="main-nav" class="main-nav" data-main-nav aria-label="Primary">
            <div class="main-nav__panel-head">
                <span class="main-nav__panel-title">Menu</span>
                <button type="button" class="main-nav__close" data-nav-close aria-label="Close menu">×</button>
            </div>

            <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>

            {{-- Catalogue mega --}}
            <div class="nav-item {{ request()->routeIs('catalogue.*') ? 'is-active' : '' }}" data-mega>
                <a
                    href="{{ route('catalogue.index') }}"
                    class="nav-item__trigger {{ request()->routeIs('catalogue.*') ? 'active' : '' }}"
                    data-mega-trigger
                    aria-expanded="false"
                    aria-haspopup="true"
                >Catalogue</a>
                <div class="mega" data-mega-panel hidden>
                    <div class="mega__inner container">
                        <aside class="mega__rail">
                            <p class="mega__eyebrow">Collection</p>
                            <h3 class="mega__title">Catalogue</h3>
                            <p class="mega__blurb">Browse curated works available for acquisition and annual leasing.</p>
                            <a class="mega__cta" href="{{ route('catalogue.index') }}">Browse catalogue</a>
                        </aside>

                        <div class="mega__feature">
                            @php
                                $megaArtworks = collect($mega['artworks'] ?? [])->take(3)->values();
                                $megaLead = $megaArtworks->first();
                                $megaSide = $megaArtworks->slice(1)->values();
                            @endphp
                            @if($megaLead)
                                <a href="{{ route('catalogue.show', $megaLead->slug) }}" class="mega-card mega-card--lead">
                                    <span class="mega-card__media">
                                        <img src="{{ $megaLead->imageUrl() }}" alt="{{ $megaLead->title }}" loading="lazy">
                                        <span class="mega-card__index" aria-hidden="true">01</span>
                                    </span>
                                    <span class="mega-card__meta">
                                        <span class="mega-card__name">{{ $megaLead->title }}</span>
                                        <span class="mega-card__sub">{{ $megaLead->artist?->name ?? 'Artist' }}{{ $megaLead->year ? ' · '.$megaLead->year : '' }}</span>
                                    </span>
                                </a>
                                <div class="mega__side">
                                    @foreach($megaSide as $i => $work)
                                        <a href="{{ route('catalogue.show', $work->slug) }}" class="mega-card">
                                            <span class="mega-card__media">
                                                <img src="{{ $work->imageUrl() }}" alt="{{ $work->title }}" loading="lazy">
                                                <span class="mega-card__index" aria-hidden="true">{{ str_pad((string) ($i + 2), 2, '0', STR_PAD_LEFT) }}</span>
                                            </span>
                                            <span class="mega-card__meta">
                                                <span class="mega-card__name">{{ $work->title }}</span>
                                                <span class="mega-card__sub">{{ $work->artist?->name ?? 'Artist' }}{{ $work->year ? ' · '.$work->year : '' }}</span>
                                            </span>
                                        </a>
                                    @endforeach
                                </div>
                            @else
                                <p class="mega__empty">No published artworks yet.</p>
                            @endif
                        </div>

                        <div class="mega__lists">
                            <div class="mega-list">
                                <p class="mega-list__label">Categories</p>
                                <ul>
                                    @forelse(($mega['categories'] ?? collect()) as $category)
                                        <li>
                                            <a href="{{ route('catalogue.index', ['category' => [$category]]) }}">{{ $category }}</a>
                                        </li>
                                    @empty
                                        <li><span class="mega__empty">No categories</span></li>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="mega-list">
                                <p class="mega-list__label">Exhibitions</p>
                                <ul>
                                    @forelse(($mega['exhibitions'] ?? collect()) as $show)
                                        <li>
                                            <a href="{{ route('exhibitions') }}">{{ $show->title }}</a>
                                            @if($show->dates)
                                                <span class="mega-list__note">{{ $show->dates }}</span>
                                            @endif
                                        </li>
                                    @empty
                                        <li>
                                            <a href="{{ route('exhibitions') }}">View exhibitions</a>
                                        </li>
                                    @endforelse
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <a href="{{ route('leasing') }}" class="nav-link {{ request()->routeIs('leasing') ? 'active' : '' }}">Leasing</a>
            <a href="{{ route('about') }}" class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}">About</a>
            <a href="{{ route('inquiry.create') }}" class="nav-link {{ request()->routeIs('inquiry.*') ? 'active' : '' }}">Enquire</a>

            {{-- News mega --}}
            <div class="nav-item {{ request()->routeIs('news*') ? 'is-active' : '' }}" data-mega>
                <a
                    href="{{ route('news') }}"
                    class="nav-item__trigger {{ request()->routeIs('news*') ? 'active' : '' }}"
                    data-mega-trigger
                    aria-expanded="false"
                    aria-haspopup="true"
                >News</a>
                <div class="mega" data-mega-panel hidden>
                    <div class="mega__inner container">
                        <aside class="mega__rail">
                            <p class="mega__eyebrow">Editorial</p>
                            <h3 class="mega__title">News</h3>
                            <p class="mega__blurb">Stories from the gallery, artists, and the wider art world.</p>
                            <a class="mega__cta" href="{{ route('news') }}">All news</a>
                        </aside>
                        <div class="mega__feature mega__feature--stack">
                            @forelse(($mega['news'] ?? collect()) as $i => $post)
                                <a href="{{ route('news.show', $post->slug) }}" class="mega-card {{ $i === 0 ? 'mega-card--lead' : '' }}">
                                    <span class="mega-card__media">
                                        <img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" loading="lazy">
                                        @if($post->published_at)
                                            <span class="mega-card__chip">{{ $post->published_at->format('d M Y') }}</span>
                                        @endif
                                    </span>
                                    <span class="mega-card__meta">
                                        <span class="mega-card__name">{{ $post->title }}</span>
                                        @if($post->excerpt)
                                            <span class="mega-card__sub">{{ \Illuminate\Support\Str::limit(strip_tags($post->excerpt), 72) }}</span>
                                        @endif
                                    </span>
                                </a>
                            @empty
                                <p class="mega__empty">No published news yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Events mega --}}
            <div class="nav-item {{ request()->routeIs('events') ? 'is-active' : '' }}" data-mega>
                <a
                    href="{{ route('events') }}"
                    class="nav-item__trigger {{ request()->routeIs('events') ? 'active' : '' }}"
                    data-mega-trigger
                    aria-expanded="false"
                    aria-haspopup="true"
                >Events</a>
                <div class="mega" data-mega-panel hidden>
                    <div class="mega__inner container">
                        <aside class="mega__rail">
                            <p class="mega__eyebrow">Calendar</p>
                            <h3 class="mega__title">Events</h3>
                            <p class="mega__blurb">Openings, talks, and gatherings from the ArtsDiva programme.</p>
                            <a class="mega__cta" href="{{ route('events') }}">View events</a>
                        </aside>
                        <div class="mega__feature mega__feature--stack">
                            @forelse(($mega['events'] ?? collect()) as $i => $event)
                                <a href="{{ route('events') }}" class="mega-card {{ $i === 0 ? 'mega-card--lead' : '' }}">
                                    <span class="mega-card__media">
                                        <img src="{{ $event->imageUrl() }}" alt="{{ $event->title }}" loading="lazy">
                                        @if($event->date_label)
                                            <span class="mega-card__chip">{{ $event->date_label }}</span>
                                        @endif
                                    </span>
                                    <span class="mega-card__meta">
                                        <span class="mega-card__name">{{ $event->title }}</span>
                                        <span class="mega-card__sub">{{ collect([$event->time_label, $event->location])->filter()->implode(' · ') }}</span>
                                    </span>
                                </a>
                            @empty
                                <p class="mega__empty">No published events yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Artists mega --}}
            <div class="nav-item {{ request()->routeIs('artists*') ? 'is-active' : '' }}" data-mega>
                <a
                    href="{{ route('artists') }}"
                    class="nav-item__trigger {{ request()->routeIs('artists*') ? 'active' : '' }}"
                    data-mega-trigger
                    aria-expanded="false"
                    aria-haspopup="true"
                >Artists</a>
                <div class="mega" data-mega-panel hidden>
                    <div class="mega__inner container">
                        <aside class="mega__rail">
                            <p class="mega__eyebrow">Roster</p>
                            <h3 class="mega__title">Artists</h3>
                            <p class="mega__blurb">Meet the artists whose work shapes the ArtsDiva collection.</p>
                            <a class="mega__cta" href="{{ route('artists') }}">All artists</a>
                        </aside>
                        <div class="mega__feature mega__feature--artists">
                            @forelse(($mega['artists'] ?? collect()) as $i => $artist)
                                <a href="{{ route('artists.show', $artist->slug) }}" class="mega-card mega-card--portrait {{ $i === 0 ? 'mega-card--lead' : '' }}">
                                    <span class="mega-card__media">
                                        <img
                                            src="{{ $artist->image ? asset($artist->image) : asset('images/catalogue/artwork-001.png') }}"
                                            alt="{{ $artist->name }}"
                                            loading="lazy"
                                        >
                                        <span class="mega-card__index" aria-hidden="true">{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                    </span>
                                    <span class="mega-card__meta">
                                        <span class="mega-card__name">{{ $artist->name }}</span>
                                        <span class="mega-card__sub">{{ collect([$artist->city, $artist->country])->filter()->implode(', ') ?: 'Artist' }}</span>
                                    </span>
                                </a>
                            @empty
                                <p class="mega__empty">No published artists yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            {{-- Publications mega — compact folio strip --}}
            <div class="nav-item {{ request()->routeIs('publications*') ? 'is-active' : '' }}" data-mega>
                <a
                    href="{{ route('publications') }}"
                    class="nav-item__trigger {{ request()->routeIs('publications*') ? 'active' : '' }}"
                    data-mega-trigger
                    aria-expanded="false"
                    aria-haspopup="true"
                >Publications</a>
                <div class="mega mega--pubs" data-mega-panel hidden>
                    @php
                        $pubs = collect($mega['publications'] ?? [])->values();
                    @endphp
                    <div class="mega-pubs container">
                        <aside class="mega-pubs__intro">
                            <p class="mega-pubs__kicker">Reading room</p>
                            <h3 class="mega-pubs__heading">Publications</h3>
                            <p class="mega-pubs__lede">Essays and features from the collection.</p>
                            <a class="mega-pubs__cta" href="{{ route('publications') }}">Open archive</a>
                        </aside>

                        <div class="mega-pubs__folios" role="list">
                            @forelse($pubs as $i => $pub)
                                <a
                                    href="{{ route('publications.show', $pub->slug) }}"
                                    class="mega-folio {{ $i === 0 ? 'mega-folio--focus' : '' }}"
                                    role="listitem"
                                >
                                    <span class="mega-folio__frame">
                                        <img src="{{ $pub->imageUrl() }}" alt="{{ $pub->title }}" loading="lazy">
                                        <span class="mega-folio__index" aria-hidden="true">{{ str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) }}</span>
                                    </span>
                                    <span class="mega-folio__meta">
                                        <span class="mega-folio__title">{{ $pub->title }}</span>
                                        <span class="mega-folio__by">{{ $pub->artist_name ?: 'Publication' }}</span>
                                    </span>
                                </a>
                            @empty
                                <p class="mega-pubs__empty">No published titles yet.</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="header-utils">
            @auth
                @if(auth()->user()->isCustomer())
                    <a href="{{ route('account.dashboard') }}" class="header-account" aria-label="My account">Account</a>
                @elseif(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}" class="header-account" aria-label="Admin">Admin</a>
                @endif
            @else
                <a href="{{ route('account.login') }}" class="header-account" aria-label="Sign in">Sign in</a>
            @endauth

            <button type="button" class="header-search {{ request()->filled('q') ? 'is-active' : '' }}" data-search-toggle aria-label="Search" aria-expanded="{{ request()->filled('q') ? 'true' : 'false' }}" aria-controls="header-search-panel">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <circle cx="11" cy="11" r="6.5" stroke="currentColor" stroke-width="1.4"/>
                    <path d="M16.2 16.2L21 21" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/>
                </svg>
            </button>

            <form action="{{ route('currency.set') }}" method="POST" class="header-currency">
                @csrf
                <label for="header-currency" class="sr-only">Currency</label>
                <select id="header-currency" name="currency" onchange="this.form.submit()" aria-label="Select currency">
                    @foreach(config('artsdiva.currencies') as $code => $meta)
                        <option value="{{ $code }}" @selected($currencyCode === $code)>
                            {{ $code }} ({{ $meta['symbol'] }})
                        </option>
                    @endforeach
                </select>
                <span class="header-currency__chevron" aria-hidden="true">
                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </form>
        </div>
    </div>

    <div id="header-search-panel" class="header-search-panel" data-search-panel @if(!request()->filled('q')) hidden @endif>
        <div class="container">
            <form action="{{ route('catalogue.index') }}" method="GET" class="header-search-form" role="search" data-live-search>
                <label for="header-search-input" class="sr-only">Search artworks</label>
                <div class="live-search">
                    <input id="header-search-input" type="search" name="q" placeholder="Search title, artist, or serial…" value="{{ request('q') }}" autocomplete="off" data-live-search-input>
                    <div class="live-search__panel" data-live-search-panel hidden></div>
                </div>
                <button type="submit" class="btn btn--dark">Search</button>
                @if(request()->filled('q'))
                    <a href="{{ route('catalogue.index') }}" class="btn btn--ghost">Clear</a>
                @endif
            </form>
        </div>
    </div>
</header>
