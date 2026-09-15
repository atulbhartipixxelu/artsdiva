@extends('layouts.app')

@section('title', $artwork['title'].' — '.$artwork['artist'].' | ArtsDiva')
@section('meta_description', \Illuminate\Support\Str::limit($artwork['description'], 155))

@section('content')
@php
    $images = array_values($artwork['images'] ?: array_filter([$artwork['thumbnail']]));
    if (! count($images)) {
        $images = [asset('images/photo-1541961017774-22349e4a1262.jpg')];
    }
    $base = $images;
    $i = 0;
    while (count($images) < 4) {
        $images[] = $base[$i % count($base)];
        $i++;
    }
@endphp

<div class="container pd">
    <nav class="pd-crumb" aria-label="Breadcrumb">
        <a href="{{ route('home') }}">Home</a>
        <span aria-hidden="true">›</span>
        <a href="{{ route('catalogue.index') }}">Art Catalogue</a>
        <span aria-hidden="true">›</span>
        <span>{{ $artwork['title'] }}</span>
    </nav>

    <div class="pd-main">
        <div class="pd-gallery">
            <div class="pd-thumbs" role="list">
                @foreach($images as $index => $image)
                    <button
                        type="button"
                        class="pd-thumb {{ $index === 0 ? 'is-active' : '' }}"
                        data-gallery-thumb
                        data-src="{{ $image }}"
                        aria-label="View image {{ $index + 1 }}"
                    >
                        <img src="{{ $image }}" alt="{{ $artwork['title'] }} view {{ $index + 1 }}">
                    </button>
                @endforeach
            </div>
            <div class="pd-stage">
                <img id="gallery-main-img" src="{{ $images[0] }}" alt="{{ $artwork['title'] }} by {{ $artwork['artist'] }}">
            </div>
        </div>

        <div class="pd-info">
            <div class="pd-info__top">
                <div>
                    <p class="pd-eyebrow">
                        @if(!empty($artwork['serial_number']))
                            <span class="pd-serial">No. {{ $artwork['serial_number'] }}</span>
                            <span aria-hidden="true">·</span>
                        @endif
                        {{ $artwork['category'] ?: 'Artwork' }}
                    </p>
                    <h1 class="pd-title">{{ $artwork['title'] }}</h1>
                </div>
                <div class="pd-tools">
                    <button type="button" class="pd-icon-btn" aria-label="Share" data-share>
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <circle cx="18" cy="5" r="2.5" stroke="currentColor" stroke-width="1.4"/>
                            <circle cx="6" cy="12" r="2.5" stroke="currentColor" stroke-width="1.4"/>
                            <circle cx="18" cy="19" r="2.5" stroke="currentColor" stroke-width="1.4"/>
                            <path d="M8.3 10.8l7.4-4.6M8.3 13.2l7.4 4.6" stroke="currentColor" stroke-width="1.4"/>
                        </svg>
                    </button>
                    <button type="button" class="pd-icon-btn art-card__wish" data-wishlist data-art-id="{{ $artwork['id'] }}" aria-label="Save {{ $artwork['title'] }}">
                        @include('partials.icon-heart')
                    </button>
                </div>
            </div>

            <p class="pd-artist">
                @if(!empty($artwork['artist_slug']))
                    <a href="{{ route('artists.show', $artwork['artist_slug']) }}">{{ $artwork['artist'] }}</a>
                @else
                    {{ $artwork['artist'] }}
                @endif
            </p>
            <p class="pd-meta">
                {{ $artwork['location'] ?: $artwork['city'] }}
                @if($artwork['year'])
                    <span>|</span> {{ $artwork['year'] }}
                @endif
            </p>

            <div class="pd-price-row">
                <p class="pd-price">{{ $artwork['price_formatted'] }}</p>
                <form action="{{ route('currency.set') }}" method="POST" class="pd-currency">
                    @csrf
                    <label for="detail-currency">View price in:</label>
                    <select id="detail-currency" name="currency" onchange="this.form.submit()">
                        @foreach($currencies as $code => $meta)
                            <option value="{{ $code }}" @selected($currentCurrency === $code)>{{ $code }} ({{ $meta['symbol'] }})</option>
                        @endforeach
                    </select>
                </form>
            </div>

            <dl class="pd-specs">
                <div><dt>Medium</dt><dd>{{ $artwork['medium'] ?: '—' }}</dd></div>
                <div><dt>Dimensions</dt><dd>{{ $artwork['dimensions'] ?: '—' }}</dd></div>
                <div><dt>Weight</dt><dd>{{ $artwork['weight'] ?: '—' }}</dd></div>
                <div><dt>Category</dt><dd>{{ $artwork['category'] ?: '—' }}</dd></div>
                <div><dt>Tags</dt><dd>{{ collect([$artwork['category'], $artwork['medium']])->filter()->implode(', ') ?: '—' }}</dd></div>
                <div><dt>Availability</dt><dd>Available for Acquisition &amp; Lease</dd></div>
            </dl>

            <div class="pd-desc">
                <h2>Description</h2>
                <p>{{ $artwork['description'] }}</p>
            </div>

            <div class="pd-lease">
                <div class="pd-lease__text">
                    <strong>Estimated Annual Lease Rate</strong>
                    <p class="pd-lease__price">{{ $artwork['lease_annual_formatted'] }} <span>/ year</span></p>
                    <p class="pd-lease__note">At {{ $artwork['lease_rate_label'] }} of acquisition value per annum</p>
                </div>
                <a class="btn btn--outline btn--sm" href="{{ route('leasing') }}">View Leasing Structure</a>
            </div>

            <div class="pd-actions">
                @auth
                    @if(auth()->user()->isCustomer())
                        <form method="POST" action="{{ route('account.orders.store') }}" class="pd-actions__buy">
                            @csrf
                            <input type="hidden" name="artwork_id" value="{{ $artwork['id'] }}">
                            <input type="hidden" name="type" value="acquisition">
                            <button type="submit" class="btn btn--dark">Request to Purchase</button>
                        </form>
                        <form method="POST" action="{{ route('account.orders.store') }}" class="pd-actions__buy">
                            @csrf
                            <input type="hidden" name="artwork_id" value="{{ $artwork['id'] }}">
                            <input type="hidden" name="type" value="lease">
                            <button type="submit" class="btn btn--outline">Request to Lease</button>
                        </form>
                    @else
                        <a class="btn btn--dark" href="{{ route('inquiry.create', ['artwork' => $artwork['slug']]) }}">Request to Lease</a>
                    @endif
                @else
                    <a class="btn btn--dark" href="{{ route('account.login') }}">Sign in to Purchase</a>
                    <a class="btn btn--outline" href="{{ route('inquiry.create', ['artwork' => $artwork['slug']]) }}">Request to Lease</a>
                @endauth
                <a class="pd-enquire" href="{{ route('inquiry.create', ['artwork' => $artwork['slug']]) }}">Enquire About Artwork</a>
            </div>

            <ul class="pd-trust">
                <li>
                    <span class="pd-trust__icon" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M12 3l7 3v5c0 4.5-2.8 7.8-7 10-4.2-2.2-7-5.5-7-10V6l7-3z" stroke="currentColor" stroke-width="1.4"/><path d="M9 12l2 2 4-4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                    </span>
                    Authentic Artwork
                </li>
                <li>
                    <span class="pd-trust__icon" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><rect x="3" y="7" width="18" height="12" rx="1.5" stroke="currentColor" stroke-width="1.4"/><path d="M7 7V5.5A2.5 2.5 0 019.5 3h5A2.5 2.5 0 0117 5.5V7" stroke="currentColor" stroke-width="1.4"/></svg>
                    </span>
                    Secure Payment
                </li>
                <li>
                    <span class="pd-trust__icon" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="8.5" stroke="currentColor" stroke-width="1.4"/><path d="M3.5 12h17M12 3.5c2.2 2.4 3.3 5.1 3.3 8.5S14.2 18.1 12 20.5C9.8 18.1 8.7 15.4 8.7 12S9.8 5.9 12 3.5z" stroke="currentColor" stroke-width="1.4"/></svg>
                    </span>
                    Global Delivery
                </li>
                <li>
                    <span class="pd-trust__icon" aria-hidden="true">
                        <svg width="20" height="20" viewBox="0 0 24 24" fill="none"><path d="M4 8h11l5 4v5H4V8z" stroke="currentColor" stroke-width="1.4"/><path d="M15 8v4h5" stroke="currentColor" stroke-width="1.4"/><circle cx="8" cy="18.5" r="1.5" fill="currentColor"/><circle cx="17" cy="18.5" r="1.5" fill="currentColor"/></svg>
                    </span>
                    Secure Packaging
                </li>
            </ul>
        </div>
    </div>

    <section class="pd-tabs" data-pd-tabs>
        <div class="pd-tabs__nav" role="tablist">
            <button type="button" class="is-active" role="tab" aria-selected="true" data-tab="details">Details</button>
            <button type="button" role="tab" aria-selected="false" data-tab="shipping">Shipping &amp; Returns</button>
            <button type="button" role="tab" aria-selected="false" data-tab="auth">Authentication</button>
            <button type="button" role="tab" aria-selected="false" data-tab="artist">Artist</button>
        </div>

        <div class="pd-tabs__panel is-active" data-panel="details" role="tabpanel">
            <div class="pd-detail-grid">
                <div><span>Artwork ID</span><strong>AD-{{ str_pad($artwork['id'], 5, '0', STR_PAD_LEFT) }}</strong></div>
                <div><span>Year</span><strong>{{ $artwork['year'] ?: '—' }}</strong></div>
                <div><span>Medium</span><strong>{{ $artwork['medium'] ?: '—' }}</strong></div>
                <div><span>Signature</span><strong>Signed by artist</strong></div>
                <div><span>Framing</span><strong>Unframed / Optional</strong></div>
                <div><span>Frame Option</span><strong>Available on request</strong></div>
                <div><span>Dimension</span><strong>{{ $artwork['dimensions'] ?: '—' }}</strong></div>
                <div><span>Weight</span><strong>{{ $artwork['weight'] ?: '—' }}</strong></div>
            </div>
        </div>

        <div class="pd-tabs__panel" data-panel="shipping" role="tabpanel" hidden>
            <p>Worldwide shipping is arranged with specialist fine-art carriers. Transit insurance is included on all consignments. Returns are accepted within 14 days of delivery for acquisition purchases where the work remains in original condition. Lease placements follow the terms outlined in your lease agreement.</p>
        </div>

        <div class="pd-tabs__panel" data-panel="auth" role="tabpanel" hidden>
            <p>Every artwork listed on ArtsDiva is reviewed for provenance and authenticity prior to publication. Certificates of authenticity and condition reports are available on request for acquisition and leasing clients.</p>
        </div>

        <div class="pd-tabs__panel" data-panel="artist" role="tabpanel" hidden>
            <p><strong>{{ $artwork['artist'] }}</strong>@if($artwork['location'] || $artwork['city']) — {{ $artwork['location'] ?: $artwork['city'] }}@endif</p>
            <p>Works by {{ $artwork['artist'] }} are available through ArtsDiva for acquisition and annual leasing. Contact our team for portfolio highlights and placement guidance.</p>
        </div>
    </section>

    @if($related->isNotEmpty())
        <section class="pd-related">
            <div class="section-head">
                <h2>Similar Artworks</h2>
            </div>
            <div class="cat-grid" data-view="grid">
                @foreach($related as $art)
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
                            <h3 class="art-card__title">
                                <a href="{{ route('catalogue.show', $art['slug']) }}">{{ $art['title'] }}</a>
                            </h3>
                            <p class="art-card__meta">
                                {{ $art['location'] ?: $art['city'] }}
                                @if($art['dimensions'])
                                    <span>|</span> {{ $art['dimensions'] }}
                                @endif
                            </p>
                            <p class="art-card__price">{{ $art['price_formatted'] }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </section>
    @endif
</div>
@endsection

@push('scripts')
<script>
(function () {
    const main = document.getElementById('gallery-main-img');
    const thumbs = document.querySelectorAll('[data-gallery-thumb]');
    thumbs.forEach(function (btn) {
        btn.addEventListener('click', function () {
            if (!main) return;
            main.src = btn.getAttribute('data-src');
            thumbs.forEach(function (t) { t.classList.remove('is-active'); });
            btn.classList.add('is-active');
        });
    });

    const share = document.querySelector('[data-share]');
    if (share) {
        share.addEventListener('click', async function () {
            const url = window.location.href;
            try {
                if (navigator.share) {
                    await navigator.share({ title: document.title, url: url });
                } else if (navigator.clipboard) {
                    await navigator.clipboard.writeText(url);
                    share.setAttribute('title', 'Link copied');
                }
            } catch (e) {}
        });
    }

    const tabs = document.querySelector('[data-pd-tabs]');
    if (tabs) {
        const buttons = tabs.querySelectorAll('[data-tab]');
        const panels = tabs.querySelectorAll('[data-panel]');
        buttons.forEach(function (btn) {
            btn.addEventListener('click', function () {
                const id = btn.getAttribute('data-tab');
                buttons.forEach(function (b) {
                    b.classList.toggle('is-active', b === btn);
                    b.setAttribute('aria-selected', b === btn ? 'true' : 'false');
                });
                panels.forEach(function (panel) {
                    const on = panel.getAttribute('data-panel') === id;
                    panel.classList.toggle('is-active', on);
                    panel.hidden = !on;
                });
            });
        });
    }

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
            ids.forEach(function (id) { wishServerIds.push(String(id)); });
            return;
        }
        try { localStorage.setItem(wishKey(), JSON.stringify(ids)); } catch (e) {}
    }
    function syncWish() {
        const ids = getWish().map(String);
        document.querySelectorAll('[data-wishlist]').forEach(function (btn) {
            const card = btn.closest('[data-art-id]');
            const id = btn.getAttribute('data-art-id') || (card ? card.getAttribute('data-art-id') : null);
            btn.classList.toggle('is-active', id && ids.includes(String(id)));
        });
    }
    document.querySelectorAll('[data-wishlist]').forEach(function (btn) {
        btn.addEventListener('click', async function (e) {
            e.preventDefault();
            e.stopPropagation();
            const card = btn.closest('[data-art-id]');
            const id = btn.getAttribute('data-art-id') || (card ? card.getAttribute('data-art-id') : null);
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
                        ids = ids.filter(function (x) { return String(x) !== String(id); });
                    }
                    setWish(ids);
                    syncWish();
                } catch (err) {
                    window.location.href = @json(route('account.login'));
                }
                return;
            }

            let ids = getWish();
            const sid = String(id);
            if (ids.includes(sid)) ids = ids.filter(function (x) { return x !== sid; });
            else ids.push(sid);
            setWish(ids);
            syncWish();
        });
    });
    syncWish();
})();
</script>
@endpush
