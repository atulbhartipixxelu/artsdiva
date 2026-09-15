<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Support\MediaUploader;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('admin.pages.index', [
            'items' => Page::orderBy('title')->paginate(20),
        ]);
    }

    public function edit(Page $page)
    {
        return view('admin.pages.form', ['item' => $page]);
    }

    public function update(Request $request, Page $page)
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'body' => ['nullable', 'string'],
            'cta_label' => ['nullable', 'string', 'max:120'],
            'cta_url' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:5120'],
        ]);
        $data['is_published'] = $request->boolean('is_published');
        if ($request->hasFile('image')) {
            $data['image'] = MediaUploader::store($request->file('image'), 'pages');
        }
        $page->update($data);

        return redirect()->route('admin.pages.index')->with('success', 'Page updated.');
    }
}
