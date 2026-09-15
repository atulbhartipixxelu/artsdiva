@extends('layouts.app')

@section('title', 'Services — ArtsDiva')
@section('meta_description', 'ArtsDiva services: fine art acquisition advisory and annual leasing for curated clients.')

@section('content')
<div class="page-hero">
    <div class="container">
        <h1>Services</h1>
        <p>Fine art acquisition and annual leasing for residences, workplaces, and collections.</p>
    </div>
</div>
<div class="container">
    <div class="prose">
        <h2>Acquisition</h2>
        <p>We source and place works matched to scale, palette, and narrative — with transparent pricing in your preferred currency.</p>
        <h2>Annual leasing</h2>
        <p>Lease rates start at 10% per annum for works valued under €25,000 EUR, scaling down for higher-value pieces. Request a lease from any artwork page or via the inquiry form.</p>
        <p style="margin-top:32px;">
            <a class="btn btn--dark" href="{{ route('catalogue.index') }}">Browse Catalogue</a>
            <a class="btn btn--outline" href="{{ route('inquiry.create') }}" style="margin-left:8px;">Leasing Inquiry</a>
        </p>
    </div>
</div>
@endsection
