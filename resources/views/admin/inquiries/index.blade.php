@extends('admin.layout')
@section('title','Inquiries')
@section('heading','Enquire / Inquiries')
@section('content')
<div class="panel">
<table>
<thead><tr><th>Name</th><th>Email</th><th>Artwork</th><th>Status</th><th>Date</th><th></th></tr></thead>
<tbody>
@foreach($items as $item)
<tr>
<td>{{ $item->name }}</td>
<td>{{ $item->email }}</td>
<td>{{ $item->artwork }}</td>
<td>{{ $item->status }}</td>
<td>{{ $item->created_at->format('d M Y H:i') }}</td>
<td class="actions">
<a class="btn secondary" href="{{ route('admin.inquiries.show',$item) }}">View</a>
<form method="POST" action="{{ route('admin.inquiries.destroy',$item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn danger" type="submit">Delete</button></form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $items->links() }}
</div>
@endsection
