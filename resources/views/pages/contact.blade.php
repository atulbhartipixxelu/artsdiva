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
        <p>
            Email: <a href="mailto:hello@artsdiva.art">hello@artsdiva.art</a><br>
            Sales: <a href="tel:+919987821640">+91 99878 21640</a><br>
            Acquisitions: <a href="tel:+917700916880">+91 77009 16880</a><br>
            Administrative office (accounting, shipping, warehousing): <a href="tel:+912262584594">+91 22-6258 4594</a>
        </p>
        <p>For leasing, use the dedicated <a href="{{ route('inquiry.create') }}">inquiry form</a> so we can capture artwork, duration, and budget in one place.</p>
    </div>
</div>
@endsection
