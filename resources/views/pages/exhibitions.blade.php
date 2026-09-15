@extends('layouts.app')

@section('title', 'Exhibitions — ArtsDiva')
@section('meta_description', 'Explore ArtsDiva exhibitions featuring curated fine art for collectors and partners.')

@section('content')
<div class="page-hero">
    <div class="container">
        <h1>Exhibitions</h1>
        <p>Forthcoming and past exhibitions presented through the ArtsDiva programme.</p>
    </div>
</div>
<div class="container">
    <div class="prose">
        <h2>Seasonal programme</h2>
        <p>Exhibition details will be refreshed as confirmed schedules arrive. In the meantime, explore available works in the catalogue or inquire about private viewings.</p>
        <p style="margin-top:32px;">
            <a class="btn btn--dark" href="{{ route('catalogue.index') }}">Browse Catalogue</a>
            <a class="btn btn--outline" href="{{ route('inquiry.create') }}" style="margin-left:8px;">Leasing Inquiry</a>
        </p>
    </div>
</div>
@endsection
