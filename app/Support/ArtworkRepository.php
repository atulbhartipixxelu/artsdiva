<?php

namespace App\Support;

use App\Models\Artwork;
use App\Services\CurrencyService;
use App\Services\LeaseRateService;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class ArtworkRepository
{
    public const SIZE_BUCKETS = [
        'small' => ['label' => 'Small', 'max' => 80],
        'medium' => ['label' => 'Medium', 'min' => 80, 'max' => 120],
        'large' => ['label' => 'Large', 'min' => 120, 'max' => 160],
        'xl' => ['label' => 'Extra large', 'min' => 160],
    ];

    public function __construct(
        protected CurrencyService $currency,
        protected LeaseRateService $lease
    ) {}

    public function all(): Collection
    {
        return Artwork::listed()
            ->with('artist')
            ->orderBy('sort_order')
            ->orderBy('title')
            ->get()
            ->map(fn (Artwork $art) => $this->enrich($art));
    }

    public function findBySlug(string $slug): ?array
    {
        $item = Artwork::listed()->with('artist')->where('slug', $slug)->first();

        return $item ? $this->enrich($item) : null;
    }

    public function categories(): Collection
    {
        return Artwork::listed()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->orderBy('category')
            ->pluck('category');
    }

    public function facets(): array
    {
        $all = Artwork::listed()->with('artist')->get();

        $categories = $all->groupBy('category')
            ->filter(fn ($group, $key) => filled($key))
            ->map->count()
            ->sortKeys();

        $mediums = $all->groupBy('medium')
            ->filter(fn ($group, $key) => filled($key))
            ->map->count()
            ->sortKeys();

        $cities = $all->groupBy('city')
            ->filter(fn ($group, $key) => filled($key))
            ->map->count()
            ->sortKeys();

        $artists = $all->groupBy('artist_id')
            ->map(function (Collection $group) {
                $first = $group->first();

                return [
                    'id' => $first->artist_id,
                    'name' => $first->artist?->name ?? 'Unknown Artist',
                    'total' => $group->count(),
                ];
            })
            ->sortBy('name')
            ->values();

        $sizes = collect(self::SIZE_BUCKETS)->mapWithKeys(function ($meta, $key) use ($all) {
            $count = $all->filter(fn (Artwork $art) => $this->matchesSizeBucket($art->dimensions, $key))->count();

            return [$key => ['label' => $meta['label'], 'total' => $count]];
        });

        return [
            'categories' => $categories,
            'mediums' => $mediums,
            'cities' => $cities,
            'artists' => $artists,
            'sizes' => $sizes,
            'price_min_eur' => (float) ($all->min('price_eur') ?? 0),
            'price_max_eur' => (float) ($all->max('price_eur') ?? 0),
        ];
    }

    public function filter(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        $query = Artwork::listed()->with('artist');
        $this->applyFilters($query, $filters);
        $this->applySort($query, $filters['sort'] ?? 'recommended');

        return $query->paginate($perPage)
            ->withPath(url()->current())
            ->withQueryString()
            ->through(fn (Artwork $art) => $this->enrich($art));
    }

    protected function applyFilters(Builder $query, array $filters): void
    {
        $categories = array_values(array_filter((array) ($filters['category'] ?? [])));
        if ($categories) {
            $query->whereIn('category', $categories);
        }

        $artists = array_values(array_filter((array) ($filters['artist'] ?? [])));
        if ($artists) {
            $query->whereIn('artist_id', $artists);
        }

        $mediums = array_values(array_filter((array) ($filters['medium'] ?? [])));
        if ($mediums) {
            $query->whereIn('medium', $mediums);
        }

        $cities = array_values(array_filter((array) ($filters['city'] ?? [])));
        if ($cities) {
            $query->whereIn('city', $cities);
        }

        if (isset($filters['min_price']) && $filters['min_price'] !== '' && $filters['min_price'] !== null) {
            $query->where('price_eur', '>=', (float) $filters['min_price']);
        }
        if (isset($filters['max_price']) && $filters['max_price'] !== '' && $filters['max_price'] !== null) {
            $query->where('price_eur', '<=', (float) $filters['max_price']);
        }

        $q = trim((string) ($filters['q'] ?? ''));
        if ($q !== '') {
            $like = '%'.$q.'%';
            $serialNeedle = '%'.strtoupper(str_replace([' ', '-'], '', $q)).'%';
            $query->where(function (Builder $inner) use ($like, $serialNeedle) {
                $inner->where('artworks.title', 'like', $like)
                    ->orWhere('artworks.serial_number', 'like', $like)
                    ->orWhere('artworks.slug', 'like', $like)
                    ->orWhere('artworks.category', 'like', $like)
                    ->orWhere('artworks.medium', 'like', $like)
                    ->orWhere('artworks.city', 'like', $like)
                    ->orWhere('artworks.description', 'like', $like)
                    ->orWhere('artworks.year', 'like', $like)
                    ->orWhereRaw('UPPER(REPLACE(REPLACE(COALESCE(artworks.serial_number, ""), "-", ""), " ", "")) LIKE ?', [$serialNeedle])
                    ->orWhereHas('artist', function (Builder $artist) use ($like) {
                        $artist->where('name', 'like', $like)
                            ->orWhere('city', 'like', $like)
                            ->orWhere('country', 'like', $like);
                    });
            });
        }

        $sizes = array_values(array_filter((array) ($filters['size'] ?? [])));
        $width = isset($filters['width']) && $filters['width'] !== '' ? (float) $filters['width'] : null;
        $height = isset($filters['height']) && $filters['height'] !== '' ? (float) $filters['height'] : null;

        if ($sizes || $width !== null || $height !== null) {
            $ids = Artwork::listed()->get()
                ->filter(function (Artwork $art) use ($sizes, $width, $height) {
                    if ($sizes) {
                        $ok = false;
                        foreach ($sizes as $bucket) {
                            if ($this->matchesSizeBucket($art->dimensions, $bucket)) {
                                $ok = true;
                                break;
                            }
                        }
                        if (! $ok) {
                            return false;
                        }
                    }

                    [$w, $h] = $this->parseWidthHeight($art->dimensions);
                    if ($width !== null && ($w === null || abs($w - $width) > 5)) {
                        return false;
                    }
                    if ($height !== null && ($h === null || abs($h - $height) > 5)) {
                        return false;
                    }

                    return true;
                })
                ->pluck('id');

            $query->whereIn('id', $ids->isEmpty() ? [-1] : $ids->all());
        }
    }

    protected function applySort(Builder $query, string $sort): void
    {
        match ($sort) {
            'price_asc' => $query->orderBy('price_eur'),
            'price_desc' => $query->orderByDesc('price_eur'),
            'artist' => $query->leftJoin('artists', 'artworks.artist_id', '=', 'artists.id')
                ->orderBy('artists.name')
                ->select('artworks.*'),
            'newest' => $query->orderByDesc('created_at')->orderByDesc('id'),
            default => $query->orderBy('sort_order')->orderByDesc('id'),
        };
    }

    public function matchesSizeBucket(?string $dimensions, string $bucket): bool
    {
        $max = $this->parseMaxCm($dimensions);
        if ($max === null) {
            return false;
        }

        return match ($bucket) {
            'small' => $max < 80,
            'medium' => $max >= 80 && $max < 120,
            'large' => $max >= 120 && $max < 160,
            'xl' => $max >= 160,
            default => false,
        };
    }

    public function parseMaxCm(?string $dimensions): ?float
    {
        if (! $dimensions) {
            return null;
        }
        preg_match_all('/(\d+(?:\.\d+)?)/', $dimensions, $matches);
        if (empty($matches[1])) {
            return null;
        }

        return max(array_map('floatval', $matches[1]));
    }

    public function parseWidthHeight(?string $dimensions): array
    {
        if (! $dimensions) {
            return [null, null];
        }
        preg_match_all('/(\d+(?:\.\d+)?)/', $dimensions, $matches);
        $nums = array_map('floatval', $matches[1] ?? []);

        return [$nums[0] ?? null, $nums[1] ?? null];
    }

    protected function enrich(Artwork $art): array
    {
        $tier = $this->lease->rateFor((float) $art->price_eur);
        $leaseEur = $this->lease->annualLeaseEur((float) $art->price_eur);
        [$width, $height] = $this->parseWidthHeight($art->dimensions);
        // Use linked artist city+country pair (avoids mismatched artwork.city + artist.country).
        $location = collect([
            $art->artist?->city ?: $art->city,
            $art->artist?->country,
        ])->filter()->unique()->implode(', ');

        return [
            'id' => (string) $art->id,
            'artist_id' => $art->artist_id,
            'slug' => $art->slug,
            'serial_number' => $art->serial_number,
            'title' => $art->title,
            'artist' => $art->artist?->name ?? 'Unknown Artist',
            'artist_slug' => $art->artist?->slug,
            'city' => $art->city,
            'country' => $art->artist?->country,
            'location' => $location ?: ($art->city ?? ''),
            'category' => $art->category,
            'price_eur' => (float) $art->price_eur,
            'dimensions' => $art->dimensions,
            'width_cm' => $width,
            'height_cm' => $height,
            'weight' => $art->weight,
            'year' => $art->year,
            'medium' => $art->medium,
            'description' => $art->description,
            'images' => $art->galleryUrls(),
            'thumbnail' => $art->imageUrl(),
            'price_formatted' => $this->currency->format((float) $art->price_eur),
            'lease_rate_label' => $tier['label'],
            'lease_rate' => $tier['rate'],
            'lease_annual_eur' => $leaseEur,
            'lease_annual_formatted' => $this->currency->format($leaseEur),
            'currency' => $this->currency->current(),
        ];
    }
}
