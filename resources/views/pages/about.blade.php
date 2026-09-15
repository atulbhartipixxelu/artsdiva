@extends('layouts.app')

@section('title', 'About — ArtsDiva')
@section('meta_description', 'About ArtsDiva — curated fine art acquisition and annual leasing for discerning clients.')

@section('content')
<div class="page-hero">
    <div class="container">
        <h1>About</h1>
        <p>ArtsDiva is a fine art acquisition and annual leasing platform for a curated clientele.</p>
    </div>
</div>
<div class="container">
    <div class="prose">
        <h2>Our approach</h2>
        <p>
            We place exceptional works with collectors and spaces that value craft, narrative, and longevity —
            whether through outright acquisition or a flexible annual lease.
        </p>
        <h2>What we offer</h2>
        <p>
            A transparent catalogue with multi-currency pricing, estimated lease rates, and a dedicated enquiry
            flow so our team can respond with tailored recommendations.
        </p>
        <p style="margin-top:32px;">
            <a class="btn btn--dark" href="{{ route('catalogue.index') }}">Browse Catalogue</a>
            <a class="btn btn--outline" href="{{ route('inquiry.create') }}" style="margin-left:8px;">Enquire</a>
        </p>
    </div>
</div>
@endsection
