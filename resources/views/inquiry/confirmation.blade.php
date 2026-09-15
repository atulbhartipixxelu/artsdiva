@extends('layouts.app')

@section('title', 'Inquiry Received — ArtsDiva')
@section('meta_description', 'Your ArtsDiva leasing inquiry has been received.')

@section('content')
<div class="confirm-box">
    <div class="alert alert--success" style="text-align:left;margin-bottom:28px;">
        Your inquiry has been submitted successfully.
    </div>
    <h1>Thank You</h1>
    <p>
        We’ve received your leasing inquiry{{ isset($inquiry['name']) ? ', '.$inquiry['name'] : '' }}.
        Our team will review your request and respond shortly.
    </p>
    @if(!empty($inquiry['artwork']))
        <p><strong>Artwork:</strong> {{ $inquiry['artwork'] }}</p>
    @endif
    <div style="margin-top:28px;display:flex;gap:12px;justify-content:center;flex-wrap:wrap;">
        <a class="btn btn--dark" href="{{ route('catalogue.index') }}">Return to Catalogue</a>
        <a class="btn btn--outline" href="{{ route('home') }}">Home</a>
    </div>
</div>
@endsection
