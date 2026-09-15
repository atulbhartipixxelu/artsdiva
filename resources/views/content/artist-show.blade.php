@extends('layouts.app')
@section('title', $artist->name.' — ArtsDiva')
@section('meta_description', \Illuminate\Support\Str::limit($artist->bio ?? ($artist->name.' on ArtsDiva'), 155))
@section('content')
<div class="page-hero page-hero--detail">
    <div class="container">
        <nav class="site-crumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="site-crumb__sep" aria-hidden="true"></span>
            <a href="{{ route('artists') }}">Artists</a>
            <span class="site-crumb__sep" aria-hidden="true"></span>
            <span class="site-crumb__current" aria-current="page">{{ $artist->name }}</span>
        </nav>
        <h1>{{ $artist->name }}</h1>
        <p>
            @if($artist->country){{ $artist->country }}@endif
            @if($artist->city){{ $artist->country ? ' | ' : '' }}{{ $artist->city }}@endif
        </p>
    </div>
</div>

<div class="container artist-profile">
    <div class="artist-profile__media">
        @if($artist->image)
            <img src="{{ asset($artist->image) }}" alt="{{ $artist->name }}">
        @endif
    </div>
    <div class="artist-profile__body prose">
        <h2>Artist Info</h2>
        @if($artist->bio)
            {!! nl2br(e($artist->bio)) !!}
        @endif
        <p class="artist-profile__cta">
            <a class="feature-split__link" href="{{ route('catalogue.index', ['artist' => [$artist->id]]) }}">View artworks in catalogue <span aria-hidden="true">→</span></a>
        </p>
    </div>
</div>

<div class="container" style="padding-bottom:72px;">
    <h2 class="section-title" style="margin-bottom:24px;">Artworks</h2>
    <div class="card-grid">
    @forelse($artworks as $art)
    <article class="card">
        <a href="{{ route('catalogue.show',$art->slug) }}" class="card__image">
            <img src="{{ $art->imageUrl() }}" alt="{{ $art->title }}">
        </a>
        <h3 class="card__title">
            <a href="{{ route('catalogue.show',$art->slug) }}">{{ $art->title }}</a>
        </h3>
        <p class="card__text">
            {{ $artist->name }}@if($art->year), {{ $art->year }}@endif
        </p>
    </article>
    @empty
    <p>No published artworks for this artist yet.</p>
    @endforelse
    </div>
</div>
@endsection
