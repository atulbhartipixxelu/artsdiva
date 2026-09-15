@extends('admin.layout')
@section('title','Events')
@section('heading','Events')
@section('content')
<div class="panel">
<div class="toolbar"><strong>{{ $items->total() }} events</strong><a class="btn" href="{{ route('admin.events.create') }}">Add Event</a></div>
<table>
<thead><tr><th></th><th>Title</th><th>Date</th><th>Location</th><th>Status</th><th></th></tr></thead>
<tbody>
@foreach($items as $item)
<tr class="{{ $item->is_published ? '' : 'is-row-inactive' }}">
<td>@if($item->image)<img class="thumb" src="{{ asset($item->image) }}" alt="">@endif</td>
<td>{{ $item->title }}</td>
<td>{{ $item->date_label }}</td>
<td>{{ $item->location }}</td>
<td>
@include('admin.partials.status-toggle', [
    'active' => $item->is_published,
    'route' => route('admin.toggle-status', ['type' => 'events', 'id' => $item->id]),
])
</td>
<td class="actions">
<a class="btn secondary" href="{{ route('admin.events.edit',$item) }}">Edit</a>
<form method="POST" action="{{ route('admin.events.destroy',$item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn danger" type="submit">Delete</button></form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $items->links() }}
</div>
@endsection
