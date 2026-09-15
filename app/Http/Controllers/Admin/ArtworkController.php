<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Artwork;
use App\Support\MediaUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ArtworkController extends Controller
{
    public function index(Request $request)
    {
        $q = trim((string) $request->input('q', ''));
        $items = Artwork::with('artist')
            ->when($q !== '', function ($query) use ($q) {
                $like = '%'.$q.'%';
                $query->where(function ($inner) use ($like) {
                    $inner->where('title', 'like', $like)
                        ->orWhere('serial_number', 'like', $like)
                        ->orWhere('slug', 'like', $like)
                        ->orWhereHas('artist', fn ($a) => $a->where('name', 'like', $like));
                });
            })
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.artworks.index', [
            'items' => $items,
            'q' => $q,
        ]);
    }

    public function create()
    {
        return view('admin.artworks.form', [
            'item' => new Artwork,
            'artists' => Artist::orderBy('name')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['slug'] ?: $data['title']);
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = MediaUploader::store($request->file('thumbnail'), 'artworks');
        }
        if ($request->hasFile('gallery_images')) {
            $gallery = [];
            foreach ($request->file('gallery_images') as $file) {
                $gallery[] = MediaUploader::store($file, 'artworks');
            }
            $data['gallery'] = array_filter($gallery);
        }

        // Newest artworks appear first in catalogue (lower sort_order).
        // Column is UNSIGNED — never use negative values (causes 500 on MySQL).
        $min = Artwork::query()->min('sort_order');
        if ($min === null) {
            $data['sort_order'] = 0;
        } elseif ((int) $min <= 0) {
            Artwork::query()->increment('sort_order');
            $data['sort_order'] = 0;
        } else {
            $data['sort_order'] = (int) $min - 1;
        }

        Artwork::create($data);

        return redirect()->route('admin.artworks.index')->with('success', 'Artwork created.');
    }

    public function edit(Artwork $artwork)
    {
        return view('admin.artworks.form', [
            'item' => $artwork,
            'artists' => Artist::orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Artwork $artwork)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['slug'] ?: $data['title']);
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = MediaUploader::store($request->file('thumbnail'), 'artworks');
        }
        if ($request->hasFile('gallery_images')) {
            $gallery = $artwork->gallery ?? [];
            foreach ($request->file('gallery_images') as $file) {
                $gallery[] = MediaUploader::store($file, 'artworks');
            }
            $data['gallery'] = array_values(array_filter($gallery));
        }
        $artwork->update($data);

        return redirect()->route('admin.artworks.index')->with('success', 'Artwork updated.');
    }

    public function destroy(Artwork $artwork)
    {
        $artwork->delete();

        return back()->with('success', 'Artwork deleted.');
    }

    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'artist_id' => ['nullable', 'exists:artists,id'],
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180'],
            'serial_number' => [
                'required',
                'string',
                'max:40',
                Rule::unique('artworks', 'serial_number')->ignore($request->route('artwork')),
            ],
            'city' => ['nullable', 'string', 'max:120'],
            'category' => ['nullable', 'string', 'max:80'],
            'price_eur' => ['required', 'numeric', 'min:0'],
            'dimensions' => ['nullable', 'string', 'max:80'],
            'weight' => ['nullable', 'string', 'max:40'],
            'year' => ['nullable', 'integer', 'min:1000', 'max:2100'],
            'medium' => ['nullable', 'string', 'max:120'],
            'description' => ['nullable', 'string'],
            'thumbnail' => ['nullable', 'image', 'max:5120'],
            'gallery_images.*' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
        $data['serial_number'] = strtoupper(trim($data['serial_number']));
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        unset($data['gallery_images']);

        return $data;
    }
}
