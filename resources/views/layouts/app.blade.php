<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('partials.developer-signature')
    <title>@yield('title', 'ArtsDiva — Fine Art Acquisition & Annual Leasing')</title>
    <meta name="description" content="@yield('meta_description', 'ArtsDiva is a curated fine art acquisition and annual leasing platform for discerning collectors and spaces.')">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,500;0,600;0,700;1,500&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/artsdiva.css') }}">
    @stack('head')
</head>
<body class="@yield('body_class')">
    @include('partials.header')

    <main>
        @yield('content')
    </main>

    @hasSection('hide_footer')
    @else
        @include('partials.footer')
    @endif
    <script>
        (function () {
            const toggle = document.querySelector('[data-nav-toggle]');
            const nav = document.querySelector('[data-main-nav]');
            const backdrop = document.querySelector('[data-nav-backdrop]');
            const closeBtn = document.querySelector('[data-nav-close]');
            const megaItems = Array.from(document.querySelectorAll('[data-mega]'));
            const mqMobile = window.matchMedia('(max-width: 768px)');
            let hoverTimer = null;

            function setNavOpen(open) {
                if (!nav || !toggle) return;
                nav.classList.toggle('is-open', open);
                if (backdrop) {
                    backdrop.classList.toggle('is-open', open);
                    backdrop.hidden = !open;
                    backdrop.setAttribute('aria-hidden', open ? 'false' : 'true');
                }
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
                toggle.setAttribute('aria-label', open ? 'Close menu' : 'Toggle menu');
                document.body.classList.toggle('nav-open', open);
                if (!open) closeAllMegas();
            }

            function closeAllMegas(except) {
                megaItems.forEach(function (item) {
                    if (except && item === except) return;
                    item.classList.remove('is-open');
                    const trigger = item.querySelector('[data-mega-trigger]');
                    const panel = item.querySelector('[data-mega-panel]');
                    if (trigger) trigger.setAttribute('aria-expanded', 'false');
                    if (panel) panel.setAttribute('hidden', '');
                });
            }

            function openMega(item) {
                closeAllMegas(item);
                item.classList.add('is-open');
                const trigger = item.querySelector('[data-mega-trigger]');
                const panel = item.querySelector('[data-mega-panel]');
                if (trigger) trigger.setAttribute('aria-expanded', 'true');
                if (panel) panel.removeAttribute('hidden');
            }

            function toggleMega(item) {
                if (item.classList.contains('is-open')) {
                    closeAllMegas();
                } else {
                    openMega(item);
                }
            }

            if (toggle && nav) {
                toggle.addEventListener('click', function () {
                    setNavOpen(!nav.classList.contains('is-open'));
                });
            }
            if (closeBtn) {
                closeBtn.addEventListener('click', function () {
                    setNavOpen(false);
                });
            }
            if (backdrop) {
                backdrop.addEventListener('click', function () {
                    setNavOpen(false);
                });
            }

            megaItems.forEach(function (item) {
                const trigger = item.querySelector('[data-mega-trigger]');
                if (!trigger) return;

                item.addEventListener('mouseenter', function () {
                    if (mqMobile.matches) return;
                    clearTimeout(hoverTimer);
                    openMega(item);
                });
                item.addEventListener('mouseleave', function () {
                    if (mqMobile.matches) return;
                    clearTimeout(hoverTimer);
                    hoverTimer = setTimeout(function () {
                        if (!item.contains(document.activeElement)) {
                            closeAllMegas();
                        }
                    }, 120);
                });

                trigger.addEventListener('focus', function () {
                    if (mqMobile.matches) return;
                    openMega(item);
                });

                // Mobile: first tap opens mega; second tap follows the link.
                trigger.addEventListener('click', function (e) {
                    if (!mqMobile.matches) return;
                    if (!item.classList.contains('is-open')) {
                        e.preventDefault();
                        toggleMega(item);
                    }
                });
            });

            if (nav) {
                nav.querySelectorAll('a').forEach(function (link) {
                    link.addEventListener('click', function (e) {
                        if (link.hasAttribute('data-mega-trigger') && mqMobile.matches) {
                            return;
                        }
                        if (mqMobile.matches) {
                            setNavOpen(false);
                        }
                    });
                });
            }

            document.addEventListener('keydown', function (e) {
                if (e.key === 'Escape') {
                    closeAllMegas();
                    setNavOpen(false);
                }
            });

            document.addEventListener('click', function (e) {
                if (mqMobile.matches) return;
                if (!e.target.closest('[data-mega]') && !e.target.closest('[data-main-nav]')) {
                    closeAllMegas();
                }
            });

            mqMobile.addEventListener('change', function () {
                closeAllMegas();
            });

            const searchToggle = document.querySelector('[data-search-toggle]');
            const searchPanel = document.querySelector('[data-search-panel]');
            const searchInput = document.getElementById('header-search-input');
            if (searchToggle && searchPanel) {
                // Keep active search value visible after submit
                if (searchInput && searchInput.value.trim() !== '') {
                    searchPanel.removeAttribute('hidden');
                    searchToggle.setAttribute('aria-expanded', 'true');
                    searchToggle.classList.add('is-active');
                }
                searchToggle.addEventListener('click', function () {
                    const open = searchPanel.hasAttribute('hidden');
                    if (open) {
                        searchPanel.removeAttribute('hidden');
                        searchToggle.setAttribute('aria-expanded', 'true');
                        if (searchInput) searchInput.focus();
                    } else {
                        searchPanel.setAttribute('hidden', '');
                        searchToggle.setAttribute('aria-expanded', 'false');
                    }
                });
            }

            // Live search suggestions (artworks + artists under the keyword)
            const suggestUrl = @json(route('catalogue.suggest'));
            const catalogueIndexUrl = @json(route('catalogue.index'));
            function escapeHtml(str) {
                return String(str || '').replace(/[&<>"']/g, function (ch) {
                    return ({ '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#39;' })[ch];
                });
            }
            function renderSuggest(panel, data, keyword) {
                const arts = data.artworks || [];
                const artists = data.artists || [];
                if (!arts.length && !artists.length) {
                    panel.innerHTML = '<div class="live-search__empty">No matches for <strong>' + escapeHtml(keyword) + '</strong></div>';
                    panel.removeAttribute('hidden');
                    return;
                }
                let html = '<div class="live-search__keyword">Searching for <strong>“' + escapeHtml(keyword) + '”</strong></div>';
                if (artists.length) {
                    html += '<div class="live-search__group"><p class="live-search__label">Artists</p>';
                    artists.forEach(function (item) {
                        html += '<a class="live-search__item" href="' + escapeHtml(item.url) + '">'
                            + '<img src="' + escapeHtml(item.thumbnail) + '" alt="" loading="lazy">'
                            + '<span class="live-search__text"><span class="live-search__title">' + escapeHtml(item.title) + '</span>'
                            + '<span class="live-search__meta">' + escapeHtml(item.meta || '') + '</span></span></a>';
                    });
                    html += '</div>';
                }
                if (arts.length) {
                    html += '<div class="live-search__group"><p class="live-search__label">Artworks</p>';
                    arts.forEach(function (item) {
                        html += '<a class="live-search__item" href="' + escapeHtml(item.url) + '">'
                            + '<img src="' + escapeHtml(item.thumbnail) + '" alt="" loading="lazy">'
                            + '<span class="live-search__text"><span class="live-search__title">' + escapeHtml(item.title) + '</span>'
                            + '<span class="live-search__meta">' + escapeHtml([item.artist, item.meta].filter(Boolean).join(' · ')) + '</span></span></a>';
                    });
                    html += '</div>';
                }
                html += '<a class="live-search__all" href="' + escapeHtml(catalogueIndexUrl + '?q=' + encodeURIComponent(keyword)) + '">View all results for “' + escapeHtml(keyword) + '”</a>';
                panel.innerHTML = html;
                panel.removeAttribute('hidden');
            }
            document.querySelectorAll('[data-live-search]').forEach(function (form) {
                const input = form.querySelector('[data-live-search-input]');
                const panel = form.querySelector('[data-live-search-panel]');
                if (!input || !panel) return;
                let timer = null;
                let lastQ = '';
                function hidePanel() { panel.setAttribute('hidden', ''); }
                function fetchSuggest(q) {
                    if (q === lastQ && !panel.hasAttribute('hidden')) return;
                    lastQ = q;
                    fetch(suggestUrl + '?q=' + encodeURIComponent(q), {
                        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
                    })
                        .then(function (res) { return res.json(); })
                        .then(function (data) {
                            if (input.value.trim() !== q) return;
                            renderSuggest(panel, data, q);
                        })
                        .catch(function () { hidePanel(); });
                }
                input.addEventListener('input', function () {
                    const q = input.value.trim();
                    clearTimeout(timer);
                    if (q.length < 1) { hidePanel(); return; }
                    timer = setTimeout(function () { fetchSuggest(q); }, 220);
                });
                input.addEventListener('focus', function () {
                    const q = input.value.trim();
                    if (q.length >= 1) fetchSuggest(q);
                });
                document.addEventListener('click', function (e) {
                    if (!form.contains(e.target)) hidePanel();
                });
                input.addEventListener('keydown', function (e) {
                    if (e.key === 'Escape') hidePanel();
                });
            });
        })();
    </script>
    @stack('scripts')
    @include('partials.developer-signature-foot')
</body>
</html>
