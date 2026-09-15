@extends('layouts.app')

@section('title', 'ArtsDiva — Curated Masterpieces | Fine Art Acquisition & Leasing')
@section('meta_description', 'ArtsDiva offers curated fine art acquisition and annual leasing for collectors and exceptional spaces. Browse the catalogue or inquire to lease.')

@section('content')
{{-- Hero slider --}}
<section class="hero" data-hero-slider aria-roledescription="carousel" aria-label="Featured collections">
    <div class="hero__slides">
        @foreach($heroSlides as $index => $slide)
            <div
                class="hero__slide {{ $index === 0 ? 'is-active' : '' }}"
                data-hero-slide
                aria-hidden="{{ $index === 0 ? 'false' : 'true' }}"
            >
                <div class="hero__media">
                    <img src="{{ $slide['image'] }}" alt="{{ $slide['alt'] }}">
                </div>
            </div>
        @endforeach
    </div>

    <div class="hero__overlay" aria-hidden="true"></div>

    <div class="hero__footer">
        <div class="container hero__footer-inner">
            <div class="hero__content">
                <p class="hero__eyebrow" data-hero-eyebrow>{{ $heroSlides[0]['eyebrow'] }}</p>
                <h1 data-hero-title>{{ $heroSlides[0]['title'] }}</h1>
                <p class="hero__subtitle" data-hero-subtitle>{{ $heroSlides[0]['subtitle'] }}</p>
                <div class="hero__actions">
                    <a class="btn btn--light hero__btn" href="{{ $heroSlides[0]['button_one_url'] }}" data-hero-btn-one>{{ $heroSlides[0]['button_one_label'] }}</a>
                    <a class="btn btn--light hero__btn" href="{{ $heroSlides[0]['button_two_url'] }}" data-hero-btn-two>{{ $heroSlides[0]['button_two_label'] }}</a>
                </div>
            </div>

            <div class="hero__pager" data-hero-pager role="tablist" aria-label="Banner slides">
                @foreach($heroSlides as $index => $slide)
                    <button
                        type="button"
                        class="hero__dot {{ $index === 0 ? 'is-active' : '' }}"
                        data-hero-dot="{{ $index }}"
                        role="tab"
                        aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                        aria-label="Go to slide {{ $index + 1 }}"
                    >
                        <span class="hero__dot-num">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                    </button>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
