@extends('layouts.app')
@section('title', 'Artists — ArtsDiva')
@section('meta_description', 'Meet artists featured on ArtsDiva — curated creators across painting, photography, and contemporary interiors.')
@section('content')
<div class="page-hero"><div class="container"><h1>Artists</h1><p>A curated network of artists across acquisition and leasing placements.</p></div></div>
<div class="container" style="padding-bottom:72px;">
<div class="card-grid">
@forelse($artists as $artist)
<article class="card">
<a href="{{ route('artists.show',$artist->slug) }}" class="card__image">
<img src="{{ $artist->image ? asset($artist->image) : asset('images/catalogue/artwork-001.png') }}" alt="{{ $artist->name }}">
</a>
<h2 class="card__title"><a href="{{ route('artists.show',$artist->slug) }}">{{ $artist->name }}</a></h2>
<p class="card__text">{{ $artist->city }}{{ $artist->country ? ', '.$artist->country : '' }}</p>
@if($artist->bio)
<p class="card__text" style="margin-top:8px;">{{ \Illuminate\Support\Str::limit($artist->bio, 110) }}</p>
@endif
</article>
@empty
<p>No artists published yet.</p>
@endforelse
</div>
</div>
@endsection
