<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Support\MediaUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArtistController extends Controller
{
    public function index()
    {
        return view('admin.artists.index', [
            'items' => Artist::orderByDesc('id')->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.artists.form', ['item' => new Artist]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['slug'] ?: $data['name']);
        if ($request->hasFile('image')) {
            $data['image'] = MediaUploader::store($request->file('image'), 'artists');
        }
        Artist::create($data);

        return redirect()->route('admin.artists.index')->with('success', 'Artist created.');
    }

    public function edit(Artist $artist)
    {
        return view('admin.artists.form', ['item' => $artist]);
    }

    public function update(Request $request, Artist $artist)
    {
        $data = $this->validated($request);
        $data['slug'] = Str::slug($data['slug'] ?: $data['name']);
        if ($request->hasFile('image')) {
            $data['image'] = MediaUploader::store($request->file('image'), 'artists');
        }
        $artist->update($data);

        return redirect()->route('admin.artists.index')->with('success', 'Artist updated.');
    }

    public function destroy(Artist $artist)
    {
        $artist->delete();

        return back()->with('success', 'Artist deleted.');
    }

    protected function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180'],
            'city' => ['nullable', 'string', 'max:120'],
            'country' => ['nullable', 'string', 'max:120'],
            'bio' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:4096'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
        $data['is_featured'] = $request->boolean('is_featured');
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        return $data;
    }
}
