@extends('admin.layout')
@section('title', $item->exists ? 'Edit Exhibition' : 'Add Exhibition')
@section('heading', $item->exists ? 'Edit Exhibition' : 'Add Exhibition')
@section('content')
<div class="panel">
<form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.exhibitions.update',$item) : route('admin.exhibitions.store') }}">
@csrf
@if($item->exists) @method('PUT') @endif
<div class="form-grid">
<div><label>Title *</label><input type="text" name="title" value="{{ old('title',$item->title) }}" required></div>
<div><label>Slug</label><input type="text" name="slug" value="{{ old('slug',$item->slug) }}"></div>
<div class="full"><label>Subtitle</label><input type="text" name="subtitle" value="{{ old('subtitle',$item->subtitle) }}"></div>
<div><label>Dates</label><input type="text" name="dates" value="{{ old('dates',$item->dates) }}"></div>
<div><label>Location</label><input type="text" name="location" value="{{ old('location',$item->location) }}"></div>
<div><label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order',$item->sort_order ?? 0) }}"></div>
<div class="full"><label>Description</label><textarea name="description">{{ old('description',$item->description) }}</textarea></div>
<div><label>Image</label><input type="file" name="image" accept="image/*">@if($item->image)<p><img class="thumb" src="{{ asset($item->image) }}"></p>@endif</div>
<label class="check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published',$item->is_published ?? true))> Published</label>
</div>
<div class="actions" style="margin-top:16px;"><button class="btn" type="submit">Save</button><a class="btn secondary" href="{{ route('admin.exhibitions.index') }}">Cancel</a></div>
</form>
</div>
@endsection
