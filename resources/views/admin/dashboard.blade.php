@extends('admin.layout')
@section('title','Dashboard')
@section('heading','Dashboard')
@section('content')

<div class="admin-promo">
    <div>
        <p class="admin-promo__kicker">ArtsDiva control panel</p>
        <h2>Your gallery inventory is ready to manage</h2>
        <p>Add artworks with serial numbers, update artists, and publish content for the live site.</p>
    </div>
    <div class="admin-promo__actions">
        <a class="btn" href="{{ route('admin.artworks.create') }}">+ Add artwork</a>
        <a class="btn secondary" href="{{ route('home') }}" target="_blank" rel="noopener">View website</a>
    </div>
</div>

@if(($stats['inquiries'] ?? 0) > 0)
<div class="admin-alert">
    <div>
        <strong>New enquiries waiting</strong>
        <p>Review recent leasing / purchase enquiries from the website.</p>
    </div>
    <a class="btn warn" href="{{ route('admin.inquiries.index') }}">See details</a>
</div>
@endif

<div class="admin-plan-card">
    <div class="admin-plan-card__head">
        <div>
            <span class="admin-pill">Live</span>
            <h3>ArtsDiva catalogue</h3>
            <p>pixxelu.com/dev/artsdiva</p>
        </div>
        <div class="admin-plan-card__actions">
            <a class="btn" href="{{ route('admin.artworks.create') }}">+ Add artwork</a>
            <a class="btn secondary" href="{{ route('admin.artists.create') }}">Add artist</a>
        </div>
    </div>

    <div class="stats">
        @foreach($stats as $label => $value)
            <div class="stat">
                <strong>{{ $value }}</strong>
                <span>{{ str_replace('_',' ',$label) }}</span>
            </div>
        @endforeach
    </div>
</div>

<div class="admin-grid-2">
    <div class="panel">
        <div class="toolbar">
            <div>
                <h2 class="panel-title">Quick links</h2>
                <p class="panel-sub">Jump to the modules you use most</p>
            </div>
        </div>
        <div class="admin-quick">
            <a href="{{ route('admin.artworks.index') }}" class="admin-quick__item">
                <strong>Artworks</strong>
                <span>Serials, images, publish status</span>
            </a>
            <a href="{{ route('admin.artists.index') }}" class="admin-quick__item">
                <strong>Artists</strong>
                <span>Profiles and bios</span>
            </a>
            <a href="{{ route('admin.inquiries.index') }}" class="admin-quick__item">
                <strong>Inquiries</strong>
                <span>Leasing & purchase requests</span>
            </a>
            <a href="{{ route('admin.publications.index') }}" class="admin-quick__item">
                <strong>Publications</strong>
                <span>Editorial features</span>
            </a>
        </div>
    </div>

    <div class="panel">
        <div class="toolbar">
            <div>
                <h2 class="panel-title">Recent enquiries</h2>
                <p class="panel-sub">Latest form submissions</p>
            </div>
            <a class="btn secondary" href="{{ route('admin.inquiries.index') }}">View all</a>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Artwork</th>
                    <th>Status</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
            @forelse($recentInquiries as $inq)
                <tr>
                    <td><a class="table-link" href="{{ route('admin.inquiries.show',$inq) }}">{{ $inq->name }}</a></td>
                    <td>{{ $inq->artwork }}</td>
                    <td><span class="status-chip">{{ $inq->status }}</span></td>
                    <td>{{ $inq->created_at->format('d M Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="4">No enquiries yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
