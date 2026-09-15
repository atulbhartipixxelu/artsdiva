@extends('layouts.app')
@section('title', 'Exhibitions — ArtsDiva')
@section('content')
<div class="page-hero"><div class="container"><h1>Exhibitions</h1><p>Forthcoming and featured exhibitions.</p></div></div>
<div class="container" style="padding-bottom:72px;">
<div class="card-grid">
@forelse($exhibitions as $item)
<article class="card">
<div class="card__image"><img src="{{ $item->imageUrl() }}" alt="{{ $item->title }}"></div>
<h2 class="card__title">{{ $item->title }}</h2>
<p class="card__text">{{ $item->subtitle }}</p>
<div class="card__meta"><span>{{ $item->dates }}</span><span>{{ $item->location }}</span></div>
</article>
@empty
<p>No exhibitions published yet.</p>
@endforelse
</div>
</div>
@endsection
