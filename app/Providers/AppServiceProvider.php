<?php

namespace App\Providers;

use App\Models\Artist;
use App\Models\Artwork;
use App\Models\Event;
use App\Models\Exhibition;
use App\Models\HeroSlide;
use App\Models\NewsPost;
use App\Models\Publication;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.admin');
        Paginator::defaultSimpleView('vendor.pagination.admin');

        if ($root = rtrim((string) config('app.url'), '/')) {
            URL::forceRootUrl($root);
            URL::useAssetOrigin(rtrim((string) (config('app.asset_url') ?: $root), '/'));
            if (str_starts_with($root, 'https://')) {
                URL::forceScheme('https');
            }
        }

        // Subdirectory installs (/dev/artsdiva): request URI is stripped for routing,
        // so paginator must not use raw request()->url() (that drops the folder).
        Paginator::currentPathResolver(function () {
            $root = rtrim((string) config('app.url'), '/');
            $path = trim(request()->path(), '/');

            return $path === '' || $path === '/'
                ? ($root !== '' ? $root : url('/'))
                : ($root !== '' ? $root.'/'.$path : url('/'.$path));
        });

        Route::bind('hero', fn ($value) => HeroSlide::findOrFail($value));
        Route::bind('news', fn ($value) => NewsPost::findOrFail($value));

        View::composer('partials.header', function ($view) {
            $view->with('megaMenu', [
                'artworks' => Artwork::listed()
                    ->with('artist')
                    ->orderBy('sort_order')
                    ->orderByDesc('id')
                    ->limit(3)
                    ->get(),
                'categories' => Artwork::listed()
                    ->whereNotNull('category')
                    ->where('category', '!=', '')
                    ->distinct()
                    ->orderBy('category')
                    ->limit(6)
                    ->pluck('category'),
                'artists' => Artist::published()
                    ->orderByDesc('is_featured')
                    ->orderBy('sort_order')
                    ->limit(5)
                    ->get(),
                'news' => NewsPost::published()
                    ->latest('published_at')
                    ->limit(3)
                    ->get(),
                'events' => Event::published()
                    ->orderBy('sort_order')
                    ->limit(3)
                    ->get(),
                'publications' => Publication::published()
                    ->orderBy('sort_order')
                    ->limit(4)
                    ->get(),
                'exhibitions' => Exhibition::published()
                    ->orderBy('sort_order')
                    ->limit(2)
                    ->get(),
            ]);
        });

        View::composer(['catalogue.index', 'catalogue.show', 'layouts.app'], function ($view) {
            $ids = [];
            if (auth()->check() && auth()->user()->isCustomer()) {
                $ids = \App\Models\Wishlist::where('user_id', auth()->id())
                    ->pluck('artwork_id')
                    ->map(fn ($id) => (string) $id)
                    ->all();
            }
            $view->with('wishlistIds', $ids);
        });
    }
}
