@extends('admin.layout')
@section('title','Artworks')
@section('heading','Artworks / Catalogue')
@section('content')
<div class="panel">
<div class="toolbar" style="display:flex;gap:12px;flex-wrap:wrap;align-items:center;justify-content:space-between;">
    <strong>{{ $items->total() }} artworks</strong>
    <form method="GET" action="{{ route('admin.artworks.index') }}" style="display:flex;gap:8px;align-items:center;">
        <input type="search" name="q" value="{{ $q ?? '' }}" placeholder="Search serial, title, artist…" style="min-width:220px;">
        <button class="btn secondary" type="submit">Search</button>
        @if(!empty($q))
            <a class="btn secondary" href="{{ route('admin.artworks.index') }}">Clear</a>
        @endif
    </form>
    <a class="btn" href="{{ route('admin.artworks.create') }}">Add Artwork</a>
</div>
<table>
<thead><tr><th></th><th>Serial</th><th>Title</th><th>Artist</th><th>Price EUR</th><th>Status</th><th></th></tr></thead>
<tbody>
@forelse($items as $item)
<tr class="{{ $item->is_published ? '' : 'is-row-inactive' }}">
<td>@if($item->thumbnail)<img class="thumb" src="{{ asset($item->thumbnail) }}" alt="">@endif</td>
<td><code>{{ $item->serial_number ?: '—' }}</code></td>
<td>{{ $item->title }}</td>
<td>{{ $item->artist?->name }}</td>
<td>{{ number_format($item->price_eur,0) }}</td>
<td>
@include('admin.partials.status-toggle', [
    'active' => $item->is_published,
    'route' => route('admin.toggle-status', ['type' => 'artworks', 'id' => $item->id]),
])
</td>
<td class="actions">
<a class="btn secondary" href="{{ route('admin.artworks.edit',$item) }}">Edit</a>
<form method="POST" action="{{ route('admin.artworks.destroy',$item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn danger" type="submit">Delete</button></form>
</td>
</tr>
@empty
<tr><td colspan="7">No artworks found.</td></tr>
@endforelse
</tbody>
</table>
{{ $items->links() }}
</div>
@endsection
