@extends('layouts.app')

@section('title', 'Services — ArtsDiva')
@section('meta_description', 'ArtsDiva services: fine art acquisition advisory and annual leasing for curated clients.')

@section('content')
@php $tiers = config('artsdiva.lease_tiers'); @endphp
<div class="page-hero">
    <div class="container">
        <h1>Services</h1>
        <p>Fine art acquisition and annual leasing for residences, workplaces, and collections.</p>
    </div>
</div>
<div class="container">
    <div class="prose">
        <h2>Acquisition</h2>
        <p>We source and place works matched to scale, palette, and narrative — with transparent pricing in your preferred currency (EUR, USD, INR, CNY, JPY). Catalogue prices are stored in EUR and converted live using published display rates.</p>
        <h2>Annual leasing</h2>
        <p>Lease rates start at <strong>10% per annum</strong> for works valued under €25,000, then scale down for higher-value pieces. Annual lease = acquisition value (EUR) × rate for that tier.</p>

        <div class="lease-rate-table-wrap" style="margin:28px 0;overflow-x:auto">
            <table class="lease-rate-table" style="width:100%;border-collapse:collapse;font-size:15px">
                <thead>
                    <tr>
                        <th style="text-align:left;padding:10px 12px;border-bottom:1px solid #ddd">Acquisition value (EUR)</th>
                        <th style="text-align:left;padding:10px 12px;border-bottom:1px solid #ddd">Annual lease rate</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tiers as $tier)
                    <tr>
                        <td style="padding:10px 12px;border-bottom:1px solid #eee">
                            @if($tier['max'] === null)
                                €{{ number_format($tiers[count($tiers)-2]['max'] ?? 100000) }} and above
                            @elseif($loop->first)
                                Under €{{ number_format($tier['max']) }}
                            @else
                                €{{ number_format($tiers[$loop->index-1]['max']) }} – under €{{ number_format($tier['max']) }}
                            @endif
                        </td>
                        <td style="padding:10px 12px;border-bottom:1px solid #eee"><strong>{{ $tier['label'] }}</strong> per annum</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <p style="margin-top:32px;">
            <a class="btn btn--dark" href="{{ route('catalogue.index') }}">Browse Catalogue</a>
            <a class="btn btn--outline" href="{{ route('inquiry.create') }}" style="margin-left:8px;">Leasing Inquiry</a>
        </p>
    </div>
</div>
@endsection