(function () {
    const root = document.querySelector('[data-hero-slider]');
    if (!root) return;

    const slidesData = @json($heroSlides);
    const slides = Array.from(root.querySelectorAll('[data-hero-slide]'));
    const dots = root.querySelectorAll('[data-hero-dot]');
    const eyebrow = root.querySelector('[data-hero-eyebrow]');
    const title = root.querySelector('[data-hero-title]');
    const subtitle = root.querySelector('[data-hero-subtitle]');
    const btnOne = root.querySelector('[data-hero-btn-one]');
    const btnTwo = root.querySelector('[data-hero-btn-two]');
    let index = 0;
    let timer;

    function goTo(next) {
        if (!slides.length) return;
        const prev = index;
        index = (next + slides.length) % slides.length;
        if (prev === index) return;

        let goingForward = true;
        if (prev === 0 && index === slides.length - 1) goingForward = false;
        else if (prev === slides.length - 1 && index === 0) goingForward = true;
        else goingForward = index > prev;

        const incoming = slides[index];
        const outgoing = slides[prev];

        // Park incoming off-screen on the entry side without animating
        slides.forEach(function (slide) {
            slide.style.transition = 'none';
            slide.classList.remove('is-active', 'is-prev', 'is-next');
        });
        outgoing.classList.add('is-active');
        incoming.classList.add(goingForward ? 'is-next' : 'is-prev');
        void incoming.offsetWidth;

        slides.forEach(function (slide) {
            slide.style.transition = '';
        });

        outgoing.classList.remove('is-active');
        outgoing.classList.add(goingForward ? 'is-prev' : 'is-next');
        outgoing.setAttribute('aria-hidden', 'true');

        incoming.classList.remove('is-prev', 'is-next');
        incoming.classList.add('is-active');
        incoming.setAttribute('aria-hidden', 'false');

        slides.forEach(function (slide, i) {
            if (i === index || i === prev) return;
            slide.classList.add(goingForward ? 'is-next' : 'is-prev');
            slide.setAttribute('aria-hidden', 'true');
        });

        // Restart zoom on the active image
        const activeImg = incoming.querySelector('img');
        if (activeImg) {
            activeImg.style.transition = 'none';
            activeImg.style.transform = 'scale(1)';
            void activeImg.offsetWidth;
            activeImg.style.transition = '';
            activeImg.style.transform = '';
        }

        dots.forEach(function (dot, i) {
            const active = i === index;
            dot.classList.toggle('is-active', active);
            dot.setAttribute('aria-selected', active ? 'true' : 'false');
        });

        const data = slidesData[index];
        if (eyebrow) eyebrow.textContent = data.eyebrow;
        if (title) title.textContent = data.title;
        if (subtitle) subtitle.textContent = data.subtitle;
        if (btnOne) {
            btnOne.textContent = data.button_one_label;
            btnOne.setAttribute('href', data.button_one_url);
        }
        if (btnTwo) {
            btnTwo.textContent = data.button_two_label;
            btnTwo.setAttribute('href', data.button_two_url);
        }
    }

    function start() {
        stop();
        if (slides.length < 2) return;
        timer = window.setInterval(function () {
            goTo(index + 1);
        }, 6500);
    }

    function stop() {
        if (timer) window.clearInterval(timer);
    }

    // Initial state for non-active slides
    slides.forEach(function (slide, i) {
        if (i === 0) {
            slide.classList.add('is-active');
        } else {
            slide.classList.add('is-next');
        }
    });

    dots.forEach(function (dot) {
        dot.addEventListener('click', function () {
            goTo(Number(dot.getAttribute('data-hero-dot')));
            start();
        });
    });

    root.addEventListener('mouseenter', stop);
    root.addEventListener('mouseleave', start);

    start();
})();
</script>
@endpush


{{-- Forthcoming exhibitions slider --}}

