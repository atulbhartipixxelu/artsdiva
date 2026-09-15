<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Exhibition;
use App\Models\HeroSlide;
use App\Models\Publication;
use App\Support\ArtworkRepository;

class HomeController extends Controller
{
    public function __invoke(ArtworkRepository $artworks)
    {
        $heroSlides = HeroSlide::published()
            ->orderBy('sort_order')
            ->get()
            ->map(fn (HeroSlide $s) => [
                'image' => $s->imageUrl(),
                'alt' => $s->title,
                'eyebrow' => $s->eyebrow,
                'title' => $s->title,
                'subtitle' => $s->subtitle,
                'button_one_label' => $s->button_one_label ?: 'Browse Catalogue',
                'button_one_url' => site_url($s->button_one_url, route('catalogue.index')),
                'button_two_label' => $s->button_two_label ?: 'Enquire About Leasing',
                'button_two_url' => site_url($s->button_two_url, route('inquiry.create')),
            ])
            ->values()
            ->all();

        if ($heroSlides === []) {
            $heroSlides = [[
                'image' => asset('images/hero-banner-01.png'),
                'alt' => 'ArtsDiva gallery',
                'eyebrow' => 'Featured Collection — Contemporary Art — Worldwide',
                'title' => 'Curated Masterpieces',
                'subtitle' => 'A Journey Through Timeless Expression',
                'button_one_label' => 'Browse Catalogue',
                'button_one_url' => route('catalogue.index'),
                'button_two_label' => 'Enquire About Leasing',
                'button_two_url' => route('inquiry.create'),
            ]];
        }

        return view('home', [
            'heroSlides' => $heroSlides,
            'exhibitions' => Exhibition::published()->orderBy('sort_order')->take(8)->get(),
            'events' => Event::published()->orderBy('sort_order')->take(8)->get(),
            'publications' => Publication::published()->orderBy('sort_order')->take(8)->get(),
        ]);
    }
}
