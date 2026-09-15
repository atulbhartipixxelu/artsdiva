@extends('admin.layout')
@section('title', $item->exists ? 'Edit News' : 'Add News')
@section('heading', $item->exists ? 'Edit News' : 'Add News')
@section('content')
<div class="panel">
<form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.news.update',$item) : route('admin.news.store') }}">
@csrf
@if($item->exists) @method('PUT') @endif
<div class="form-grid">
<div><label>Title *</label><input type="text" name="title" value="{{ old('title',$item->title) }}" required></div>
<div><label>Slug</label><input type="text" name="slug" value="{{ old('slug',$item->slug) }}"></div>
<div><label>Published at</label><input type="datetime-local" name="published_at" value="{{ old('published_at', optional($item->published_at)->format('Y-m-d\TH:i')) }}"></div>
<div><label>Image</label><input type="file" name="image" accept="image/*">@if($item->image)<p><img class="thumb" src="{{ asset($item->image) }}"></p>@endif</div>
<div class="full"><label>Excerpt</label><textarea name="excerpt">{{ old('excerpt',$item->excerpt) }}</textarea></div>
<div class="full"><label>Body</label><textarea name="body" style="min-height:220px">{{ old('body',$item->body) }}</textarea></div>
<label class="check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published',$item->is_published ?? true))> Published</label>
</div>
<div class="actions" style="margin-top:16px;"><button class="btn" type="submit">Save</button><a class="btn secondary" href="{{ route('admin.news.index') }}">Cancel</a></div>
</form>
</div>
@endsection
