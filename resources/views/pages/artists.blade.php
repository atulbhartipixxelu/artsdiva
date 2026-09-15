@extends('layouts.app')

@section('title', 'Artists — ArtsDiva')
@section('meta_description', 'Meet artists featured on ArtsDiva’s fine art acquisition and leasing platform.')

@section('content')
<div class="page-hero">
    <div class="container">
        <h1>Artists</h1>
        <p>A curated network of artists represented across acquisition and leasing placements.</p>
    </div>
</div>
<div class="container">
    <div class="prose">
        <h2>Featured voices</h2>
        <p>Artist profiles and placement histories will appear here once live listings are approved. Browse the catalogue to see current works by city and category.</p>
        <p style="margin-top:32px;">
            <a class="btn btn--dark" href="{{ route('catalogue.index') }}">Browse Catalogue</a>
        </p>
    </div>
</div>
@endsection
