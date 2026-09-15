@extends('admin.layout')
@section('title', $item->exists ? 'Edit Admin' : 'Add Admin')
@section('heading', $item->exists ? 'Edit Admin' : 'Add Admin')
@section('content')
<div class="panel">
<form method="POST" action="{{ $item->exists ? route('admin.users.update',$item) : route('admin.users.store') }}">
@csrf
@if($item->exists) @method('PUT') @endif
<div class="form-grid">
<div><label>Name *</label><input type="text" name="name" value="{{ old('name',$item->name) }}" required></div>
<div><label>Email *</label><input type="email" name="email" value="{{ old('email',$item->email) }}" required></div>
<div><label>Role *</label>
<select name="role" required>
<option value="admin" @selected(old('role',$item->role)==='admin')>Admin</option>
<option value="superadmin" @selected(old('role',$item->role)==='superadmin')>Superadmin</option>
</select>
</div>
<div><label>Password {{ $item->exists ? '(leave blank to keep)' : '*' }}</label><input type="password" name="password" {{ $item->exists ? '' : 'required' }}></div>
<label class="check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active',$item->is_active ?? true))> Active</label>
</div>
<div class="actions" style="margin-top:16px;"><button class="btn" type="submit">Save</button><a class="btn secondary" href="{{ route('admin.users.index') }}">Cancel</a></div>
</form>
</div>
@endsection
