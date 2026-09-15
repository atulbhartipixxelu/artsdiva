@extends('admin.layout')
@section('title','Edit Page')
@section('heading', 'Edit Page — '.$item->slug)
@section('content')
<div class="panel">
<form method="POST" enctype="multipart/form-data" action="{{ route('admin.pages.update',$item) }}">
@csrf @method('PUT')
<div class="form-grid">
<div><label>Title *</label><input type="text" name="title" value="{{ old('title',$item->title) }}" required></div>
<div><label>Slug</label><input type="text" value="{{ $item->slug }}" disabled></div>
<div class="full"><label>Subtitle</label><input type="text" name="subtitle" value="{{ old('subtitle',$item->subtitle) }}"></div>
<div class="full"><label>Body (HTML allowed)</label><textarea name="body" style="min-height:240px">{{ old('body',$item->body) }}</textarea></div>
<div><label>CTA label</label><input type="text" name="cta_label" value="{{ old('cta_label',$item->cta_label) }}"></div>
<div><label>CTA URL</label><input type="text" name="cta_url" value="{{ old('cta_url',$item->cta_url) }}"></div>
<div class="full"><label>Meta description</label><input type="text" name="meta_description" value="{{ old('meta_description',$item->meta_description) }}"></div>
<div><label>Image</label><input type="file" name="image" accept="image/*">@if($item->image)<p><img class="thumb" src="{{ asset($item->image) }}"></p>@endif</div>
<label class="check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published',$item->is_published ?? true))> Published</label>
</div>
<div class="actions" style="margin-top:16px;"><button class="btn" type="submit">Save Page</button><a class="btn secondary" href="{{ route('admin.pages.index') }}">Back</a></div>
</form>
</div>
@endsection