<section class="section exhibitions" data-exhibitions-slider>
    <div class="container">
        <div class="ex-head">
            <div class="ex-head__left">
                <h2 class="ex-head__title">Forthcoming Exhibitions</h2>
                <span class="ex-head__sep" aria-hidden="true"></span>
                <a class="ex-head__view" href="{{ route('events') }}">View All <span aria-hidden="true">→</span></a>
            </div>
            <div class="ex-head__nav" role="group" aria-label="Exhibition slider controls">
                <button type="button" class="ex-nav-btn" data-ex-prev aria-label="Previous exhibitions">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M7.5 2L3.5 6L7.5 10" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <span class="ex-head__count" data-ex-count aria-live="polite">1 / {{ count($exhibitions) }}</span>
                <button type="button" class="ex-nav-btn" data-ex-next aria-label="Next exhibitions">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M4.5 2L8.5 6L4.5 10" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>
        </div>

        <div class="ex-viewport">
            <div class="ex-track" data-ex-track>
                @foreach($exhibitions as $item)
                    <article class="ex-card">
                        <div class="ex-card__image">
                            <img src="{{ $item->imageUrl() }}" alt="{{ $item->title }}">
                        </div>
                        <h3 class="ex-card__title">{{ $item->title }}</h3>
                        <p class="ex-card__subtitle">{{ $item->subtitle }}</p>
                        <p class="ex-card__meta">{{ $item->dates }}</p>
                        <p class="ex-card__meta">{{ $item->location }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
(function () {
    const root = document.querySelector('[data-exhibitions-slider]');
    if (!root) return;

    const track = root.querySelector('[data-ex-track]');
    const cards = Array.from(root.querySelectorAll('.ex-card'));
    const prev = root.querySelector('[data-ex-prev]');
    const next = root.querySelector('[data-ex-next]');
    const countEl = root.querySelector('[data-ex-count]');
    const total = cards.length;
    let index = 0;

    function visibleCount() {
        const w = window.innerWidth;
        if (w <= 768) return 1;
        if (w <= 900) return 2;
        if (w <= 1100) return 3;
        return 4;
    }

    function maxIndex() {
        return Math.max(0, total - visibleCount());
    }

    function update() {
        const vis = visibleCount();
        if (index > maxIndex()) index = maxIndex();

        const card = cards[0];
        const styles = window.getComputedStyle(track);
        const gap = parseFloat(styles.columnGap || styles.gap) || 0;
        const step = card.getBoundingClientRect().width + gap;
        track.style.transform = 'translateX(' + (-index * step) + 'px)';

        const current = Math.min(index + vis, total);
        countEl.textContent = current + ' / ' + total;

        prev.disabled = index <= 0;
        next.disabled = index >= maxIndex();
    }

    prev.addEventListener('click', function () {
        index = Math.max(0, index - 1);
        update();
    });

    next.addEventListener('click', function () {
        index = Math.min(maxIndex(), index + 1);
        update();
    });

    window.addEventListener('resize', update);
    update();
})();
</script>
@endpush


{{-- Curated art for every space --}}
<section class="feature-split">
    <div class="feature-split__media">
        <img
            src="{{ asset('images/catalogue/artwork-001.png') }}"
            alt="Curated fine art for every space"
        >
    </div>
    <div class="feature-split__body">
        <div class="feature-split__content">
            <h2>Curated Art for Every Space</h2>
            <p>
                Bring timeless creativity into homes, hotels, offices, and luxury interiors with our exclusive
                collection of fine art. Every artwork is thoughtfully selected to inspire, elevate, and create
                lasting impressions.
            </p>
            <a class="feature-split__link" href="{{ route('catalogue.index') }}">Explore Collection <span aria-hidden="true">→</span></a>
        </div>
    </div>
</section>

{{-- Forthcoming events slider --}}

<section class="events-section" data-events-slider>
    <div class="container">
        <div class="ex-head">
            <div class="ex-head__left">
                <h2 class="ex-head__title">Forthcoming Events</h2>
                <span class="ex-head__sep" aria-hidden="true"></span>
                <a class="ex-head__view" href="{{ route('news') }}">View All <span aria-hidden="true">→</span></a>
            </div>
            <div class="ex-head__nav" role="group" aria-label="Events slider controls">
                <button type="button" class="ex-nav-btn" data-ev-prev aria-label="Previous events">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M7.5 2L3.5 6L7.5 10" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <span class="ex-head__count" data-ev-count aria-live="polite">1 / {{ count($events) }}</span>
                <button type="button" class="ex-nav-btn" data-ev-next aria-label="Next events">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M4.5 2L8.5 6L4.5 10" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>
        </div>

        <div class="ev-viewport">
            <div class="ev-track" data-ev-track>
                @foreach($events as $event)
                    <article class="ev-card">
                        <div class="ev-card__media">
                            <img src="{{ $event->imageUrl() }}" alt="{{ $event->title }}">
                            <div class="ev-card__tags">
                                @foreach(($event->tags ?? []) as $tag)
                                    <span class="ev-tag">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="ev-card__body">
                            <h3 class="ev-card__title">{{ $event->title }}</h3>
                            <ul class="ev-card__meta">
                                <li>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true"><rect x="3.5" y="5.5" width="17" height="15" rx="1.5" stroke="currentColor" stroke-width="1.4"/><path d="M3.5 10h17M8 3.5v4M16 3.5v4" stroke="currentColor" stroke-width="1.4" stroke-linecap="round"/></svg>
                                    <span>{{ $event->date_label }}</span>
                                </li>
                                <li>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="8.25" stroke="currentColor" stroke-width="1.4"/><path d="M12 8v4.5l3 1.5" stroke="currentColor" stroke-width="1.4" stroke-linecap="round" stroke-linejoin="round"/></svg>
                                    <span>{{ $event->time_label }}</span>
                                </li>
                                <li>
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 21s6.5-5.2 6.5-10.2A6.5 6.5 0 0 0 12 4.3a6.5 6.5 0 0 0-6.5 6.5C5.5 15.8 12 21 12 21Z" stroke="currentColor" stroke-width="1.4"/><circle cx="12" cy="11" r="2.2" stroke="currentColor" stroke-width="1.4"/></svg>
                                    <span>{{ $event->location }}</span>
                                </li>
                            </ul>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
(function () {
    const root = document.querySelector('[data-events-slider]');
    if (!root) return;

    const track = root.querySelector('[data-ev-track]');
    const cards = Array.from(root.querySelectorAll('.ev-card'));
    const prev = root.querySelector('[data-ev-prev]');
    const next = root.querySelector('[data-ev-next]');
    const countEl = root.querySelector('[data-ev-count]');
    const total = cards.length;
    let index = 0;

    function visibleCount() {
        const w = window.innerWidth;
        if (w <= 768) return 1;
        if (w <= 900) return 2;
        if (w <= 1100) return 3;
        return 4;
    }

    function maxIndex() {
        return Math.max(0, total - visibleCount());
    }

    function update() {
        const vis = visibleCount();
        if (index > maxIndex()) index = maxIndex();

        const card = cards[0];
        const styles = window.getComputedStyle(track);
        const gap = parseFloat(styles.columnGap || styles.gap) || 0;
        const step = card.getBoundingClientRect().width + gap;
        track.style.transform = 'translateX(' + (-index * step) + 'px)';

        countEl.textContent = Math.min(index + vis, total) + ' / ' + total;
        prev.disabled = index <= 0;
        next.disabled = index >= maxIndex();
    }

    prev.addEventListener('click', function () {
        index = Math.max(0, index - 1);
        update();
    });
    next.addEventListener('click', function () {
        index = Math.min(maxIndex(), index + 1);
        update();
    });

    window.addEventListener('resize', update);
    update();
})();
</script>
@endpush

{{-- Fine art acquisition & leasing --}}
<section class="lease-band" aria-labelledby="lease-band-title">
    <div class="container">
        <div class="lease-band__content">
            <h2 id="lease-band-title">Fine Art Acquisition &amp; Annual Leasing</h2>
            <p>
                Build a living collection without committing capital to every piece. ArtsDiva’s annual leasing
                programme offers estimated rates from 10% of value per annum for works under €25,000,
                scaling down for higher-value acquisitions.
            </p>
            <a class="lease-band__link" href="{{ route('catalogue.index') }}">
                Browse Catalogue <span aria-hidden="true">→</span>
            </a>
        </div>
    </div>
    <div class="lease-band__media">
        <img
            src="{{ asset('images/catalogue/artwork-012.png') }}"
            alt="Fine art acquisition and annual leasing"
        >
    </div>
</section>

{{-- Publications slider --}}

<section class="publications-section" data-publications-slider>
    <div class="container">
        <div class="ex-head">
            <div class="ex-head__left">
                <h2 class="ex-head__title">Publications</h2>
                <span class="ex-head__sep" aria-hidden="true"></span>
                <a class="ex-head__view" href="{{ route('publications') }}">View All <span aria-hidden="true">→</span></a>
            </div>
            <div class="ex-head__nav" role="group" aria-label="Publications slider controls">
                <button type="button" class="ex-nav-btn" data-pub-prev aria-label="Previous publications">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M7.5 2L3.5 6L7.5 10" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
                <span class="ex-head__count" data-pub-count aria-live="polite">1 / {{ count($publications) }}</span>
                <button type="button" class="ex-nav-btn" data-pub-next aria-label="Next publications">
                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" aria-hidden="true"><path d="M4.5 2L8.5 6L4.5 10" stroke="currentColor" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round"/></svg>
                </button>
            </div>
        </div>

        <div class="pub-viewport">
            <div class="pub-track" data-pub-track>
                @foreach($publications as $pub)
                    <article class="pub-card">
                        <div class="pub-card__frame">
                            <img src="{{ $pub->imageUrl() }}" alt="{{ $pub->title }}">
                        </div>
                        <p class="pub-card__artist">{{ $pub->artist_name }}</p>
                        <hr class="pub-card__rule">
                        <h3 class="pub-card__title">{{ $pub->title }}</h3>
                        <p class="pub-card__excerpt">{{ $pub->excerpt }}</p>
                        <a class="pub-card__link" href="{{ route('publications.show', $pub->slug) }}">
                            Read More <span aria-hidden="true">→</span>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
(function () {
    const root = document.querySelector('[data-publications-slider]');
    if (!root) return;

    const track = root.querySelector('[data-pub-track]');
    const cards = Array.from(root.querySelectorAll('.pub-card'));
    const prev = root.querySelector('[data-pub-prev]');
    const next = root.querySelector('[data-pub-next]');
    const countEl = root.querySelector('[data-pub-count]');
    const total = cards.length;
    let index = 0;

    function visibleCount() {
        const w = window.innerWidth;
        if (w <= 768) return 1;
        if (w <= 900) return 2;
        if (w <= 1100) return 3;
        return 4;
    }

    function maxIndex() {
        return Math.max(0, total - visibleCount());
    }

    function update() {
        const vis = visibleCount();
        if (index > maxIndex()) index = maxIndex();

        const card = cards[0];
        const styles = window.getComputedStyle(track);
        const gap = parseFloat(styles.columnGap || styles.gap) || 0;
        const step = card.getBoundingClientRect().width + gap;
        track.style.transform = 'translateX(' + (-index * step) + 'px)';

        countEl.textContent = Math.min(index + vis, total) + ' / ' + total;
        prev.disabled = index <= 0;
        next.disabled = index >= maxIndex();
    }

    prev.addEventListener('click', function () {
        index = Math.max(0, index - 1);
        update();
    });
    next.addEventListener('click', function () {
        index = Math.min(maxIndex(), index + 1);
        update();
    });

    window.addEventListener('resize', update);
    update();
})();
</script>
@endpush

{{-- Curated collections for modern interiors --}}
<section class="feature-split">
    <div class="feature-split__media">
        <img
            src="{{ asset('images/catalogue/artwork-030.png') }}"
            alt="Curated collections for modern interiors"
        >
    </div>
    <div class="feature-split__body">
        <div class="feature-split__content">
            <h2>Curated Collections for Modern Interiors</h2>
            <p>
                From contemporary paintings to timeless masterpieces, our curated selection is designed to
                enhance residential, hospitality, and corporate spaces with exceptional artistic value.
            </p>
            <a class="feature-split__link" href="{{ route('catalogue.index') }}">View Collection <span aria-hidden="true">→</span></a>
        </div>
    </div>
</section>

{{-- Clients & artists CTA --}}
<section class="section audience">
    <div class="container">
        <div class="dual-cta">
            <h2>Discover &amp; Collect Exceptional Art with ArtsDiva</h2>
            <p>
                Expand your collection through our unique leasing and acquisition platform —
                connecting collectors, spaces, and artists worldwide.
            </p>
        </div>
        <div class="dual-grid">
            <article class="dual-card">
                <div class="dual-card__image">
                    <img src="{{ asset('images/catalogue/artwork-028.png') }}" alt="Curated artworks for collectors and spaces">
                </div>
                <div class="dual-card__body">
                    <h3>For Clients</h3>
                    <p>
                        Access a curated collection of exceptional artworks for acquisition or annual leasing,
                        tailored to elevate residential, commercial, and hospitality spaces.
                    </p>
                    <a class="dual-card__link" href="{{ route('catalogue.index') }}">Buy Art Online <span aria-hidden="true">→</span></a>
                </div>
            </article>
            <article class="dual-card">
                <div class="dual-card__image">
                    <img src="{{ asset('images/catalogue/artwork-029.png') }}" alt="Artist showcase on ArtsDiva">
                </div>
                <div class="dual-card__body">
                    <h3>For Artists</h3>
                    <p>
                        Showcase your artwork to collectors, businesses, and designers through a curated
                        platform built to expand your reach and opportunities.
                    </p>
                    <a class="dual-card__link" href="{{ route('contact') }}">Sell Your Art <span aria-hidden="true">→</span></a>
                </div>
            </article>
        </div>
    </div>
</section>
@endsection
