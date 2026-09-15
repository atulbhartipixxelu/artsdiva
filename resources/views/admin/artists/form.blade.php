@extends('admin.layout')
@section('title', $item->exists ? 'Edit Artist' : 'Add Artist')
@section('heading', $item->exists ? 'Edit Artist' : 'Add Artist')
@section('content')
<div class="panel">
<form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.artists.update',$item) : route('admin.artists.store') }}">
@csrf
@if($item->exists) @method('PUT') @endif
<div class="form-grid">
<div><label>Name *</label><input type="text" name="name" value="{{ old('name',$item->name) }}" required></div>
<div><label>Slug</label><input type="text" name="slug" value="{{ old('slug',$item->slug) }}"></div>
<div><label>City</label><input type="text" name="city" value="{{ old('city',$item->city) }}"></div>
<div><label>Country</label><input type="text" name="country" value="{{ old('country',$item->country) }}"></div>
<div class="full"><label>Bio</label><textarea name="bio">{{ old('bio',$item->bio) }}</textarea></div>
<div><label>Image</label><input type="file" name="image" accept="image/*">@if($item->image)<p><img class="thumb" src="{{ asset($item->image) }}"></p>@endif</div>
<div><label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order',$item->sort_order ?? 0) }}"></div>
<label class="check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published',$item->is_published ?? true))> Published</label>
<label class="check"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured',$item->is_featured ?? false))> Featured</label>
</div>
<div class="actions" style="margin-top:16px;"><button class="btn" type="submit">Save</button><a class="btn secondary" href="{{ route('admin.artists.index') }}">Cancel</a></div>
</form>
</div>
@endsection