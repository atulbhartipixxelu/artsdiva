@extends('layouts.app')
@section('title', 'News — ArtsDiva')
@section('meta_description', 'ArtsDiva news — collection updates, leasing notes, and curator stories from the fine art platform.')
@section('content')
<div class="page-hero"><div class="container"><h1>News</h1><p>Collection updates, leasing notes, and curator stories from ArtsDiva.</p></div></div>
<div class="container" style="padding-bottom:72px;">
<div class="card-grid">
@forelse($posts as $post)
<article class="card">
<a href="{{ route('news.show',$post->slug) }}" class="card__image"><img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}"></a>
<h2 class="card__title"><a href="{{ route('news.show',$post->slug) }}">{{ $post->title }}</a></h2>
<p class="card__text">{{ $post->excerpt }}</p>
</article>
@empty
<p>No news published yet.</p>
@endforelse
</div>
<div style="margin-top:24px;">{{ $posts->links() }}</div>
</div>
@endsection
