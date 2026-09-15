@extends('layouts.app')

@section('title', $page->title.' — ArtsDiva')
@section('meta_description', $page->meta_description ?: \Illuminate\Support\Str::limit(strip_tags($page->body), 155))

@section('content')
<div class="page-hero">
    <div class="container">
        <h1>{{ $page->title }}</h1>
        @if($page->subtitle)
            <p>{{ $page->subtitle }}</p>
        @endif
    </div>
</div>
<div class="container">
    <div class="prose">
        @if($page->imageUrl())
            <p><img src="{{ $page->imageUrl() }}" alt="{{ $page->title }}" style="width:100%;max-height:420px;object-fit:cover;margin-bottom:24px;"></p>
        @endif
        {!! nl2br(e($page->body)) !!}
        @if($page->cta_label && $page->cta_url)
            <p style="margin-top:32px;">
                <a class="btn btn--dark" href="{{ site_url($page->cta_url) }}">{{ $page->cta_label }}</a>
            </p>
        @endif
    </div>
</div>
@endsection
