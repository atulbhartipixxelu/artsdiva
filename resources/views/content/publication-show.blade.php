@extends('layouts.app')
@section('title', $publication->title.' — ArtsDiva')
@section('meta_description', \Illuminate\Support\Str::limit($publication->excerpt ?? $publication->title, 155))
@section('content')
<div class="page-hero page-hero--detail">
    <div class="container">
        <nav class="site-crumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="site-crumb__sep" aria-hidden="true"></span>
            <a href="{{ route('publications') }}">Publications</a>
            <span class="site-crumb__sep" aria-hidden="true"></span>
            <span class="site-crumb__current" aria-current="page">{{ $publication->title }}</span>
        </nav>
        <h1>{{ $publication->title }}</h1>
        <p>{{ $publication->artist_name }}</p>
    </div>
</div>

<article class="container publication-detail">
    @if($publication->image)
        <div class="publication-detail__media">
            <img src="{{ $publication->imageUrl() }}" alt="{{ $publication->title }}">
        </div>
    @endif

    <div class="publication-detail__body prose">
        @if($detailText)
            {!! nl2br(e($detailText)) !!}
        @endif

        <div class="publication-detail__actions">
            @if($publication->link_url)
                <a class="btn btn--dark" href="{{ $publication->link_url }}" target="_blank" rel="noopener">Open External Link</a>
            @endif
            @if($artwork)
                <a class="btn btn--outline" href="{{ route('catalogue.show', $artwork->slug) }}">View in Catalogue</a>
            @endif
            <a class="feature-split__link" href="{{ route('publications') }}">← Back to Publications</a>
        </div>
    </div>
</article>
@endsection
