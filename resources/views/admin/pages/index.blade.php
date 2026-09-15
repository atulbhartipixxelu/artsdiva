@extends('admin.layout')
@section('title','Pages')
@section('heading','Pages (About / Leasing / Contact)')
@section('content')
<div class="panel">
<table>
<thead><tr><th>Title</th><th>Slug</th><th>Status</th><th></th></tr></thead>
<tbody>
@foreach($items as $item)
<tr class="{{ $item->is_published ? '' : 'is-row-inactive' }}">
<td>{{ $item->title }}</td>
<td>{{ $item->slug }}</td>
<td>
@include('admin.partials.status-toggle', [
    'active' => $item->is_published,
    'route' => route('admin.toggle-status', ['type' => 'pages', 'id' => $item->id]),
])
</td>
<td><a class="btn secondary" href="{{ route('admin.pages.edit',$item) }}">Edit</a></td>
</tr>
@endforeach
</tbody>
</table>
{{ $items->links() }}
</div>
@endsection
