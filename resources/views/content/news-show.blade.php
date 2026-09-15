@extends('layouts.app')
@section('title', $post->title.' — ArtsDiva')
@section('content')
<div class="page-hero page-hero--detail">
    <div class="container">
        <nav class="site-crumb" aria-label="Breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span class="site-crumb__sep" aria-hidden="true"></span>
            <a href="{{ route('news') }}">News</a>
            <span class="site-crumb__sep" aria-hidden="true"></span>
            <span class="site-crumb__current" aria-current="page">{{ $post->title }}</span>
        </nav>
        <h1>{{ $post->title }}</h1>
        <p>{{ optional($post->published_at)->format('d M Y') }}</p>
    </div>
</div>
<div class="container prose" style="max-width:760px;margin:40px auto 80px;">
@if($post->image)<p><img src="{{ $post->imageUrl() }}" alt="{{ $post->title }}" style="width:100%;margin-bottom:20px;"></p>@endif
{!! nl2br(e($post->body)) !!}
</div>
@endsection
