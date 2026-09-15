@extends('admin.layout')
@section('title','Admins')
@section('heading','Admin Users')
@section('content')
<div class="panel">
<div class="toolbar"><strong>{{ $items->total() }} users</strong><a class="btn" href="{{ route('admin.users.create') }}">Add Admin</a></div>
<table>
<thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th></th></tr></thead>
<tbody>
@foreach($items as $item)
<tr class="{{ $item->is_active ? '' : 'is-row-inactive' }}">
<td>{{ $item->name }}</td>
<td>{{ $item->email }}</td>
<td>{{ $item->role }}</td>
<td>
@include('admin.partials.status-toggle', [
    'active' => $item->is_active,
    'route' => route('admin.toggle-status', ['type' => 'users', 'id' => $item->id]),
])
</td>
<td class="actions">
<a class="btn secondary" href="{{ route('admin.users.edit',$item) }}">Edit</a>
<form method="POST" action="{{ route('admin.users.destroy',$item) }}" onsubmit="return confirm('Delete?')">@csrf @method('DELETE')<button class="btn danger" type="submit">Delete</button></form>
</td>
</tr>
@endforeach
</tbody>
</table>
{{ $items->links() }}
</div>
@endsection
