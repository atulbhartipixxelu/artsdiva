<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Support\MediaUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicationController extends Controller
{
    public function index()
    {
        return view('admin.publications.index', [
            'items' => Publication::orderByDesc('id')->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.publications.form', ['item' => new Publication]);
    }

    public function store(Request $request)
    {
        Publication::create($this->payload($request));

        return redirect()->route('admin.publications.index')->with('success', 'Publication created.');
    }

    public function edit(Publication $publication)
    {
        return view('admin.publications.form', ['item' => $publication]);
    }

    public function update(Request $request, Publication $publication)
    {
        $publication->update($this->payload($request, $publication));

        return redirect()->route('admin.publications.index')->with('success', 'Publication updated.');
    }

    public function destroy(Publication $publication)
    {
        $publication->delete();

        return back()->with('success', 'Publication deleted.');
    }

    protected function payload(Request $request, ?Publication $publication = null): array
    {
        $data = $request->validate([
            'artist_name' => ['required', 'string', 'max:180'],
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180'],
            'excerpt' => ['nullable', 'string'],
            'link_url' => ['nullable', 'url', 'max:255'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
        $data['slug'] = Str::slug($data['slug'] ?: $data['title']);
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        if ($request->hasFile('image')) {
            $data['image'] = MediaUploader::store($request->file('image'), 'publications');
        } elseif ($publication) {
            unset($data['image']);
        }

        return $data;
    }
}
