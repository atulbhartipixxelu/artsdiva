@extends('admin.layout')
@section('title', $item->exists ? 'Edit Event' : 'Add Event')
@section('heading', $item->exists ? 'Edit Event' : 'Add Event')
@section('content')
<div class="panel">
<form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.events.update',$item) : route('admin.events.store') }}">
@csrf
@if($item->exists) @method('PUT') @endif
<div class="form-grid">
<div><label>Title *</label><input type="text" name="title" value="{{ old('title',$item->title) }}" required></div>
<div><label>Slug</label><input type="text" name="slug" value="{{ old('slug',$item->slug) }}"></div>
<div class="full"><label>Tags (comma separated)</label><input type="text" name="tags" value="{{ old('tags', is_array($item->tags) ? implode(', ', $item->tags) : '') }}" placeholder="Tours, Learning"></div>
<div><label>Date label</label><input type="text" name="date_label" value="{{ old('date_label',$item->date_label) }}"></div>
<div><label>Time label</label><input type="text" name="time_label" value="{{ old('time_label',$item->time_label) }}"></div>
<div><label>Location</label><input type="text" name="location" value="{{ old('location',$item->location) }}"></div>
<div><label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order',$item->sort_order ?? 0) }}"></div>
<div class="full"><label>Description</label><textarea name="description">{{ old('description',$item->description) }}</textarea></div>
<div><label>Image</label><input type="file" name="image" accept="image/*">@if($item->image)<p><img class="thumb" src="{{ asset($item->image) }}"></p>@endif</div>
<label class="check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published',$item->is_published ?? true))> Published</label>
</div>
<div class="actions" style="margin-top:16px;"><button class="btn" type="submit">Save</button><a class="btn secondary" href="{{ route('admin.events.index') }}">Cancel</a></div>
</form>
</div>
@endsection
