@extends('admin.layout')
@section('title','News')
@section('heading','News')
@section('content')
<div class="panel">
<div class="toolbar"><strong>{{ $items->total() }} posts</strong><a class="btn" href="{{ route('admin.news.create') }}">Add News</a></div>
<table>
<thead><tr><th></th><th>Title</th><th>Status</th><th>Date</th><th></th></tr></thead>
<tbody>
@foreach($items as $item)
<tr class="{{ $item->is_published ? '' : 'is-row-inactive' }}">
<td>@if($item->image)<img class="thumb" src="{{ asset($item->image) }}" alt="">@endif</td>
<td>{{ $item->title }}</td>
<td>
@include('admin.partials.status-toggle', [
    'active' => $item->is_published,
    'route' => route('admin.toggle-status', ['type' => 'news', 'id' => $item->id]),
])
</td>
<td>{{ optional($item->published_at)->format('d M Y') }}</td>
<td class="actions">
<a class="btn secondary" href="{{ route('admin.news.edit',$item) }}">Edit</a>
<form method="POST" action="{{ route('admin.news.destroy',$item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn danger" type="submit">Delete</button></form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $items->links() }}
</div>
@endsection
