@extends('admin.layout')
@section('title','Hero Slides')
@section('heading','Hero Slides')
@section('content')
<div class="panel">
<div class="toolbar"><strong>{{ $items->count() }} slides</strong><a class="btn" href="{{ route('admin.hero.create') }}">Add Slide</a></div>
<table>
<thead><tr><th></th><th>Title</th><th>Order</th><th>Status</th><th></th></tr></thead>
<tbody>
@foreach($items as $item)
<tr class="{{ $item->is_published ? '' : 'is-row-inactive' }}">
<td>@if($item->image)<img class="thumb" src="{{ asset($item->image) }}" alt="">@endif</td>
<td>{{ $item->title }}</td>
<td>{{ $item->sort_order }}</td>
<td>
@include('admin.partials.status-toggle', [
    'active' => $item->is_published,
    'route' => route('admin.toggle-status', ['type' => 'hero', 'id' => $item->id]),
])
</td>
<td class="actions">
<a class="btn secondary" href="{{ route('admin.hero.edit',$item) }}">Edit</a>
<form method="POST" action="{{ route('admin.hero.destroy',$item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn danger" type="submit">Delete</button></form>
</td>
</tr>
@endforeach
</tbody>
</table>
</div>
@endsection
