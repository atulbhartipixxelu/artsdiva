@extends('admin.layout')
@section('title','Artists')
@section('heading','Artists')
@section('content')
<div class="panel">
<div class="toolbar"><strong>{{ $items->total() }} artists</strong><a class="btn" href="{{ route('admin.artists.create') }}">Add Artist</a></div>
<table>
<thead><tr><th></th><th>Name</th><th>City</th><th>Status</th><th></th></tr></thead>
<tbody>
@foreach($items as $item)
<tr class="{{ $item->is_published ? '' : 'is-row-inactive' }}">
<td>@if($item->image)<img class="thumb" src="{{ asset($item->image) }}" alt="">@endif</td>
<td>{{ $item->name }}</td>
<td>{{ $item->city }}</td>
<td>
@include('admin.partials.status-toggle', [
    'active' => $item->is_published,
    'route' => route('admin.toggle-status', ['type' => 'artists', 'id' => $item->id]),
])
</td>
<td class="actions">
<a class="btn secondary" href="{{ route('admin.artists.edit',$item) }}">Edit</a>
<form method="POST" action="{{ route('admin.artists.destroy',$item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn danger" type="submit">Delete</button></form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $items->links() }}
</div>
@endsection
