@extends('layouts.app')
@section('title', 'Publications — ArtsDiva')
@section('meta_description', 'ArtsDiva publications on fine art acquisition, interiors, and leasing.')
@section('content')
<div class="page-hero">
    <div class="container">
        <h1>Publications</h1>
        <p>Essays, catalogues, and collecting notes from the ArtsDiva library.</p>
    </div>
</div>

<section class="publications-section publications-page">
    <div class="container" style="padding-bottom:72px;">
        <div class="pub-grid">
            @forelse($publications as $pub)
                <article class="pub-card">
                    <a href="{{ route('publications.show', $pub->slug) }}" class="pub-card__frame">
                        <img src="{{ $pub->imageUrl() }}" alt="{{ $pub->title }}">
                    </a>
                    <p class="pub-card__artist">{{ $pub->artist_name }}</p>
                    <hr class="pub-card__rule">
                    <h2 class="pub-card__title">
                        <a href="{{ route('publications.show', $pub->slug) }}">{{ $pub->title }}</a>
                    </h2>
                    <p class="pub-card__excerpt">{{ $pub->excerpt }}</p>
                    <a class="pub-card__link" href="{{ route('publications.show', $pub->slug) }}">
                        Read More <span aria-hidden="true">→</span>
                    </a>
                </article>
            @empty
                <p>No publications published yet.</p>
            @endforelse
        </div>
    </div>
</section>
@endsection
