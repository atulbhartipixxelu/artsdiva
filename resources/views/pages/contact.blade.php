@extends('layouts.app')

@section('title', 'Contact — ArtsDiva')
@section('meta_description', 'Contact ArtsDiva for fine art acquisition and annual leasing inquiries.')

@section('content')
<div class="page-hero">
    <div class="container">
        <h1>Contact</h1>
        <p>Reach the ArtsDiva client team for catalogue questions, viewings, or leasing.</p>
    </div>
</div>
<div class="container">
    <div class="prose">
        <h2>Client desk</h2>
        <p>Email: hello@artsdiva.com<br>Phone: +1 (000) 000-0000</p>
        <p>For leasing, use the dedicated <a href="{{ route('inquiry.create') }}">inquiry form</a> so we can capture artwork, duration, and budget in one place.</p>
    </div>
</div>
@endsection
