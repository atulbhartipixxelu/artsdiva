@extends('admin.layout')
@section('title', $item->exists ? 'Edit Artwork' : 'Add Artwork')
@section('heading', $item->exists ? 'Edit Artwork' : 'Add Artwork')
@section('content')
<div class="panel">
<form method="POST" enctype="multipart/form-data" action="{{ $item->exists ? route('admin.artworks.update',$item) : route('admin.artworks.store') }}">
@csrf
@if($item->exists) @method('PUT') @endif
<div class="form-grid">
<div><label>Title *</label><input type="text" name="title" value="{{ old('title',$item->title) }}" required></div>
<div><label>Serial number *</label><input type="text" name="serial_number" value="{{ old('serial_number',$item->serial_number) }}" required placeholder="0001" pattern="[A-Za-z0-9\-]+" title="Unique serial for this work"><small style="display:block;color:#666;margin-top:4px">Unique per artwork (e.g. <code>0001</code>). Required for inventory + frontend search.</small></div>
<div><label>Slug</label><input type="text" name="slug" value="{{ old('slug',$item->slug) }}"></div>
<div><label>Artist</label><select name="artist_id"><option value="">—</option>@foreach($artists as $a)<option value="{{ $a->id }}" @selected(old('artist_id',$item->artist_id)==$a->id)>{{ $a->name }}</option>@endforeach</select></div>
<div><label>Category</label><input type="text" name="category" value="{{ old('category',$item->category) }}"></div>
<div><label>City</label><input type="text" name="city" value="{{ old('city',$item->city) }}"></div>
<div><label>Price (EUR) *</label><input type="number" step="0.01" name="price_eur" value="{{ old('price_eur',$item->price_eur ?? 0) }}" required></div>
<div><label>Dimensions</label><input type="text" name="dimensions" value="{{ old('dimensions',$item->dimensions) }}"></div>
<div><label>Weight</label><input type="text" name="weight" value="{{ old('weight',$item->weight) }}"></div>
<div><label>Year</label><input type="number" name="year" value="{{ old('year',$item->year) }}"></div>
<div><label>Medium</label><input type="text" name="medium" value="{{ old('medium',$item->medium) }}"></div>
<div class="full"><label>Description</label><textarea name="description">{{ old('description',$item->description) }}</textarea></div>
<div><label>Thumbnail</label><input type="file" name="thumbnail" accept="image/*">@if($item->thumbnail)<p><img class="thumb" src="{{ asset($item->thumbnail) }}"></p>@endif</div>
<div><label>Gallery images</label><input type="file" name="gallery_images[]" accept="image/*" multiple></div>
<div><label>Sort order</label><input type="number" name="sort_order" value="{{ old('sort_order',$item->sort_order ?? 0) }}"></div>
<label class="check"><input type="checkbox" name="is_published" value="1" @checked(old('is_published',$item->is_published ?? true))> Published (saved in catalogue system)</label>
<label class="check"><input type="checkbox" name="is_visible" value="1" @checked(old('is_visible',$item->is_visible ?? false))> Visible on public site <small style="font-weight:400;color:#666">(only switch on when all fields are complete)</small></label>
<label class="check"><input type="checkbox" name="is_featured" value="1" @checked(old('is_featured',$item->is_featured ?? false))> Featured</label>
</div>
<div class="actions" style="margin-top:16px;"><button class="btn" type="submit">Save</button><a class="btn secondary" href="{{ route('admin.artworks.index') }}">Cancel</a></div>
</form>
</div>
@endsection