<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsPost;
use App\Support\MediaUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index()
    {
        return view('admin.news.index', [
            'items' => NewsPost::orderByDesc('id')->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.news.form', ['item' => new NewsPost]);
    }

    public function store(Request $request)
    {
        NewsPost::create($this->payload($request));

        return redirect()->route('admin.news.index')->with('success', 'News created.');
    }

    public function edit(NewsPost $news)
    {
        return view('admin.news.form', ['item' => $news]);
    }

    public function update(Request $request, NewsPost $news)
    {
        $news->update($this->payload($request, $news));

        return redirect()->route('admin.news.index')->with('success', 'News updated.');
    }

    public function destroy(NewsPost $news)
    {
        $news->delete();

        return back()->with('success', 'News deleted.');
    }

    protected function payload(Request $request, ?NewsPost $news = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => ['nullable', 'string'],
            'published_at' => ['nullable', 'date'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);
        $data['slug'] = Str::slug($data['slug'] ?: $data['title']);
        $data['is_published'] = $request->boolean('is_published');
        if ($request->hasFile('image')) {
            $data['image'] = MediaUploader::store($request->file('image'), 'news');
        } elseif ($news) {
            unset($data['image']);
        }

        return $data;
    }
}
