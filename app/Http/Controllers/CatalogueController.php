<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Artwork;
use App\Services\CurrencyService;
use App\Support\ArtworkRepository;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function index(Request $request, ArtworkRepository $repo, CurrencyService $currency)
    {
        $filters = [
            'category' => array_filter((array) $request->input('category', [])),
            'artist' => array_filter((array) $request->input('artist', [])),
            'medium' => array_filter((array) $request->input('medium', [])),
            'city' => array_filter((array) $request->input('city', [])),
            'size' => array_filter((array) $request->input('size', [])),
            'min_price' => $request->input('min_price'),
            'max_price' => $request->input('max_price'),
            'width' => $request->input('width'),
            'height' => $request->input('height'),
            'sort' => $request->input('sort', 'recommended'),
            'q' => $request->input('q'),
        ];

        // Convert display-currency price inputs to EUR for querying
        $code = $currency->current();
        $rate = $currency->all()[$code]['rate'] ?? 1.0;
        if ($filters['min_price'] !== null && $filters['min_price'] !== '') {
            $filters['min_price'] = round(((float) $filters['min_price']) / max($rate, 0.0001), 2);
        }
        if ($filters['max_price'] !== null && $filters['max_price'] !== '') {
            $filters['max_price'] = round(((float) $filters['max_price']) / max($rate, 0.0001), 2);
        }

        if (! empty($filters['q'])) {
            // simple search via temporary category-like path: handled below
        }

        $facets = $repo->facets();

        // Ignore full-range price filters (drawer always submits min/max)
        if ($filters['min_price'] !== null && $filters['min_price'] !== '') {
            if ((float) $filters['min_price'] <= $facets['price_min_eur'] + 0.5) {
                $filters['min_price'] = '';
            }
        }
        if ($filters['max_price'] !== null && $filters['max_price'] !== '') {
            if ((float) $filters['max_price'] >= $facets['price_max_eur'] - 0.5) {
                $filters['max_price'] = '';
            }
        }

        $artworks = $repo->filter($filters);

        $activeCount = $this->countActiveFilters($filters);
        $chips = $this->buildChips($filters, $facets, $currency);

        return view('catalogue.index', [
            'artworks' => $artworks,
            'facets' => $facets,
            'filters' => $filters,
            'activeFilterCount' => $activeCount,
            'chips' => $chips,
            'currencies' => $currency->all(),
            'currentCurrency' => $currency->current(),
            'currencyMeta' => $currency->all()[$currency->current()],
            'priceMinDisplay' => (int) floor($currency->convertFromEur($facets['price_min_eur'])),
            'priceMaxDisplay' => (int) ceil($currency->convertFromEur($facets['price_max_eur'])),
            'selectedMinDisplay' => $request->input('min_price', ''),
            'selectedMaxDisplay' => $request->input('max_price', ''),
            'searchQuery' => $filters['q'] ?? '',
        ]);
    }

    public function suggest(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        if (mb_strlen($q) < 1) {
            return response()->json([
                'q' => $q,
                'artworks' => [],
                'artists' => [],
            ]);
        }

        $like = '%'.$q.'%';
        $serialNeedle = '%'.strtoupper(str_replace([' ', '-'], '', $q)).'%';

        $artworks = Artwork::listed()
            ->with('artist')
            ->where(function ($query) use ($like, $serialNeedle) {
                $query->where('title', 'like', $like)
                    ->orWhere('serial_number', 'like', $like)
                    ->orWhere('slug', 'like', $like)
                    ->orWhere('category', 'like', $like)
                    ->orWhere('medium', 'like', $like)
                    ->orWhere('city', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhereRaw('UPPER(REPLACE(REPLACE(COALESCE(serial_number, ""), "-", ""), " ", "")) LIKE ?', [$serialNeedle])
                    ->orWhereHas('artist', fn ($a) => $a->where('name', 'like', $like));
            })
            ->orderBy('sort_order')
            ->orderBy('title')
            ->limit(6)
            ->get()
            ->map(fn (Artwork $art) => [
                'type' => 'artwork',
                'title' => $art->title,
                'serial_number' => $art->serial_number,
                'artist' => $art->artist?->name,
                'meta' => collect([$art->serial_number ? 'No. '.$art->serial_number : null, $art->year, $art->category])->filter()->implode(' · '),
                'thumbnail' => $art->imageUrl(),
                'url' => route('catalogue.show', $art->slug),
                'search_url' => route('catalogue.index', ['q' => $art->title]),
            ])
            ->values();

        $artists = Artist::published()
            ->where(function ($query) use ($like) {
                $query->where('name', 'like', $like)
                    ->orWhere('city', 'like', $like)
                    ->orWhere('country', 'like', $like);
            })
            ->withCount(['artworks' => fn ($q) => $q->listed()])
            ->orderBy('sort_order')
            ->orderBy('name')
            ->limit(5)
            ->get()
            ->map(fn (Artist $artist) => [
                'type' => 'artist',
                'title' => $artist->name,
                'meta' => collect([
                    collect([$artist->city, $artist->country])->filter()->implode(', '),
                    $artist->artworks_count.' '.str()->plural('work', $artist->artworks_count),
                ])->filter()->implode(' · '),
                'thumbnail' => $artist->image
                    ? asset($artist->image)
                    : asset('images/catalogue/artwork-001.png'),
                'url' => route('artists.show', $artist->slug),
                'search_url' => route('catalogue.index', ['q' => $artist->name]),
            ])
            ->values();

        return response()->json([
            'q' => $q,
            'artworks' => $artworks,
            'artists' => $artists,
        ]);
    }

    public function show(string $slug, ArtworkRepository $repo, CurrencyService $currency)
    {
        $artwork = $repo->findBySlug($slug);

        abort_if(! $artwork, 404);

        return view('catalogue.show', [
            'artwork' => $artwork,
            'currencies' => $currency->all(),
            'currentCurrency' => $currency->current(),
            'related' => $repo->all()
                ->where('slug', '!=', $slug)
                ->sortBy(fn ($a) => $a['category'] === $artwork['category'] ? 0 : 1)
                ->take(8)
                ->values(),
        ]);
    }

    protected function countActiveFilters(array $filters): int
    {
        $n = 0;
        if (! empty($filters['q'])) {
            $n++;
        }
        foreach (['category', 'artist', 'medium', 'city', 'size'] as $key) {
            $n += count($filters[$key] ?? []);
        }
        foreach (['min_price', 'max_price', 'width', 'height'] as $key) {
            if ($filters[$key] !== null && $filters[$key] !== '') {
                $n++;
            }
        }

        return $n;
    }

    protected function buildChips(array $filters, array $facets, CurrencyService $currency): array
    {
        $chips = [];
        $symbol = $currency->all()[$currency->current()]['symbol'] ?? '';

        if (! empty($filters['q'])) {
            $chips[] = ['label' => 'Search: '.$filters['q'], 'remove' => ['q' => true]];
        }
        foreach ($filters['category'] as $cat) {
            $chips[] = ['label' => $cat, 'remove' => ['category' => $cat]];
        }
        foreach ($filters['artist'] as $id) {
            $artist = collect($facets['artists'])->firstWhere('id', (int) $id);
            $chips[] = ['label' => $artist['name'] ?? 'Artist', 'remove' => ['artist' => $id]];
        }
        foreach ($filters['medium'] as $m) {
            $chips[] = ['label' => $m, 'remove' => ['medium' => $m]];
        }
        foreach ($filters['city'] as $c) {
            $chips[] = ['label' => $c, 'remove' => ['city' => $c]];
        }
        foreach ($filters['size'] as $s) {
            $chips[] = [
                'label' => $facets['sizes'][$s]['label'] ?? $s,
                'remove' => ['size' => $s],
            ];
        }
        if ($filters['min_price'] !== null && $filters['min_price'] !== '') {
            $chips[] = [
                'label' => 'Min '.$symbol.number_format($currency->convertFromEur((float) $filters['min_price']), 0),
                'remove' => ['min_price' => true],
            ];
        }
        if ($filters['max_price'] !== null && $filters['max_price'] !== '') {
            $chips[] = [
                'label' => 'Max '.$symbol.number_format($currency->convertFromEur((float) $filters['max_price']), 0),
                'remove' => ['max_price' => true],
            ];
        }

        return $chips;
    }
}
