@extends('admin.layout')
@section('title', $item->exists ? 'Edit Hero Slide' : 'Add Hero Slide')
@section('heading', $item->exists ? 'Edit Hero Slide' : 'Add Hero Slide')
@section('content')
<div class="panel">
<form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.hero.update',$item) : route('admin.hero.store') }}">
@csrf
@if($item->exists) @method('PUT') @endif
<div class="form-grid">
<div class="full"><label>Eyebrow</label><input type="text" name="eyebrow" value="{{ old('eyebrow',$item->eyebrow) }}"></div>
<div class="full"><label>Title *</label><input type="text" name="title" value="{{ old('title',$item->title) }}" required></div>
<div class="full"><label>Subtitle</label><input type="text" name="subtitle" value="{{ old('subtitle',$item->subtitle) }}"></div>
<div><label>Button 1 label</label><input type="text" name="button_one_label" value="{{ old('button_one_label',$item->button_one_label) }}"></div>
<div><label>Button 1 URL</label><input type="text" name="button_one_url" value="{{ old('button_one_url',$item->button_one_url) }}" placeholder="catalogue"><small style="display:block;color:#666;margin-top:4px">Path only (e.g. <code>catalogue</code>), not main-domain or <code>/catalogue</code>.</small></div>
<div><label>Button 2 label</label><input type="text" name="button_two_label" value="{{ old('button_two_label',$item->button_two_label) }}"></div>
<div><label>Button 2 URL</label><input type="text" name="button_two_url" value="{{ old('button_two_url',$item->button_two_url) }}" placeholder="leasing-inquiry"><small style="display:block;color:#666;margin-top:4px">Path only under /dev/artsdiva (e.g. <code>leasing-inquiry</code>).</small></div>
<div><label>Image</label><input type="file" name="image" accept="image/*">@if($item->image)<p><img class="thumb" src="{{ asset($item->image) }}"></p>@endif</div>
<div><label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order',$item->sort_order ?? 0) }}"></div>
<label class="check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published',$item->is_published ?? true))> Published</label>
</div>
<div class="actions" style="margin-top:16px;"><button class="btn" type="submit">Save</button><a class="btn secondary" href="{{ route('admin.hero.index') }}">Cancel</a></div>
</form>
</div>
@endsection
