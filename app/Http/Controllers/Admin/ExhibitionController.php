<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exhibition;
use App\Support\MediaUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ExhibitionController extends Controller
{
    public function index()
    {
        return view('admin.exhibitions.index', [
            'items' => Exhibition::orderByDesc('id')->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.exhibitions.form', ['item' => new Exhibition]);
    }

    public function store(Request $request)
    {
        Exhibition::create($this->payload($request));

        return redirect()->route('admin.exhibitions.index')->with('success', 'Exhibition created.');
    }

    public function edit(Exhibition $exhibition)
    {
        return view('admin.exhibitions.form', ['item' => $exhibition]);
    }

    public function update(Request $request, Exhibition $exhibition)
    {
        $exhibition->update($this->payload($request, $exhibition));

        return redirect()->route('admin.exhibitions.index')->with('success', 'Exhibition updated.');
    }

    public function destroy(Exhibition $exhibition)
    {
        $exhibition->delete();

        return back()->with('success', 'Exhibition deleted.');
    }

    protected function payload(Request $request, ?Exhibition $exhibition = null): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180'],
            'subtitle' => ['nullable', 'string', 'max:180'],
            'dates' => ['nullable', 'string', 'max:180'],
            'location' => ['nullable', 'string', 'max:180'],
            'description' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:5120'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]);
        $data['slug'] = Str::slug($data['slug'] ?: $data['title']);
        $data['is_published'] = $request->boolean('is_published');
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);
        if ($request->hasFile('image')) {
            $data['image'] = MediaUploader::store($request->file('image'), 'exhibitions');
        } elseif ($exhibition) {
            unset($data['image']);
        }

        return $data;
    }
}
