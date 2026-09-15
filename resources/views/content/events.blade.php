@extends('layouts.app')
@section('title', 'Events — ArtsDiva')
@section('meta_description', 'Forthcoming ArtsDiva events — tours, workshops, learning sessions, and collector evenings.')
@section('content')
<div class="page-hero">
    <div class="container">
        <h1>Events</h1>
        <p>Forthcoming ArtsDiva events.</p>
    </div>
</div>

<section class="events-section events-page">
    <div class="container" style="padding-bottom:72px;">
        <div class="ev-grid">
            @forelse($events as $event)
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
                        <h2 class="ev-card__title">{{ $event->title }}</h2>
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
            @empty
                <p>No events published yet.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
