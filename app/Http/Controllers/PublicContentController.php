<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Event;
use App\Models\Exhibition;
use App\Models\NewsPost;
use App\Models\Publication;

class PublicContentController extends Controller
{
    public function artists()
    {
        return view('content.artists', [
            'artists' => Artist::published()->orderBy('sort_order')->orderBy('name')->get(),
        ]);
    }

    public function artistShow(string $slug)
    {
        $artist = Artist::published()->where('slug', $slug)->firstOrFail();

        return view('content.artist-show', [
            'artist' => $artist,
            'artworks' => $artist->artworks()->published()->orderBy('sort_order')->orderBy('title')->get(),
        ]);
    }

    public function news()
    {
        return view('content.news', [
            'posts' => NewsPost::published()->latest('published_at')->latest()->paginate(9),
        ]);
    }

    public function newsShow(string $slug)
    {
        $post = NewsPost::published()->where('slug', $slug)->firstOrFail();

        return view('content.news-show', compact('post'));
    }

    public function events()
    {
        return view('content.events', [
            'events' => Event::published()->orderByDesc('id')->get(),
        ]);
    }

    public function exhibitions()
    {
        return view('content.exhibitions', [
            'exhibitions' => Exhibition::published()->orderBy('sort_order')->latest()->get(),
        ]);
    }

    public function publications()
    {
        return view('content.publications', [
            'publications' => Publication::published()->orderByDesc('id')->get(),
        ]);
    }

    public function publicationShow(string $slug)
    {
        $publication = Publication::published()->where('slug', $slug)->firstOrFail();
        $artwork = \App\Models\Artwork::published()
            ->where('title', $publication->title)
            ->first();

        return view('content.publication-show', [
            'publication' => $publication,
            'artwork' => $artwork,
            'detailText' => $artwork?->description ?: $publication->excerpt,
        ]);
    }
}
