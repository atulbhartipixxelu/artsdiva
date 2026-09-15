@extends('layouts.app')

@section('title', 'Art Catalogue — ArtsDiva')
@section('meta_description', 'Explore a curated collection of exceptional artworks from emerging and established artists worldwide. Filter by price, medium, size, artist and more.')

@section('content')
@php
    $symbol = $currencyMeta['symbol'] ?? '$';
    $queryBase = request()->except(['page']);
@endphp

<section class="cat-hero">
    <div class="container">
        <p class="cat-hero__eyebrow">ArtsDiva Collection</p>
        <h1>Art Catalogue</h1>
        @if(!empty($searchQuery))
            <p class="cat-hero__search">
                Showing results for
                <strong>“{{ $searchQuery }}”</strong>
                <span class="cat-hero__search-count">· {{ $artworks->total() }} {{ \Illuminate\Support\Str::plural('work', $artworks->total()) }}</span>
            </p>
        @else
            <p>Explore a curated collection of exceptional artworks from emerging and established artists worldwide.</p>
        @endif
    </div>
</section>

<div class="container cat-page">
    <form method="GET" action="{{ route('catalogue.index') }}" class="cat-search-bar" role="search" data-live-search>
        @foreach(request()->except(['q','page']) as $key => $val)
            @if(is_array($val))
                @foreach($val as $v)
                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                @endforeach
            @else
                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
            @endif
        @endforeach
        <label class="sr-only" for="cat-search-input">Search catalogue</label>
        <div class="live-search live-search--wide">
            <input
                id="cat-search-input"
                type="search"
                name="q"
                value="{{ $searchQuery ?? request('q') }}"
                placeholder="Search by title, artist, or serial number…"
                autocomplete="off"
                data-live-search-input
            >
            <div class="live-search__panel" data-live-search-panel hidden></div>
        </div>
        <button type="submit" class="btn btn--dark btn--sm">Search</button>
        @if(!empty($searchQuery))
            <a href="{{ route('catalogue.index', request()->except(['q','page'])) }}" class="btn btn--ghost btn--sm">Clear</a>
        @endif
    </form>

    <div class="cat-toolbar">
        <div class="cat-toolbar__left">
            <button type="button" class="cat-all-filters" data-filter-open aria-controls="cat-filter-drawer" aria-expanded="false">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M4 6h16M7 12h10M10 18h4" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>
                </svg>
                <span>All Filters</span>
                @if($activeFilterCount > 0)
                    <span class="cat-all-filters__count">· {{ $activeFilterCount }}</span>
                @endif
            </button>

            <div class="cat-quick" data-quick-filter>
                <button type="button" class="cat-quick__btn" data-quick-toggle aria-expanded="false">
                    Price
                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none" aria-hidden="true"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
                </button>
                <div class="cat-quick__panel" hidden>
                    <form method="GET" action="{{ route('catalogue.index') }}" class="cat-quick__form">
                        @foreach(request()->except(['min_price','max_price','page']) as $key => $val)
                            @if(is_array($val))
                                @foreach($val as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                            @endif
                        @endforeach
                        <label>Min ({{ $symbol }})</label>
                        <input type="number" name="min_price" min="0" value="{{ $selectedMinDisplay }}" placeholder="{{ $priceMinDisplay }}">
                        <label>Max ({{ $symbol }})</label>
                        <input type="number" name="max_price" min="0" value="{{ $selectedMaxDisplay }}" placeholder="{{ $priceMaxDisplay }}">
                        <button type="submit" class="btn btn--dark btn--sm">Apply</button>
                    </form>
                </div>
            </div>

            <div class="cat-quick" data-quick-filter>
                <button type="button" class="cat-quick__btn" data-quick-toggle aria-expanded="false">
                    Medium
                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none" aria-hidden="true"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
                </button>
                <div class="cat-quick__panel" hidden>
                    <form method="GET" action="{{ route('catalogue.index') }}">
                        @foreach(request()->except(['medium','page']) as $key => $val)
                            @if(is_array($val))
                                @foreach($val as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                            @endif
                        @endforeach
                        @foreach($facets['mediums'] as $medium => $total)
                            <label class="cat-check">
                                <input type="checkbox" name="medium[]" value="{{ $medium }}" @checked(in_array($medium, $filters['medium'] ?? [], true))>
                                <span>{{ $medium }}</span>
                                <em>{{ $total }}</em>
                            </label>
                        @endforeach
                        <button type="submit" class="btn btn--dark btn--sm">Apply</button>
                    </form>
                </div>
            </div>

            <div class="cat-quick" data-quick-filter>
                <button type="button" class="cat-quick__btn" data-quick-toggle aria-expanded="false">
                    Size
                    <svg width="10" height="6" viewBox="0 0 10 6" fill="none" aria-hidden="true"><path d="M1 1l4 4 4-4" stroke="currentColor" stroke-width="1.2" stroke-linecap="round"/></svg>
                </button>
                <div class="cat-quick__panel" hidden>
                    <form method="GET" action="{{ route('catalogue.index') }}">
                        @foreach(request()->except(['size','page']) as $key => $val)
                            @if(is_array($val))
                                @foreach($val as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                            @endif
                        @endforeach
                        @foreach($facets['sizes'] as $key => $meta)
                            <label class="cat-check">
                                <input type="checkbox" name="size[]" value="{{ $key }}" @checked(in_array($key, $filters['size'] ?? [], true))>
                                <span>{{ $meta['label'] }}</span>
                                <em>{{ $meta['total'] }}</em>
                            </label>
                        @endforeach
                        <button type="submit" class="btn btn--dark btn--sm">Apply</button>
                    </form>
                </div>
            </div>

            <span class="cat-count">{{ $artworks->total() }} Artwork{{ $artworks->total() === 1 ? '' : 's' }}</span>
        </div>

        <div class="cat-toolbar__right">
            <div class="cat-view" role="group" aria-label="View mode">
                <button type="button" class="cat-view__btn is-active" data-view="grid" aria-label="Grid view" aria-pressed="true">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><rect x="1" y="1" width="6" height="6"/><rect x="9" y="1" width="6" height="6"/><rect x="1" y="9" width="6" height="6"/><rect x="9" y="9" width="6" height="6"/></svg>
                </button>
                <button type="button" class="cat-view__btn" data-view="list" aria-label="List view" aria-pressed="false">
                    <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor" aria-hidden="true"><rect x="1" y="2" width="14" height="2"/><rect x="1" y="7" width="14" height="2"/><rect x="1" y="12" width="14" height="2"/></svg>
                </button>
            </div>

            <form method="GET" action="{{ route('catalogue.index') }}" class="cat-sort">
                @foreach(request()->except(['sort','page']) as $key => $val)
                    @if(is_array($val))
                        @foreach($val as $v)
                            <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                        @endforeach
                    @else
                        <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                    @endif
                @endforeach
                <label for="cat-sort">Sort By:</label>
                <select id="cat-sort" name="sort" onchange="this.form.submit()">
                    <option value="recommended" @selected(($filters['sort'] ?? '') === 'recommended')>Recommended</option>
                    <option value="newest" @selected(($filters['sort'] ?? '') === 'newest')>Newest</option>
                    <option value="price_asc" @selected(($filters['sort'] ?? '') === 'price_asc')>Price: Low to High</option>
                    <option value="price_desc" @selected(($filters['sort'] ?? '') === 'price_desc')>Price: High to Low</option>
                    <option value="artist" @selected(($filters['sort'] ?? '') === 'artist')>Artist</option>
                </select>
            </form>
        </div>
    </div>

    @if(count($chips))
        <div class="cat-chips">
            <span class="cat-chips__label">Applied Filter:</span>
            @foreach($chips as $chip)
                @php
                    $removeQuery = $queryBase;
                    foreach ($chip['remove'] as $rk => $rv) {
                        if (in_array($rk, ['min_price','max_price','width','height','q','sort'], true)) {
                            unset($removeQuery[$rk]);
                        } elseif (isset($removeQuery[$rk]) && is_array($removeQuery[$rk])) {
                            $removeQuery[$rk] = array_values(array_filter($removeQuery[$rk], fn ($x) => (string) $x !== (string) $rv));
                            if (! count($removeQuery[$rk])) unset($removeQuery[$rk]);
                        } else {
                            unset($removeQuery[$rk]);
                        }
                    }
                @endphp
                <a class="cat-chip" href="{{ route('catalogue.index', $removeQuery) }}">
                    {{ $chip['label'] }}
                    <span aria-hidden="true">×</span>
                </a>
            @endforeach
            <a class="cat-chips__clear" href="{{ route('catalogue.index') }}">Clean All</a>
        </div>
    @endif

    <div class="cat-grid" data-cat-grid data-view="grid">
        @forelse($artworks as $art)
            <article class="art-card" data-art-id="{{ $art['id'] }}">
                <div class="art-card__media">
                    <a href="{{ route('catalogue.show', $art['slug']) }}">
                        <img src="{{ $art['thumbnail'] }}" alt="{{ $art['title'] }} by {{ $art['artist'] }}" loading="lazy">
                    </a>
                    @if(!empty($art['serial_number']))
                        <span class="art-card__serial">{{ $art['serial_number'] }}</span>
                    @endif
                    <button type="button" class="art-card__wish" data-wishlist aria-label="Save {{ $art['title'] }}">
                        @include('partials.icon-heart')
                    </button>
                </div>
                <div class="art-card__body">
                    <p class="art-card__artist">{{ $art['artist'] }}</p>
                    <h2 class="art-card__title">
                        <a href="{{ route('catalogue.show', $art['slug']) }}">{{ $art['title'] }}</a>
                    </h2>
                    <p class="art-card__meta">
                        @if(!empty($art['serial_number']))
                            <span class="art-card__serial-inline">No. {{ $art['serial_number'] }}</span>
                            <span>|</span>
                        @endif
                        {{ $art['location'] ?: $art['city'] }}
                        @if($art['dimensions'])
                            <span>|</span> {{ $art['dimensions'] }}
                        @endif
                    </p>
                    <p class="art-card__price">{{ $art['price_formatted'] }}</p>
                </div>
            </article>
        @empty
            <div class="cat-empty">
                <p>No artworks match your filters.</p>
                <a href="{{ route('catalogue.index') }}" class="btn btn--dark">Clean All Filters</a>
            </div>
        @endforelse
    </div>

    @if($artworks->hasPages())
        @php
            $current = $artworks->currentPage();
            $last = $artworks->lastPage();
            $start = max(1, $current - 2);
            $end = min($last, $current + 2);
            if ($end - $start < 4) {
                if ($start === 1) {
                    $end = min($last, $start + 4);
                } elseif ($end === $last) {
                    $start = max(1, $end - 4);
                }
            }
        @endphp
        <nav class="cat-pager" aria-label="Catalogue pages">
            @if($artworks->onFirstPage())
                <span class="cat-pager__arrow is-disabled" aria-disabled="true">‹</span>
            @else
                <a class="cat-pager__arrow" href="{{ site_page_url($artworks->previousPageUrl()) }}" rel="prev">‹</a>
            @endif

            @if($start > 1)
                <a href="{{ site_page_url($artworks->url(1)) }}" class="cat-pager__num {{ $current === 1 ? 'is-active' : '' }}">1</a>
                @if($start > 2)
                    <span class="cat-pager__ellipsis">…</span>
                @endif
            @endif

            @for($page = $start; $page <= $end; $page++)
                <a
                    href="{{ site_page_url($artworks->url($page)) }}"
                    class="cat-pager__num {{ $page === $current ? 'is-active' : '' }}"
                    @if($page === $current) aria-current="page" @endif
                >{{ $page }}</a>
            @endfor

            @if($end < $last)
                @if($end < $last - 1)
                    <span class="cat-pager__ellipsis">…</span>
                @endif
                <a href="{{ site_page_url($artworks->url($last)) }}" class="cat-pager__num {{ $current === $last ? 'is-active' : '' }}">{{ $last }}</a>
            @endif

            @if($artworks->hasMorePages())
                <a class="cat-pager__arrow" href="{{ site_page_url($artworks->nextPageUrl()) }}" rel="next">›</a>
            @else
                <span class="cat-pager__arrow is-disabled" aria-disabled="true">›</span>
            @endif
        </nav>
    @endif
</div>

{{-- Filter drawer --}}
<div class="cat-drawer-backdrop" data-filter-backdrop hidden></div>
<aside id="cat-filter-drawer" class="cat-drawer" data-filter-drawer aria-hidden="true">
    <div class="cat-drawer__head">
        <h2>Filters</h2>
        <button type="button" class="cat-drawer__close" data-filter-close aria-label="Close filters">×</button>
    </div>

    <form method="GET" action="{{ route('catalogue.index') }}" class="cat-drawer__body" data-filter-form>
        <input type="hidden" name="sort" value="{{ $filters['sort'] ?? 'recommended' }}">

        <details class="cat-acc" open>
            <summary>Category</summary>
            <div class="cat-acc__body">
                @foreach($facets['categories'] as $category => $total)
                    <label class="cat-check">
                        <input type="checkbox" name="category[]" value="{{ $category }}" @checked(in_array($category, $filters['category'] ?? [], true))>
                        <span>{{ $category }}</span>
                        <em>{{ $total }}</em>
                    </label>
                @endforeach
            </div>
        </details>

        <details class="cat-acc" open>
            <summary>Artist</summary>
            <div class="cat-acc__body" data-show-more-list data-limit="5">
                @foreach($facets['artists'] as $i => $artist)
                    <label class="cat-check {{ $i >= 5 ? 'is-extra' : '' }}" @if($i >= 5) hidden @endif>
                        <input type="checkbox" name="artist[]" value="{{ $artist['id'] }}" @checked(in_array((string) $artist['id'], array_map('strval', $filters['artist'] ?? []), true))>
                        <span>{{ $artist['name'] }}</span>
                        <em>{{ $artist['total'] }}</em>
                    </label>
                @endforeach
                @if($facets['artists']->count() > 5)
                    <button type="button" class="cat-show-more" data-show-more>+ Show More</button>
                @endif
            </div>
        </details>

        <details class="cat-acc" open>
            <summary>Price</summary>
            <div class="cat-acc__body">
                <div class="cat-range" data-price-range
                     data-min="{{ $priceMinDisplay }}"
                     data-max="{{ $priceMaxDisplay }}"
                     data-start="{{ $selectedMinDisplay !== '' ? $selectedMinDisplay : $priceMinDisplay }}"
                     data-end="{{ $selectedMaxDisplay !== '' ? $selectedMaxDisplay : $priceMaxDisplay }}">
                    <div class="cat-range__track">
                        <div class="cat-range__fill" data-range-fill></div>
                        <input type="range" class="cat-range__input" data-range-min min="{{ $priceMinDisplay }}" max="{{ $priceMaxDisplay }}" value="{{ $selectedMinDisplay !== '' ? $selectedMinDisplay : $priceMinDisplay }}" step="100">
                        <input type="range" class="cat-range__input" data-range-max min="{{ $priceMinDisplay }}" max="{{ $priceMaxDisplay }}" value="{{ $selectedMaxDisplay !== '' ? $selectedMaxDisplay : $priceMaxDisplay }}" step="100">
                    </div>
                    <div class="cat-range__inputs">
                        <div>
                            <label for="drawer-min">Min</label>
                            <div class="cat-range__field">
                                <span>{{ $symbol }}</span>
                                <input id="drawer-min" type="number" name="min_price" data-range-min-input value="{{ $selectedMinDisplay !== '' ? $selectedMinDisplay : $priceMinDisplay }}" min="{{ $priceMinDisplay }}" max="{{ $priceMaxDisplay }}">
                            </div>
                        </div>
                        <div>
                            <label for="drawer-max">Max</label>
                            <div class="cat-range__field">
                                <span>{{ $symbol }}</span>
                                <input id="drawer-max" type="number" name="max_price" data-range-max-input value="{{ $selectedMaxDisplay !== '' ? $selectedMaxDisplay : $priceMaxDisplay }}" min="{{ $priceMinDisplay }}" max="{{ $priceMaxDisplay }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </details>

        <details class="cat-acc" open>
            <summary>Size</summary>
            <div class="cat-acc__body">
                @foreach($facets['sizes'] as $key => $meta)
                    <label class="cat-check">
                        <input type="checkbox" name="size[]" value="{{ $key }}" @checked(in_array($key, $filters['size'] ?? [], true))>
                        <span>{{ $meta['label'] }}</span>
                        <em>{{ $meta['total'] }}</em>
                    </label>
                @endforeach
                <p class="cat-custom-label">Custom</p>
                <div class="cat-custom-size">
                    <div>
                        <label for="drawer-width">Width</label>
                        <input id="drawer-width" type="number" name="width" min="0" step="1" value="{{ request('width') }}" placeholder="cm">
                    </div>
                    <div>
                        <label for="drawer-height">Height</label>
                        <input id="drawer-height" type="number" name="height" min="0" step="1" value="{{ request('height') }}" placeholder="cm">
                    </div>
                </div>
            </div>
        </details>

        <details class="cat-acc" open>
            <summary>Medium</summary>
            <div class="cat-acc__body">
                @foreach($facets['mediums'] as $medium => $total)
                    <label class="cat-check">
                        <input type="checkbox" name="medium[]" value="{{ $medium }}" @checked(in_array($medium, $filters['medium'] ?? [], true))>
                        <span>{{ $medium }}</span>
                        <em>{{ $total }}</em>
                    </label>
                @endforeach
            </div>
        </details>

        <details class="cat-acc" open>
            <summary>Location</summary>
            <div class="cat-acc__body" data-show-more-list data-limit="6">
                @foreach($facets['cities'] as $city => $total)
                    <label class="cat-check {{ $loop->index >= 6 ? 'is-extra' : '' }}" @if($loop->index >= 6) hidden @endif>
                        <input type="checkbox" name="city[]" value="{{ $city }}" @checked(in_array($city, $filters['city'] ?? [], true))>
                        <span>{{ $city }}</span>
                        <em>{{ $total }}</em>
                    </label>
                @endforeach
                @if($facets['cities']->count() > 6)
                    <button type="button" class="cat-show-more" data-show-more>+ Show More</button>
                @endif
            </div>
        </details>

        <div class="cat-drawer__foot">
            <a href="{{ route('catalogue.index') }}" class="btn btn--ghost">Clear</a>
            <button type="submit" class="btn btn--dark">Apply Filters</button>
        </div>
    </form>
</aside>
@endsection

@push('scripts')
<script>
(function () {
    const drawer = document.querySelector('[data-filter-drawer]');
    const backdrop = document.querySelector('[data-filter-backdrop]');
    const openBtns = document.querySelectorAll('[data-filter-open]');
    const closeBtns = document.querySelectorAll('[data-filter-close]');

    function openDrawer() {
        if (!drawer || !backdrop) return;
        drawer.classList.add('is-open');
        drawer.setAttribute('aria-hidden', 'false');
        backdrop.hidden = false;
        document.body.classList.add('cat-drawer-open');
        openBtns.forEach(b => b.setAttribute('aria-expanded', 'true'));
    }
    function closeDrawer() {
        if (!drawer || !backdrop) return;
        drawer.classList.remove('is-open');
        drawer.setAttribute('aria-hidden', 'true');
        backdrop.hidden = true;
        document.body.classList.remove('cat-drawer-open');
        openBtns.forEach(b => b.setAttribute('aria-expanded', 'false'));
    }
    openBtns.forEach(b => b.addEventListener('click', openDrawer));
    closeBtns.forEach(b => b.addEventListener('click', closeDrawer));
    if (backdrop) backdrop.addEventListener('click', closeDrawer);
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDrawer(); });

    // Quick filter dropdowns
    document.querySelectorAll('[data-quick-filter]').forEach(wrap => {
        const btn = wrap.querySelector('[data-quick-toggle]');
        const panel = wrap.querySelector('.cat-quick__panel');
        if (!btn || !panel) return;
        btn.addEventListener('click', e => {
            e.stopPropagation();
            const open = panel.hasAttribute('hidden');
            document.querySelectorAll('.cat-quick__panel').forEach(p => p.setAttribute('hidden', ''));
            document.querySelectorAll('[data-quick-toggle]').forEach(b => b.setAttribute('aria-expanded', 'false'));
            if (open) {
                panel.removeAttribute('hidden');
                btn.setAttribute('aria-expanded', 'true');
            }
        });
    });
    document.addEventListener('click', () => {
        document.querySelectorAll('.cat-quick__panel').forEach(p => p.setAttribute('hidden', ''));
        document.querySelectorAll('[data-quick-toggle]').forEach(b => b.setAttribute('aria-expanded', 'false'));
    });

    // Show more
    document.querySelectorAll('[data-show-more]').forEach(btn => {
        btn.addEventListener('click', () => {
            const list = btn.closest('[data-show-more-list]');
            if (!list) return;
            list.querySelectorAll('.is-extra').forEach(el => el.removeAttribute('hidden'));
            btn.remove();
        });
    });

    // View toggle
    const grid = document.querySelector('[data-cat-grid]');
    document.querySelectorAll('[data-view]').forEach(btn => {
        btn.addEventListener('click', () => {
            const mode = btn.getAttribute('data-view');
            if (!grid || !mode) return;
            grid.setAttribute('data-view', mode);
            document.querySelectorAll('.cat-view__btn').forEach(b => {
                const on = b.getAttribute('data-view') === mode;
                b.classList.toggle('is-active', on);
                b.setAttribute('aria-pressed', on ? 'true' : 'false');
            });
            try { localStorage.setItem('artsdiva_cat_view', mode); } catch (e) {}
        });
    });
    try {
        const saved = localStorage.getItem('artsdiva_cat_view');
        if (saved && grid) {
            const btn = document.querySelector('.cat-view__btn[data-view="' + saved + '"]');
            if (btn) btn.click();
        }
    } catch (e) {}

    // Wishlist
    const wishLoggedIn = {{ auth()->check() && auth()->user()->isCustomer() ? 'true' : 'false' }};
    const wishServerIds = @json($wishlistIds ?? []);
    const wishToggleBase = @json(url('/account/wishlist'));
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

    function wishKey() { return 'artsdiva_wishlist'; }
    function getWish() {
        if (wishLoggedIn) return wishServerIds.slice();
        try { return JSON.parse(localStorage.getItem(wishKey()) || '[]'); } catch (e) { return []; }
    }
    function setWish(ids) {
        if (wishLoggedIn) {
            wishServerIds.length = 0;
            ids.forEach(id => wishServerIds.push(String(id)));
            return;
        }
        try { localStorage.setItem(wishKey(), JSON.stringify(ids)); } catch (e) {}
    }
    function syncWish() {
        const ids = getWish().map(String);
        document.querySelectorAll('[data-wishlist]').forEach(btn => {
            const card = btn.closest('[data-art-id]');
            const id = card ? card.getAttribute('data-art-id') : (btn.getAttribute('data-art-id') || null);
            btn.classList.toggle('is-active', id && ids.includes(String(id)));
        });
    }
    document.querySelectorAll('[data-wishlist]').forEach(btn => {
        btn.addEventListener('click', async e => {
            e.preventDefault();
            e.stopPropagation();
            const card = btn.closest('[data-art-id]');
            const id = card ? card.getAttribute('data-art-id') : (btn.getAttribute('data-art-id') || null);
            if (!id) return;

            if (wishLoggedIn) {
                try {
                    const res = await fetch(wishToggleBase + '/' + id, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                    });
                    if (res.status === 401 || res.redirected) {
                        window.location.href = @json(route('account.login'));
                        return;
                    }
                    const data = await res.json();
                    let ids = getWish();
                    if (data.active) {
                        if (!ids.includes(String(id))) ids.push(String(id));
                    } else {
                        ids = ids.filter(x => String(x) !== String(id));
                    }
                    setWish(ids);
                    syncWish();
                } catch (err) {
                    window.location.href = @json(route('account.login'));
                }
                return;
            }

            let ids = getWish();
            if (ids.includes(id) || ids.includes(String(id))) ids = ids.filter(x => String(x) !== String(id));
            else ids.push(String(id));
            setWish(ids);
            syncWish();
        });
    });
    syncWish();

    // Dual range slider
    document.querySelectorAll('[data-price-range]').forEach(wrap => {
        const minR = wrap.querySelector('[data-range-min]');
        const maxR = wrap.querySelector('[data-range-max]');
        const minI = wrap.querySelector('[data-range-min-input]');
        const maxI = wrap.querySelector('[data-range-max-input]');
        const fill = wrap.querySelector('[data-range-fill]');
        const absMin = Number(wrap.getAttribute('data-min')) || 0;
        const absMax = Number(wrap.getAttribute('data-max')) || 100;
        if (!minR || !maxR || !minI || !maxI) return;

        function paint() {
            let a = Number(minR.value);
            let b = Number(maxR.value);
            if (a > b) { const t = a; a = b; b = t; minR.value = a; maxR.value = b; }
            minI.value = a;
            maxI.value = b;
            const left = ((a - absMin) / Math.max(absMax - absMin, 1)) * 100;
            const right = ((b - absMin) / Math.max(absMax - absMin, 1)) * 100;
            if (fill) {
                fill.style.left = left + '%';
                fill.style.width = Math.max(right - left, 0) + '%';
            }
        }
        minR.addEventListener('input', paint);
        maxR.addEventListener('input', paint);
        minI.addEventListener('change', () => {
            minR.value = minI.value;
            paint();
        });
        maxI.addEventListener('change', () => {
            maxR.value = maxI.value;
            paint();
        });
        paint();
    });
})();
</script>
@endpush
