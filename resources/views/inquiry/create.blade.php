@extends('layouts.app')

@section('title', 'Leasing Inquiry — ArtsDiva')
@section('meta_description', 'Request an annual lease with ArtsDiva. Share your details, artwork of interest, desired duration, and budget range.')

@section('content')
<div class="page-hero">
    <div class="container">
        <h1>Leasing Inquiry</h1>
        <p>Tell us about the work you wish to lease. Our team will follow up using the contact details you provide.</p>
    </div>
</div>

<div class="container">
    <div class="form-wrap">
        @if ($errors->any())
            <div class="alert alert--error">
                <strong>Please correct the following:</strong>
                <ul class="error-list">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('inquiry.store') }}" class="form-grid" novalidate>
            @csrf

            <div class="field">
                <label for="name">Full name *</label>
                <input id="name" name="name" type="text" value="{{ old('name') }}" required>
            </div>

            <div class="field">
                <label for="email">Email *</label>
                <input id="email" name="email" type="email" value="{{ old('email') }}" required>
            </div>

            <div class="field">
                <label for="phone">Phone</label>
                <input id="phone" name="phone" type="text" value="{{ old('phone') }}">
            </div>

            <div class="field">
                <label for="artwork">Artwork of interest *</label>
                @php
                    $prefill = old('artwork');
                    if ($prefill === null && $selectedArtwork) {
                        $prefill = $selectedArtwork['title'].' — '.$selectedArtwork['artist'];
                    }
                @endphp
                <select id="artwork" name="artwork" required>
                    <option value="">Select an artwork</option>
                    @foreach($artworks as $art)
                        @php $label = $art['title'].' — '.$art['artist']; @endphp
                        <option value="{{ $label }}" @selected($prefill === $label)>{{ $label }}</option>
                    @endforeach
                    <option value="Other / Not sure" @selected($prefill === 'Other / Not sure')>Other / Not sure</option>
                </select>
            </div>

            <div class="field">
                <label for="lease_duration">Desired lease duration *</label>
                <select id="lease_duration" name="lease_duration" required>
                    <option value="">Select duration</option>
                    @foreach(['6 months', '12 months', '24 months', '36 months', 'Flexible'] as $duration)
                        <option value="{{ $duration }}" @selected(old('lease_duration') === $duration)>{{ $duration }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="budget_range">Budget range (annual) *</label>
                <select id="budget_range" name="budget_range" required>
                    <option value="">Select range</option>
                    @foreach([
                        'Under €2,000',
                        '€2,000 – €5,000',
                        '€5,000 – €10,000',
                        '€10,000 – €25,000',
                        'Over €25,000',
                    ] as $range)
                        <option value="{{ $range }}" @selected(old('budget_range') === $range)>{{ $range }}</option>
                    @endforeach
                </select>
            </div>

            <div class="field field--full">
                <label for="message">Additional notes</label>
                <textarea id="message" name="message" placeholder="Placement, installation needs, preferred viewing…">{{ old('message') }}</textarea>
            </div>

            <div class="form-actions field--full">
                <button type="submit" class="btn btn--dark">Submit Inquiry</button>
                <a class="btn btn--outline" href="{{ route('catalogue.index') }}">Browse Catalogue</a>
            </div>
        </form>
    </div>
</div>
@endsection
