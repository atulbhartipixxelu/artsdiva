@extends('admin.layout')
@section('title', $item->exists ? 'Edit Publication' : 'Add Publication')
@section('heading', $item->exists ? 'Edit Publication' : 'Add Publication')
@section('content')
<div class="panel">
<form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.publications.update',$item) : route('admin.publications.store') }}">
@csrf
@if($item->exists) @method('PUT') @endif
<div class="form-grid">
<div><label>Artist name *</label><input type="text" name="artist_name" value="{{ old('artist_name',$item->artist_name) }}" required></div>
<div><label>Title *</label><input type="text" name="title" value="{{ old('title',$item->title) }}" required></div>
<div><label>Slug</label><input type="text" name="slug" value="{{ old('slug',$item->slug) }}"></div>
<div><label>Link URL</label><input type="url" name="link_url" value="{{ old('link_url',$item->link_url) }}"></div>
<div class="full"><label>Excerpt / detail text</label><textarea name="excerpt" style="min-height:160px;">{{ old('excerpt',$item->excerpt) }}</textarea></div>
<div><label>Image</label><input type="file" name="image" accept="image/*">@if($item->image)<p><img class="thumb" src="{{ asset($item->image) }}"></p>@endif</div>
<div><label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order',$item->sort_order ?? 0) }}"></div>
<label class="check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published',$item->is_published ?? true))> Published</label>
</div>
<div class="actions" style="margin-top:16px;"><button class="btn" type="submit">Save</button><a class="btn secondary" href="{{ route('admin.publications.index') }}">Cancel</a></div>
</form>
</div>
@endsection
